<?php

namespace App\Http\Controllers;

use App\Exports\ShipmentsExport;
use App\Models\Address;
use App\Models\City;
use App\Models\EditOrder;
use App\Models\Shipment;
use App\Models\ShipmentRate;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Octw\Aramex\Aramex;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ExpressController extends Controller
{

    public function __construct()
	{
        if (auth('team')->check()) {
            $this->middleware(['auth:team']);
        } else{
            $this->middleware(['auth']);
        }

	}

    public function export(Request $request)
    {
        $fileName = 'shipments_' . $request->from . '_' . $request->to . '.' . $request->fileType;
        return Excel::download(new ShipmentsExport($request), $fileName);
        // return back()->with('success', __('The action ran successfully!'));
    }

    public function index(Request $request)
    {
        $ships = Shipment::where('user_id', auth()->user()->id)->latest()->get();
        if ($request->from) {
            $ships = Shipment::whereBetween('created_at', [$request->from, $request->to])
                                ->where('status', 'LIKE', "%$request->status%")
                                ->where('cash_on_delivery_amount', 'LIKE',"%$request->cod%")
                                ->where('consignee_phone', 'LIKE',"%$request->phone%")
                                ->where('user_id', auth()->user()->id)
                                ->latest()->get();
        }

        return view('pages.user.express.shipping', compact('ships'));
    }

    public function create()
    {
        return view('pages.user.express.create');
    }

    public function show($id)
    {
        $generator = new BarcodeGeneratorPNG();
        $shipment = Shipment::where(['id' => $id, 'user_id' => auth()->user()->id])->first();
        $editOrders = EditOrder::where(['shipment_id' => $id, 'user_id' => auth()->user()->id])->latest()->get();
        if ($shipment) {
            // dd($shipment);
            $data = Aramex::trackShipments([$shipment->shipmentID]);
            $barcode = base64_encode($generator->getBarcode($shipment->shipmentID, $generator::TYPE_CODE_128));
            if (isset($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult)){
                if (!$data->HasErrors){
                    if($shipment->status !== 3 || $shipment->status !== 2){
                        if($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult == []){
                            if($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult[0]->UpdateCode == "SH014"){
                                $shipment->update(['status' => 0]);
                            }

                            elseif ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult[0]->UpdateCode == "SH003"){
                                $shipment->update(['status' => 1]);
                            }
                            elseif ($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult[0]->UpdateCode == "SH005"){
                                $shipment->update(['status' => 2]);
                            }
                        }
                    }

                    return view('pages.user.express.show', compact('shipment', 'data', 'barcode', 'editOrders'));
                } else {
                    return "ERROR IN SHIPMENT";
                }
            }
            return view('pages.user.express.show', compact('shipment', 'barcode', 'editOrders'));
            // dd($data);
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        if ($request->shipments) {
            foreach ($request->shipments as $ship) {
                // dd($ship);
                $shipper = Address::findOrFail($ship['shipper']);
                $city = City::where('id', $shipper->city)->first();
                $destinationCity = City::where('id', $ship['consignee_city'])->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name,
                        'email' => auth()->user()->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name,
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $ship['consignee_name'],
                        'email' => auth()->user()->email,
                        'phone' => $ship['consignee_phone'],
                        'cell_phone' => $ship['consignee_cell_phone'],
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'line1' => $ship['consignee_line1'] ?? $destinationCity->name,
                        'line2' => $ship['consignee_line2'] ?? $destinationCity->name,
                    ],
                    // 'shipping_date_time' => now()->addHours(604800)->timestamp,
                    'reference' => $ship['reference'],
                    'shipper_reference' => $ship['reference'],
                    'shipping_date_time' => time() + 50000,
                    'due_date' => time() + 60000,
                    'comments' => $ship['comments'] ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($ship['cash_on_delivery_amount'], 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    'customs_value_amount' => 0,
                    'weight' => $ship['weight'],
                    'number_of_pieces' => $ship['number_of_pieces'],
                    'description' => $ship['description'],
                ];
                // dd($shipmentDetails);
                $callResponse = Aramex::createShipment($shipmentDetails);
                // if (false) {
                if (!empty($callResponse->error)) {
                    foreach ($callResponse->errors as $errorObject) {
                        return $errorObject->Code . ' => ' . $errorObject->Message;
                    }
                } else {
                    $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
                    $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
                    // dd($putFile);
                    // $fileUpload = Storage::putFile('lables/' . $callResponse->Shipments->ProcessedShipment->ID . '/' , $putFile);
                    // dd($callResponse);
                    $data = [
                        'user_id' => auth()->user()->id,
                        'address_id' => $shipper->id,
                        'consignee_name' => $shipmentDetails['consignee']['name'],
                        'consignee_email' => $shipmentDetails['consignee']['email'],
                        'consignee_phone' => $shipmentDetails['consignee']['phone'],
                        'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                        'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                        'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                        'consignee_line1' => $shipmentDetails['consignee']['line1'],
                        'consignee_line2' => $shipmentDetails['consignee']['line2'],
                        'consignee_line3' => $shipmentDetails['consignee']['line2'],
                        'consignee_city' => $ship['consignee_city'],

                        // Shipment Data
                        'reference' => $ship['reference'],
                        'shipping_date_time'    => $shipmentDetails['shipping_date_time'],
                        'due_date'  => $shipmentDetails['due_date'],
                        'comments'  => $shipmentDetails['comments'],
                        'pickup_location'   => $shipmentDetails['pickup_location'],
                        'pickup_guid'   => $shipmentDetails['pickup_guid'],
                        'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
                        'product_group' => $shipmentDetails['product_group'],
                        'product_type'  => $shipmentDetails['product_type'],
                        'payment_type'  => $shipmentDetails['payment_type'],
                        'customs_value_amount'  => 0,
                        'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $ship['weight']),
                        'weight'    => $shipmentDetails['weight'],
                        'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                        'description'   => $shipmentDetails['description'],
                        'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                        'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                        'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
                    ];
                    $ship = Shipment::create($data);
                }

            }
            return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
        }else {

            $validator = Validator::make($request->all(),[
                "consignee_name"  => "required|min:3",
                "consignee_phone"  => "required|min:8",
                "consignee_city"  => "required",
                "cash_on_delivery_amount"  => "required",
            ]);
            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput();
            }
            // dd(Aramex::fetchCities('JO'));
            try {
                //code...
                $shipper = Address::findOrFail($request->shipper);
                $city = City::where('id', $shipper->city)->first();
                $destinationCity = City::where('id', $request->consignee_city)->first();
                $shipmentDetails = [
                    'shipper' => [
                        'name' => $shipper->name,
                        'email' => auth()->user()->email,
                        'phone' => $shipper->phone,
                        'cell_phone' => $shipper->phone,
                        'country_code' => 'JO',
                        'city' => $city->name,
                        'zip_code' => '',
                        'line1' => $shipper->desc,
                        'line2' => $shipper->desc,
                    ],
                    'consignee' => [
                        'name' => $request->consignee_name,
                        'email' => auth()->user()->email,
                        'phone' => $request->consignee_phone,
                        'cell_phone' => $request->consignee_cell_phone,
                        'country_code' => 'JO',
                        'city' => $destinationCity->name,
                        'zip_code' => '',
                        'line1' => $request->consignee_line1,
                        'line2' => $request->consignee_line2,
                    ],
                    // 'shipping_date_time' => now()->addHours(604800)->timestamp,
                    'reference' => $request->reference,
                    'shipper_reference' => $request->reference,
                    'shipping_date_time' => time() + 50000,
                    'due_date' => time() + 60000,
                    'comments' => $request->comments ?? 'No Comment',
                    'pickup_location' => 'at reception',
                    'pickup_guid' => null,
                    'services' => 'CODS',
                    'cash_on_delivery_amount' => floatval(number_format($request->cash_on_delivery_amount, 2)),
                    'product_group' => 'DOM', // or EXP (defined in config file, if you dont pass it will take the config value)
                    'product_type' => 'COM', // refer to the official documentation (defined in config file, if you dont pass it
                    'payment_type' => 'P',
                    'customs_value_amount' => 0,
                    'weight' => $request->weight,
                    'number_of_pieces' => $request->number_of_pieces,
                    'description' => $request->description,
                ];
                // dd($shipmentDetails);
                $callResponse = Aramex::createShipment($shipmentDetails);
                // if (false) {
                if (!empty($callResponse->error)) {
                    foreach ($callResponse->errors as $errorObject) {
                        return $errorObject->Code . ' => ' . $errorObject->Message;
                    }
                } else {
                    $file =  file_get_contents($callResponse->Shipments->ProcessedShipment->ShipmentLabel->LabelURL);
                    $putFile = file_put_contents($callResponse->Shipments->ProcessedShipment->ID . '.pdf', $file);
                    // dd($putFile);
                    // $fileUpload = Storage::putFile('lables/' . $callResponse->Shipments->ProcessedShipment->ID . '/' , $putFile);
                    // dd($callResponse);
                    $data = [
                        'user_id' => auth()->user()->id,
                        'address_id' => $shipper->id,
                        'consignee_name' => $shipmentDetails['consignee']['name'],
                        'consignee_email' => $shipmentDetails['consignee']['email'],
                        'consignee_phone' => $shipmentDetails['consignee']['phone'],
                        'consignee_cell_phone' => $shipmentDetails['consignee']['cell_phone'],
                        'consignee_zip_code' => $shipmentDetails['consignee']['zip_code'],
                        'consignee_country_code' => $shipmentDetails['consignee']['country_code'],
                        'consignee_line1' => $shipmentDetails['consignee']['line1'],
                        'consignee_line2' => $shipmentDetails['consignee']['line2'],
                        'consignee_line3' => $shipmentDetails['consignee']['line2'],
                        'consignee_city' => $request->consignee_city,

                        // Shipment Data
                        'reference' => $request->reference,
                        'shipping_date_time'    => $shipmentDetails['shipping_date_time'],
                        'due_date'  => $shipmentDetails['due_date'],
                        'comments'  => $shipmentDetails['comments'],
                        'pickup_location'   => $shipmentDetails['pickup_location'],
                        'pickup_guid'   => $shipmentDetails['pickup_guid'],
                        'cash_on_delivery_amount'   => $shipmentDetails['cash_on_delivery_amount'],
                        'product_group' => $shipmentDetails['product_group'],
                        'product_type'  => $shipmentDetails['product_type'],
                        'payment_type'  => $shipmentDetails['payment_type'],
                        'customs_value_amount'  => 0,
                        'collect_amount' => $this->sumExpress($shipper->city, $shipper->city, $request->weight),
                        'weight'    => $shipmentDetails['weight'],
                        'number_of_pieces'  => $shipmentDetails['number_of_pieces'],
                        'description'   => $shipmentDetails['description'],
                        'shipmentID' => $callResponse->Shipments->ProcessedShipment->ID,
                        'shipmentLabelURL' => $callResponse->Shipments->ProcessedShipment->ID . '.pdf',
                        'shipmentAttachments' => $callResponse->Shipments->ProcessedShipment->ShipmentAttachments->ProcessedShipmentAttachment->Url ?? 'N/A',
                    ];
                    $ship = Shipment::create($data);
                }

                return redirect()->route('front.express.index')->with('success', 'تم اضافة الشحنة بنجاح');
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }
        }
    }

    public function orderAramex(Request $request)
    {
        $shipments = Shipment::where(['user_id' => auth()->user()->id, 'status' => 0])->get();
        if ($shipments->count() !== 0) {
            foreach ($shipments as $shipment) {
                $timeS = \Carbon\Carbon::parse('10:00');
                $timeE = \Carbon\Carbon::parse('16:00');
                if($timeS > now() || now() < $timeE && $timeS->addHours(2) < $timeE){
                    $timeS = now();
                }else {
                    $timeS->addDay();
                    $timeE->addDay();
                }
                $shipper = Address::find($shipment->address_id);
                $city = City::where('id', $shipper->city)->first();
                $data = Aramex::createPickup([
                    'name' => $shipper->name,
                    'cell_phone' => $shipper->phone,
                    'phone' => $shipper->phone,
                    'email' => $shipper->email,
                    'city' => $city->name,
                    'country_code' => 'JO',
                    'zip_code'=> '',
                    'line1' => $shipper->desc,
                    'line2' => '',
                    'line3' => '',
                    "pickup_date" => $timeS->timestamp, // time parameter describe the date of the pickup
                    "ready_time" => $timeS->addHours(2)->timestamp, // time parameter describe the ready pickup date
                    "last_pickup_time" => $timeS->addHours(2)->timestamp, // time parameter
                    "closing_time" => $timeE->timestamp + 10000, // time parameter
                    'status' => 'Ready',
                    'pickup_location' => 'some location',
                    'weight' => $shipment->weight,
                    'volume' => '0',
                    'number_of_shipments' => '1',
                    'shipments' => $shipment,
                ]);
                // extracting GUID
                if (!$data->error){
                    $guid = $data->pickupGUID;
                    $shipment->update(['status' => 1]);
                } else {
                    // dd($data);
                    return back()->with('error', $data->errors[0]->Message ?? '');
                }
            }
            return back()->with('success', __('The action ran successfully!'));
        }
        return back()->with('success', __('No Results Found.'));
    }
    public function sumExpress($city_from, $city_to, $wighte)
    {
        $value = 0;
        $user_id = auth()->user()->id;
        $shipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->first();

        $userShipRate = ShipmentRate::where(['city_from' => $city_from, 'city_to' => $city_to])
                                    ->orWhere(['city_from' => $city_to, 'city_to' => $city_from])
                                    ->where('user_id', $user_id)->first();
        if (!$shipRate || !$userShipRate) {
            return $value;
        }

        if($userShipRate){
            $shipRate = $userShipRate;
        }
        if(in_array($wighte, range(1,10))){
            $value = $shipRate->rate;
        } elseif (in_array($wighte, range(11, 20))) {
            $value = $shipRate->rate * 1.5;
        } elseif (in_array($wighte, range(21, 30))) {
            $value = $shipRate->rate * 2;
        } elseif (in_array($wighte, range(31, 40))) {
            $value = $shipRate->rate * 2.5;
        } elseif (in_array($wighte, range(41, 50))) {
            $value = $shipRate->rate * 3.5;
        } elseif (in_array($wighte, range(51, 60))) {
            $value = $shipRate->rate * 4.5;
        } elseif (in_array($wighte, range(61, 70))) {
            $value = $shipRate->rate * 5.5;
        } elseif (in_array($wighte, range(71, 80))) {
            $value = $shipRate->rate * 6.5;
        } elseif (in_array($wighte, range(81, 90))) {
            $value = $shipRate->rate * 7.5;
        } elseif (in_array($wighte, range(91, 100))) {
            $value = $shipRate->rate * 8.5;
        }elseif (in_array($wighte, range(101, 105))) {
            $value = $shipRate->rate * 9.5;
        }
        return $value;
    }


    public function shipment_update(Request $request)
    {
        $editOrder = EditOrder::create([
            'type'          => 'تعديل بيانات شحنة',
            'desc'          => $request->desc,
            'user_id'       => auth()->user()->id,
            'shipment_id'   => $request->shipment_id,
        ]);

        NotificationController::NewOrderNotification([
            'user_id'       => auth()->user()->id,
            'type'          => 'تعديل بيانات شحنة',
            'shipment_id'   => $request->shipment_id,
            'body'          => $request->desc,
        ]);
        return back()->with('success', 'تم ارسال طلبك بنجاح');
    }
}
