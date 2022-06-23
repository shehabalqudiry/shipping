<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\TransactionsImport;
use App\Models\Address;
use App\Models\City;
use App\Models\EditOrder;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Octw\Aramex\Aramex;
use Picqer\Barcode\BarcodeGeneratorPNG;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shipments = Shipment::latest()->get();
        return view('admin.shipments.index', compact('shipments'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Shipment $shipment)
    {
        $generator = new BarcodeGeneratorPNG();
        $editOrders = EditOrder::where(['shipment_id' => $shipment->id])->get();
        if ($shipment) {
            // dd($shipment);
            $data = Aramex::trackShipments([$shipment->shipmentID]);
            // dd($data);
            $barcode = base64_encode($generator->getBarcode($shipment->shipmentID, $generator::TYPE_CODE_128));
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
                    } else {
                        if($data->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult->UpdateCode == "SH014"){
                            $shipment->update(['status' => 0]);
                        }
                    }
                }

                return view('admin.shipments.show', compact('shipment', 'data', 'barcode', 'editOrders'));
                // return view('admin.shipments.show', compact('shipment'));
            }
            else {
                return "ERROR IN SHIPMENT";
            }
        }
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.shipments.edit', compact('shipment'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $shipper = Address::findOrFail($request->shipper);
        $data = [
            'address_id' => $shipper->id,
            'consignee_name' => $request->consignee_name,
            'consignee_phone' => $request->consignee_phone,
            'consignee_cell_phone' => $request->consignee_cell_phone,
            'consignee_line1' => $request->consignee_line1,
            'consignee_line2' => $request->consignee_line2,
            'consignee_line3' => $request->consignee_line2,
            'consignee_city' => $request->consignee_city,

            // Shipment Data
            'shipping_date_time' => time() + 50000,
            'due_date' => time() + 60000,
            'comments' => $request->comments ?? 'No Comment',
            'cash_on_delivery_amount' => floatval(number_format($request->cash_on_delivery_amount, 2)),
            'weight' => $request->weight,
            'number_of_pieces' => $request->number_of_pieces,
            'description' => $request->description,
        ];
        $shipment->update($data);

        return back()->with("success","تم تعديل البيانات بنجاح");
    }

    public function destroy(Shipment $shipment)
    {
        //
    }



    // Imports
    public function import_create()
    {
        return view('admin.shipments.create');
    }

    public function import_store(Request $request)
    {
        Excel::import(new TransactionsImport($request->user_id), $request->file('importFile'));

        return back()->with('success', 'تم تحميل البيانات');
    }
}
