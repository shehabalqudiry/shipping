<?php

namespace App\Http\Controllers;

use App\Models\ShipmentRate;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function sumExpress(Request $request)
    {
        $value = 0;
        $shipRate = ShipmentRate::where(['city_from' => $request->city_from, 'city_to' => $request->city_to])
                                    ->orWhere(['city_from' => $request->city_to, 'city_to' => $request->city_from])
                                    ->first();
        if (!$shipRate) {
            return back()->with('value', $value . ' لم يتم تحديد سعر الشحن بعد');
        }
        if(in_array($request->wighte, range(1,10))){
            $value = $shipRate->rate;
        } elseif (in_array($request->wighte, range(11, 20))) {
            $value = $shipRate->rate * 1.5;
        } elseif (in_array($request->wighte, range(21, 30))) {
            $value = $shipRate->rate * 2;
        } elseif (in_array($request->wighte, range(31, 40))) {
            $value = $shipRate->rate * 2.5;
        } elseif (in_array($request->wighte, range(41, 50))) {
            $value = $shipRate->rate * 3.5;
        } elseif (in_array($request->wighte, range(51, 60))) {
            $value = $shipRate->rate * 4.5;
        } elseif (in_array($request->wighte, range(61, 70))) {
            $value = $shipRate->rate * 5.5;
        } elseif (in_array($request->wighte, range(71, 80))) {
            $value = $shipRate->rate * 6.5;
        } elseif (in_array($request->wighte, range(81, 90))) {
            $value = $shipRate->rate * 7.5;
        } elseif (in_array($request->wighte, range(91, 100))) {
            $value = $shipRate->rate * 8.5;
        }elseif (in_array($request->wighte, range(101, 105))) {
            $value = $shipRate->rate * 9.5;
        }
        return back()->with('value', $value);
    }
}
