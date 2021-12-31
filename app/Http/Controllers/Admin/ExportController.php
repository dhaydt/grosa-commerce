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
        $users = [
            [
                'id' => 1,
                'name' => 'Hardik',
                'email' => 'hardik@gmail.com',
            ],
            [
                'id' => 2,
                'name' => 'Vimal',
                'email' => 'vimal@gmail.com',
            ],
            [
                'id' => 3,
                'name' => 'Harshad',
                'email' => 'harshad@gmail.com',
            ],
        ];

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
        $export = $orders->map(function ($order, $i) {
            $shipping = $order->shipping_address_data;
            $arr = json_decode($shipping);
            $detail = $order->details->first();
            $products = json_decode(($detail->product_details));

            return ['no' => $i + 1,
            'order_date' => date('d F Y, h:i:s A', strtotime($order->created_at)),
            'delivery_date' => date('d F Y', strtotime($order->delivery_date)),
            'customer_name' => $arr->contact_person_name,
            'product_name' => $products->name,
            'variation' => $detail->variation,
            'Qty' => $detail->qty,
            'price' => $order->order_amount,
            'order_no' => $detail->order_id,
            'payment' => $order->payment_method,
        ];
        });
        // $data = Order::whereBetween('created_at', [$start, $end])->get();
        // $order = Order::whereBetween('delivery_date', [$start, $end])->get();

        return Excel::download(new OrderExport($export), 'rekap'.$start.' to '.$end.'.xlsx');
    }
}
