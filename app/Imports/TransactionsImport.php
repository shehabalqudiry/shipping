<?php

namespace App\Imports;

use App\Models\Shipment;
use App\Models\Transaction;
use App\Models\ShipmentImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToCollection, WithHeadingRow
{
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection(Collection $rows)
    {
        if ($this->user) {
            $transaction =  Transaction::create([
                'value' => $rows->sum('codvalue'),
                'user_id' => $this->user,
                'image'     => 'N/A',
            ]);
            foreach ($rows as $row) {
                $shipment = Shipment::where('shipmentID', $row['awb'])->first();
                if($shipment)
                {
                    $shipment->update(['status' => 4]);
                }
                $shipImport = ShipmentImport::create([
                    'AWB'                   => $row['awb'],
                    'CODValue'              => $row['codvalue'],
                    'ShipperNumber'         => $row['shippernumber'],
                    'ShipperReference'      => $row['shipperreference'],
                    'ShipperReference2'     => $row['shipperreference2'],
                    'ShipperName'           => $row['shippername'],
                    'user_id'               => $this->user,
                    'transaction_id'        => $transaction->id,
                ]);
            }

        }else {
            return abort(404, 'User Not Found');
        }

    }
}
