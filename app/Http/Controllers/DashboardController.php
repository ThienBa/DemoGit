<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
   function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'dashboard']);
            return $next($request);
        });
    }

    function show(){ 
        $orders = Order::orderBy('id', 'desc')->limit(10)->get();
        $products = Product::all();

        $count_success = Order::where('status', 2)->count();
        $count_processing = Order::where('status', 1)->count();
        $count_cancel = Order::where('status', 3)->count();
        $count = [$count_success, $count_processing, $count_cancel];

        $revenue = Order::where('status', 2)->sum('price');
        
        return view('admin.show', compact('orders', 'products', 'count', 'revenue'));
    }
}
