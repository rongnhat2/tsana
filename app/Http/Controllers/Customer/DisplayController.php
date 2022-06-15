<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function index(Request $request){ 
        return redirect()->route('customer.view.login');
    }
    public function login(Request $request){ 
        return view("customer.auth");
    }
    public function home(Request $request){ 
        return view("customer.home");
    }
}
