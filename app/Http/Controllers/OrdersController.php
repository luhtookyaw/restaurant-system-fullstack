<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {   
        $tables = Table::all();
        $dishes = Dish::orderBy('id', 'desc')->get();
        $orders = Order::select('id', 'dish_id', 'table_id', 'status')->whereIn('status', [3, 4])->orderBy('status')->get();

        return Inertia::render('OrderForm', [ 'dishes' => $dishes, 'tables' => $tables, 'orders' => $orders ]);
    }

    public function submit(Request $request)
    {
        request()->validate([
            'table' => 'required'
        ]);

        $data = array_filter($request->except(["_token", "table"]));
        
        foreach($data as $key => $value) {
            if($value > 1) {
                for($ind=1; $ind <= $value; $ind++){
                    Order::create(['dish_id' => $key, 
                                    'table_id' => $request->table,
                                    'status' => config('orderstatus.status.new')
                                ]);
                }
            }else {
                Order::create(['dish_id' => $key, 
                    'table_id' => $request->table,
                    'status' => config('orderstatus.status.new')
                ]);
            }
        }

        return redirect('/')->with('orders', 'Order Submited!');
    }

    public function serve(Order $order)
    {
        $order->status = config('orderstatus.status.done');
        $order->save();
        return redirect('/')->with('served', 'Order '.$order->id.' serves to table '.$order->table_id.'!');
    }
}
