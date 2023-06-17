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
use Illuminate\Http\Response;
use App\Mail\CustomOrderLink;
use Illuminate\Support\Facades\Mail;

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

    public function indexApi(Request $request){
        $user = $request->user();

        $orders = Order::select('orders.id', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
                                ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
                                ->where('client_ID', $user->id)
                                ->groupBy('orders.id', 'client_ID', 'order_date')
                                ->with([
                                    'orderDetails' => function($query){
                                        $query->select('id', 'order_ID', 'product_ID', 'units', 'subtotal');
                                    },
                                    'orderDetails.product' => function($query){
                                        $query->withTrashed()->select('id', 'name', 'product_image');
                                    }
                                ])
                                ->get();

        /* return response()->json([
            "orders" => ($orders)
        ]); */
        return response()->json([
            "orders" => $this->formatOrderListResponse($orders)
        ]);
    }

    private function formatOrderListResponse($orders){
        return $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'client_ID' => $order->client_ID,
                'order_date' => $order->order_date,
                'price' => $order->price,
                'image' => $order->orderDetails->first()->product->product_image,
            ];
        });
    }

    /**
    * @OA\Post(
    *     path="/orders",
    *     operationId="postOrder",
    *     tags={"orders"},
    *     summary="Create a new order",
    *     requestBody={
    *         "required": true,
    *         "content": {
    *             "application/json": {
    *                 "schema": {
    *                     "$ref": "#/components/schemas/NewOrder"
    *                 }
    *             }
    *         }
    *     },
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="message", type="string", example="Order created successfully"),
    *             @OA\Property(property="token", type="string", example="BlieCRUyOWzxWfRY42990IEFdLa7x2OL")
    *         )
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Invalid order details"
    *     )
    * )
    */
    public function storeApi(Request $request){
        //TODO obtener email de la autenticacion
        $client = auth()->user();

        $validator = $this->getStoreApiValidator($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        
        $products = $request->input('products');
        foreach($products as &$product){
            $subtotal = Product::find($product['id'])->price * $product['units'];
            $product['subtotal'] = $subtotal;
        }

        $token = $this->createOrder($client->id, $products);
        
        return response()->json(['message' => 'Order created successfully', 'token' => $token]);
    }

    private function getStoreApiValidator($request){
        return Validator::make($request->all(), [
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|integer|min:1|distinct|exists:products,id,deleted_at,NULL',
            'products.*.units' => 'required|integer|min:1',
        ]);
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

        Mail::to($order->user->email)->send(new CustomOrderLink($order));

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

    /**
    * @OA\Get(
    *     path="/orders/{token}",
    *     operationId="getOrderByToken",
    *     tags={"orders"},
    *     summary="Get order by token",
    *     @OA\Parameter(
    *         name="token",
    *         in="path",
    *         description="Token of order to return",
    *         required=true,
    *         @OA\Schema(
    *             type="string",
    *             example="4sxgVva7EntBjG6xUC22ADjqNnCdayGv"
    *         )
    *     ),
    *     @OA\Response(
    *         response="200",
    *         description="Successful operation",
    *         @OA\JsonContent(ref="#/components/schemas/Order")
    *     ),
    *     @OA\Response(
    *         response="400",
    *         description="Invalid token supplied"
    *     ),
    *     @OA\Response(
    *         response="404",
    *         description="Order not found"
    *     )
    * )
    */
    public function showApi($id){
        if(!ctype_digit($id))
            return response()->json([
                'message' => 'Invalid ID'
            ], 400);
            
        $client = auth()->user();

        $order = Order::select('orders.id', 'client_ID', 'order_date', DB::raw('CAST(SUM(order_details.subtotal) AS DECIMAL(10, 2)) AS price'))
                            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_ID')
                            ->where('orders.id', $id)
                            ->where('client_ID', $client->id)
                            ->groupBy('orders.id', 'client_ID', 'order_date')
                            ->with([
                                'orderDetails' => function($query){
                                    $query->select('id', 'order_ID', 'product_ID', 'units', 'subtotal');
                                },
                                'orderDetails.product' => function($query){
                                    $query->withTrashed()->select('id', 'name', 'product_image');
                                }
                            ])
                            ->first();

        if(!$order){
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }
        return response()->json($this->formatOrderResponse($order));
    }

    private function formatOrderResponse($order){
        return [
            'id' => $order->id,
            'order_date' => $order->order_date,
            'price' => $order->price,
            'order_details' => $order->orderDetails->map(function ($orderDetail) {
                return [
                    'product' => [
                        'id' => $orderDetail->product->id,
                        'name' => $orderDetail->product->name,
                        'product_image' => $orderDetail->product->product_image,
                    ],
                    'units' => $orderDetail->units,
                    'subtotal' => $orderDetail->subtotal,
                ];
            }),
        ];
    }
}
