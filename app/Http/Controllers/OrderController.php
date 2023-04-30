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
use Illuminate\Support\Str;

class OrderController extends Controller
{

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

    /**
     * Show details of specific order.
     */
    public function details(string $id)
    {
        $order = Order::select('orders.id', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
                    ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
                    ->groupBy('orders.id', 'client_ID', 'order_date')
                    ->orderByDesc('order_date')
                    ->find($id);

        return view('order.details')
            ->with('order',$order);
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
        foreach($products as &$product){
            $subtotal = Product::find($product['id'])->price * $product['units'];
            $product['subtotal'] = $subtotal;
        }

        $token = $this->createOrder($clientId, $products);
        return response()->json(['message' => 'Order created successfully', 'token' => $token]);
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

    private function createOrder($clientId, $products){
        $token = Str::random(32);
        while(Order::where('token', $token)->exists()){
            $token = Str::random(32);
        }

        $order = new Order();
        $order->client_ID = $clientId;
        $order->order_date = Carbon::now();
        $order->token = $token;
        $order->save();
        $this->createOrderDetails($order, $products);
        return $token;
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

    public function showApi($token){
        if(!preg_match('/^[a-zA-Z0-9]{32}$/', $token))
            return response()->json(['message' => 'Invalid token format'], 400);

        $order = Order::select('orders.id', 'token', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
            ->where('token', $token)
            ->groupBy('orders.id', 'token', 'client_ID', 'order_date')
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
