<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Address;
use App\Models\City;
use App\Models\Company;
use App\Models\EditOrder;
use App\Models\PaymentMethod;
use App\Models\Shipment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;file:///home/shehabalqudiry/Downloads/Form-Fields-Repeater/index.html

use Aramex;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
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
        $fileName = 'transactions_' . $request->from . '_' . $request->to . '.' . $request->fileType;
        return Excel::download(new TransactionsExport($request), $fileName);
        // return back()->with('success', __('The action ran successfully!'));
    }
    public function index(Request $request)
    {
        $shipments = new Shipment();
        $transactions = Transaction::where('user_id', auth()->user()->id)->latest()->get();
        if ($request->from) {
            $transactions = Transaction::where('user_id', auth()->user()->id)->whereBetween('created_at', [$request->from, $request->to])->latest()->get();
        }
        foreach ($transactions as $transaction) {
            $awb = [];
            foreach ($transaction->imports as $im) {
                $awb[] = $im->AWB;
            }

            $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->latest()->get();
        }
        return view('pages.user.payments.index', compact('transactions', 'shipments'));
    }

    public function show($transaction)
    {
        $transaction = Transaction::where(['id' => $transaction, 'user_id' => auth()->user()->id])->first();
        if (!$transaction) {
            return back()->with('error', 'Not Found');
        }
        $awb = [];
        foreach ($transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->where('user_id', auth()->user()->id)->latest()->get();
        // $shipments = $awb;
        return view('pages.user.payments.show', compact(['shipments']));
    }
}
