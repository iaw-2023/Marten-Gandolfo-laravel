<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Client;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $orders = Order::select('orders.id', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
            ->groupBy('orders.id', 'client_ID', 'order_date')
            ->orderByDesc('order_date')
            ->get();
        return view('order.index')
            ->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->view('errors.404', [], Response::HTTP_NOT_FOUND);
    }

    public function storeApi(Request $request){
        $validator = $this->getStoreApiValidator($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $clientId = $this->createClientIfDoesntExist($request->input('email'));
        $products = $request->input('products');
        $price = 0;
        foreach($products as &$product){
            $subtotal = Product::find($product['id'])->price * $product['units'];
            $price += $subtotal;
            $product['subtotal'] = $subtotal;
        }

        $this->createOrder($clientId, $price, $products);
        return response()->json(['message' => 'Order created successfully']);
    }

    private function getStoreApiValidator($request){
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|min:1|distinct|exists:products,id,deleted_at,NULL',
            'products.*.units' => 'required|integer|min:1',
        ]);
    }

    private function createClientIfDoesntExist($clientEmail){
        $client = Client::where('email', $clientEmail)->first();
        if(!$client){
            $client = new Client();
            $client->email = $clientEmail;
            $client->save();
        }
        return $client->id;
    }

    private function createOrder($clientId, $price, $products){
        $order = new Order();
        $order->client_ID = $clientId;
        $order->order_date = Carbon::now();
        $order->price = $price;
        $order->save();
        $this->createOrderDetails($order, $products);
    }

    private function createOrderDetails($order, $products){
        foreach($products as $product){
            $orderDetail = new OrderDetail();
            $orderDetail->order_ID = $order->id;
            $orderDetail->product_ID = $product['id'];
            $orderDetail->units = $product['units'];
            $orderDetail->subtotal = $product['subtotal'];
            $orderDetail->save();
        }
    }

    public function showApi($id){
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer|min:1',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid order ID'
            ], 400);
        }

        $order = Order::select('orders.id', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
            ->where('orders.id', $id)
            ->groupBy('orders.id', 'client_ID', 'order_date')
            ->with([
                'orderDetails' => function($query){
                    $query->select('id', 'order_ID', 'product_ID', 'units', 'subtotal');
                },
                'orderDetails.product' => function($query){
                    $query->withTrashed()->select('id', 'name');
                },
                'client' => function($query){
                    $query->select('id', 'email');
                }
            ])
            ->first();


        if(!$order){
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
        return response()->json($order);
    }
}
