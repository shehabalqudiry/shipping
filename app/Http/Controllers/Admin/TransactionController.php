<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Company;
use App\Models\Shipment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['super_admin']);
    // }
    public function index()
    {
        $transactions = Transaction::get();
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('admin.transactions.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'name_ku' => 'required',
            'company' => 'required',
            'photo'   => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        Transaction::create([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ],
            'company_id' => $request->company,
            'photo'      => $request->hasFile('photo') ? uploadImage('transactions', $request->file('photo')) : 'images/default.png',
        ]);
        return redirect()->route('admin.transactions.index')->with("success","تم اضافة القسم بنجاح");
    }

    public function show(Transaction $Transaction)
    {
        $awb = [];
        foreach ($Transaction->imports as $im) {
            $awb[] = $im->AWB;
        }

        $shipments = Shipment::whereIn('shipmentID', $awb)->get();
        // $shipments = $awb;
        return view('admin.transactions.show', compact(['shipments']));
    }

    public function edit(Transaction $Transaction)
    {
        $companies = Company::get();
        return view('admin.transactions.edit', compact(['Transaction', 'companies']));
    }

    public function update(Request $request, Transaction $Transaction)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'name_ku' => 'required',
            'company' => 'required',
            'photo'   => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        $Transaction->update([
            'name' => [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ],
            'company_id' => $request->company,
            'photo'      => $request->hasFile('photo') ? uploadImage('transactions', $request->file('photo')) : $Transaction->photo,
        ]);
        return redirect()->route('admin.transactions.index')->with("success","تم تعديل القسم بنجاح");
    }

    public function destroy(Transaction $Transaction)
    {
        if ($Transaction->photo !== 'images/default.png') {
            Storage::delete($Transaction->photo);
        }
        $Transaction->delete();
        return redirect()->route('admin.transactions.index')->with("success","تم حذف البيانات بنجاح");
    }
}
