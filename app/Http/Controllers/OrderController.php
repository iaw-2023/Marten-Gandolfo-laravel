<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Client;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function allOrders(){
        $orders = Order::all();
        foreach($orders as $order){
            echo $order->client()->get() . "<br>";
            echo $order . "<br>";
            echo $order->orderDetails()->get() . "<br><br>";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        $details = OrderDetail::all();
        return view('order.index')
            ->with('orders',$orders)
            ->with('details',$details);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeApi(Request $request){
        $clientEmail = $request->input('email');
        $products = $request->input('products');

        $client = Client::where('email', $clientEmail)->first();
        if(!$client){
            $client = new Client();
            $client->email = $clientEmail;
            $client->save();
        }
        $clientId = $client->id;

        $price = 0;
        foreach($products as &$product){
            $subtotal = Product::find($product['id'])->price * $product['units'];
            $price += $subtotal;
            $product['subtotal'] = $subtotal;
        }

        $order = new Order();
        $order->client_ID = $clientId;
        $order->order_date = Carbon::now();
        $order->price = $price;
        $order->save();

        
        foreach($products as $product){
            $orderDetail = new OrderDetail();
            $orderDetail->order_ID = $order->id;
            $orderDetail->product_ID = $product['id'];
            $orderDetail->units = $product['units'];
            $orderDetail->subtotal = $product['subtotal'];
            $orderDetail->save();
        }

        return response()->json(['message' => 'Order created successfully']);
    }

    public function showApi($id){
        //$order = Order::with('orderDetails.product', 'client')->find($id);
        $order = Order::select('id', 'client_ID', 'order_date', 'price')->with([
            'orderDetails' => function($query){
                $query->select('id', 'order_ID', 'product_ID', 'units', 'subtotal');
            },
            'orderDetails.product' => function($query){
                $query->withTrashed()->select('id', 'name');
            },
            'client' => function($query){
                $query->select('id', 'email');
            }
        ])->find($id);
        if(!$order){
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
        return response()->json($order);
    }
}
