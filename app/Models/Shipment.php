<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function get_status()
    {
        $status = $this->status;
        switch ($status) {
            case 0:
                $statusMsg = 'New';
                break;

            case 1:
                $statusMsg = 'Processing';
                break;

            case 2:
                $statusMsg = 'Delivered';
                break;

            case 3:
                $statusMsg = 'Returned';
                break;

            case 4:
                $statusMsg = 'Pending Payments';
                break;
            case 5:
                $statusMsg = 'Payment Successfully';
                break;

            default:
                $statusMsg = 'Draft';
                break;
        }
        return $statusMsg;
    }
}
