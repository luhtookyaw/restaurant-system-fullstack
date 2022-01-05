<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\DishCreateRequest;
use Illuminate\Support\Facades\Redirect;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    
    public function index()
    {
        $dishes = Dish::all('id', 'name', 'category_id', 'image');
        $categories = Category::all();
        return Inertia::render('DishDashboard', [ 'dishes' => $dishes, 'categories' => $categories ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DishCreateRequest $request)
    {
        $dish = new Dish();
        $dish->name = $request->name;
        $dish->category_id = $request->category;

        $imageName = date('YmdHis').".".request()->image->getClientOriginalExtension();
        request()->image->move(public_path('images'), $imageName);
        $dish->image = $imageName;

        $dish->save();

        return redirect('dashboard')->with('success', 'Dish successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return Inertia::render('DishEdit', ['dish' => $dish, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dish $dish)
    {
        request()->validate([
            'name' => 'required',
            'category' => 'required'
        ]);
        $dish->name = $request->name;
        $dish->category_id = $request->category;
        if($request->image){
            $imageName = date('YmdHis').".".request()->image->getClientOriginalExtension();
            request()->image->move(public_path('images'), $imageName);
            $dish->image = $imageName;
        }
        $dish->save();

        return redirect('dashboard')->with('updated', 'Dish successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dish $dish)
    {
        $dish->delete();
        return redirect('dashboard')->with('deleted', 'Dish successfully deleted!');
    }

    public function order()
    {
        $orders = Order::select('id', 'dish_id', 'table_id', 'status')->whereIn('status', [1, 2])->get();

        return Inertia::render('OrderDashboard', ['orders' => $orders,]);
    }

    public function approve(Order $order)
    {
        $order->status = config('orderstatus.status.processing');
        $order->save();
        return redirect('/dashboard/orders')->with('approved', 'Order successfully approved!');
    }

    public function cancel(Order $order)
    {
        $order->status = config('orderstatus.status.cancel');
        $order->save();
        return redirect('/dashboard/orders')->with('cancel', 'Order have been canceled!');
    }
    public function ready(Order $order)
    {
        $order->status = config('orderstatus.status.ready');
        $order->save();
        return redirect('/dashboard/orders')->with('ready', 'Order is ready to serve!');
    }
}
