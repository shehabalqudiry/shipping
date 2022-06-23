<?php

namespace App\Exports;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ShipmentsExport implements FromView
{
    public $request;
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function view(): View
    {
        $shipments = Shipment::where('user_id', auth()->user()->id)->whereBetween('created_at', [$this->request->from, $this->request->to])->get();
        return view('pages.user.express.export', [
            'shipments' => $shipments
        ]);
    }

    // Transaction::whereDateBetween('created_at', [$this->request->from, $this->request->to])->get();
}
