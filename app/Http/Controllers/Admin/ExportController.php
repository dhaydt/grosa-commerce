<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start = $request['start-date'];
        $end = $request['end-date'];

        if ($start == $end) {
            $orders = Order::where('created_at', 'like', "%{$start}%")->whereHas('details', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('added_by', 'admin');
                });
            })->with(['customer'])->with(['details'])->get();
        } else {
            $orders = Order::whereBetween('created_at', [$start, $end])->whereHas('details', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('added_by', 'admin');
                });
            })->with(['customer'])->with(['details'])->get();
        }

        // dd($orders);
        // $export = $orders->map(function ($order, $i) {
        //     $shipping = $order->shipping_address_data;
        //     $arr = json_decode($shipping);
        //     $detail = $order->details->first();
        //     $products = json_decode(($detail->product_details));

        $export = $orders->map(function ($order, $i) {
            $shipping = $order->shipping_address_data;
            $arr = json_decode($shipping);
            $detail = $order->details;

            $prod = $detail->map(function ($det) {
                $p = json_decode($det->product_details);

                return $p->name;
            });

            $var = $detail->map(function ($det) {
                return $det->variation;
            });

            $qty = $detail->map(function ($det) {
                return $det->qty;
            });

            $siku = ['[', ']', '"'];
            $rep = ['', '', ' '];
            $exProd = str_replace($siku, $rep, $prod);

            $siku2 = ['[]', '[', ']', '"'];
            $rep2 = ['-', '', '', ' '];
            $exVar = str_replace($siku2, $rep2, $var);

            $siku3 = ['[', ']'];
            $rep3 = ['', ''];
            $exQty = str_replace($siku3, $rep3, $qty);

            return [
            'order_date' => date('d F Y, h:i:s A', strtotime($order->created_at)),
            'delivery_date' => date('d F Y', strtotime($order->delivery_date)),
            'customer_name' => $arr->contact_person_name,
            'product_name' => $prod,
            'variation' => $var,
            'Qty' => $qty,
            'price' => $order->order_amount,
            'order_no' => $detail[0]['order_id'],
            'payment' => $order->payment_method,
        ];
        });

        $data = [];
        foreach ($export as $item => $key) {
            $each = [];
            foreach ($key as $k => $value) {
                // $valu = "{{$f} : {{$val} : {$person}}}"

                $valu = $value;

                // echo ;
                array_push($each, $valu);
            }
            array_push($data, $each);
        }

        // dd($data);

        // $fam = ['thom' => ['room' => 'shane'],
        //     'andy' => ['cousin' => 'michelle', 'mother' => 'shope'],
        //      'jwall' => ['friend' => 'chunk'], ];

        // $data = [];
        // foreach ($fam as $f => $value) {
        //     // array_push($data, [$f => $value]);
        //     foreach ($value as $val => $person) {
        //         // $valu = "{{$f} : {{$val} : {$person}}}"
        //         $valu = [$f => [$val => $person]];

        //         // echo ;
        //         array_push($data, $valu);
        //     }
        // }
        // dd($data);

        // $data = [];
        // foreach ($export as $item => $key) {
        //     $row = [];
        //     // dd(count($key));
        //     foreach ($key as $k => $val) {
        //         if (is_object($val)) {
        //             $r = [$k => $val];
        //             array_push($row, $r);
        //             if (count($val) > 1) {
        //                 foreach ($val as $v) {
        //                     array_push($data, [$k => $v]);
        //                 }
        //             }
        //         } else {
        //             // array_push($row, [$k => $val]);
        //         }
        //     }
        //     array_push($data, $row);
        // }
        // dd($export);
        // $data = Order::whereBetween('created_at', [$start, $end])->get();
        // $order = Order::whereBetween('delivery_date', [$start, $end])->get();

        return Excel::download(new OrderExport($data), 'rekap'.$start.' to '.$end.'.xlsx');
    }
}
