<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Repositories\CustomerRepository;
use App\Models\Customer;
use App\Models\CustomerDetail;

use App\Repositories\TeamRepository; 
use App\Models\Team;

use Redirect,Response,Config;
use Mail;
use App\Mail\MailNotify;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class AuthController extends Controller
{
    protected $customer;
    protected $customer_detail;
    protected $team;

    public function __construct(Customer $customer, CustomerDetail $customer_detail, Team $team){
        $this->customer             = new CustomerRepository($customer);
        $this->customer_detail      = new CustomerRepository($customer_detail);
        $this->team                 = new TeamRepository($team);
    }

    public function login(Request $request){ 
        $customer_id = $this->customer->checkEmailPassword($request); 
        if ($customer_id) {
            Cookie::queue(Cookie::forget('_token_'));
            Cookie::queue('_token_', $this->customer->createTokenClient($customer_id), 2628000);
            return $this->customer->send_response("Login successful!! Redirect in 2s", null, 200); 
        }else{
            return $this->customer->send_response("Username or password incorrect", null, 500); 
        }
    }
    
    public function register(Request $request){
        $data_email     = $request->data_email;
        $data_name      = $request->data_name;
        $data_password  = $request->data_password;

        if ($this->customer->check_email($data_email)) {
            return $this->customer->send_response("Email has available", null, 200);
        }else{
            try {
                DB::beginTransaction();
                $secret_key = mt_rand(1, 9999999);
                $data_auth = [
                    "secret_key"    => $secret_key,
                    "email"         => $data_email,
                    "password"      => Hash::make($data_password),
                ];
                $auth_register = $this->customer->create($data_auth);
                $data_detail = [
                    "customer_id"   => $auth_register->id,
                    "name"          => $data_name, 
                ];
                $this->customer_detail->create($data_detail);

                $data_team = [
                    "customer_id"   => $auth_register->id,
                    "name"          => explode("@", $request->data_email)[0], 
                ];
                $this->team->create($data_team);
                DB::commit(); 
            } catch (\Exception $exception) {
                DB::rollBack(); 
            }

            // Send mail confirm
            $verify_code = mt_rand(1, 9999999);
            $data = [
                'verify_code' => $verify_code
            ];
            $this->customer->update($data, $auth_register->id);
            $code = Hash::make($verify_code);
            $email = $request->data_email;
            $url = route('customer.confirm', ['code' => $code, 'email' => $email]);
            Mail::send('confirm', array('url'=> $url), function($message) use ($email) {
                $message->from('techchat2110@gmail.com', 'Tsana - Confirm email');
                $message->to($email)->subject('Tsana confirm email!');
            });

            // $tokenAuth = $auth_register->id . '$' . Hash::make($auth_register->id . '$' . $secret_key);
            // Cookie::queue('_token_', $tokenAuth, 2628000); 
            return $this->customer->send_response("Create account successful", null, 201);
        } 
    }

    public function confirm(Request $request){
        $code   = $request->code;
        $email  = $request->email;
        $customer   = $this->customer->find_with_email($request->email);
        $verify_code = $customer->verify_code;
        if ( Hash::check($verify_code, $code)) {
            $data = [
                'verify_code'   => null,
                'status'        => 1
            ];
            $this->customer->update($data, $customer->id);
            $tokenAuth = $customer->id . '$' . Hash::make($customer->id . '$' . $customer->secret_key);
            Cookie::queue('_token_', $tokenAuth, 2628000);
            return redirect()->route('customer.view.index');
        }else{
            return redirect()->route('customer.view.login')->with('error', 'C?? l???i s???y ra, vui l??ng li??n h??? qu???n tr??? vi??n ????? ???????c h??? tr???!!');  
        }
    }

    public function logout(Request $request){
        Cookie::queue(Cookie::forget('_token_'));
        return $this->customer->send_response("Logout successful", null, 200); 
    }
    
}
