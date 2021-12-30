<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Order;
use App\User;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start = $request['start-date'];
        $end = $request['end-date'];
        $order = Order::whereBetween('delivery_date', [$start, $end])->get();

        // dd($order);

        return (new FastExcel(User::all()))->export('file.xlsx');
    }
}
