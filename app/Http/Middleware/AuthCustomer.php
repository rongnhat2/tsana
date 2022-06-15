<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Models\Admin;
use Session;
use Hash;
use DB;

class AuthCustomer{
    public function handle($request, Closure $next, $middleware) {   
        $token = $request->cookie('_token_');
        if ($middleware == 'login') {
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('customer')->where('id', '=', $user_id)->first();
                if ($user) {
                    $secret_key     = $user->secret_key;
                    if ($user->status) {
                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            // Đăng nhập thành công
                            return redirect()->route('customer.view.home');
                        }else{
                            Cookie::queue(Cookie::forget('_token_'));
                            $request->session()->forget('_token_');
                            return redirect()->route('customer.view.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token_');
                        Cookie::queue(Cookie::forget('_token_'));
                        return redirect()->route('customer.view.login')->with('error', 'Tài khoản đã bị khóa!');  
                    }
                }else{
                    $request->session()->forget('_token_');
                    Cookie::queue(Cookie::forget('_token_'));
                    return redirect()->route('customer.view.login')->with('success', 'Tài khoản không tồn tại!');  
                }
            }else{
                return $next($request);
            }
        }else{
            if ($token) {
                list($user_id, $token) = explode('$', $token, 2);
                $user = DB::table('customer')->where('id', '=', $user_id)->first();
                if ($user->status) {
                    if ($user) {
                        $secret_key     = $user->secret_key;
                        if (Hash::check($user_id . '$' . $secret_key, $token)) {
                            return $next($request);
                        }else{
                            Cookie::queue(Cookie::forget('_token_'));
                            $request->session()->forget('_token_');
                            return  redirect()->route('customer.view.login')->with('success', 'Token đã hết hạn');  
                        }
                    }else{
                        $request->session()->forget('_token_');
                        Cookie::queue(Cookie::forget('_token_'));
                        return redirect()->route('customer.view.login')->with('success', 'Tài khoản không tồn tại!');  
                    }
                }else{
                    $request->session()->forget('_token_');
                    Cookie::queue(Cookie::forget('_token_'));
                    return redirect()->route('customer.view.login')->with('error', 'Tài khoản đã bị khóa!');  
                }
            }else{
                return redirect()->route('customer.view.login')->with('success', 'Bạn cần đăng nhập để thực hiện hành động này');  
            }
        }
    }
}
