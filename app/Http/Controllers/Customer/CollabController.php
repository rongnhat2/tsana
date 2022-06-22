<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Repositories\CollabRepository;
use App\Models\Collaborator;

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


class CollabController extends Controller
{
    protected $collab; 
    protected $customer;
    protected $customer_detail;
    protected $team; 

    public function __construct(Collaborator $collab, Customer $customer, CustomerDetail $customer_detail, Team $team){
        $this->collab               = new CollabRepository($collab); 
        $this->customer             = new CustomerRepository($customer);
        $this->customer_detail      = new CustomerRepository($customer_detail);
        $this->team                 = new TeamRepository($team);
    }

    public function get(Request $request){
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $team_data      = $this->team->get_one($user_id);
            $collab_data    = $this->collab->get_all($team_data->team_id);
            return $this->collab->send_response("Collab Data", $collab_data, 200);
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->customer_detail->send_response("Error Token", null, 404); 
        }
    }

    public function get_assign(Request $request){
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 

            $team_data      = $this->team->get_one($user_id);
            $collab_data    = $this->collab->get_assign($team_data->team_id);
            $customer_data  = $this->customer->get_assign($user_id); 
            $data = [
                "owner"     => $customer_data,
                "collab"    => $collab_data,
            ]; 
            return $this->collab->send_response("Collab Assign", $data, 200);
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->customer_detail->send_response("Error Token", null, 404); 
        }
    }


    public function sending(Request $request){   
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            if ($this->customer->check_email($request->data_email)) {
                $customer_sending   = $this->team->get_one($user_id);
                $email_invite       = $request->data_email;
                if ($customer_sending->email == $email_invite) {
                    return $this->customer->send_response("You can't send to yourself", null, 500);
                }else{
                    $customer_invite = $this->customer->find_with_email($email_invite);

                    $collab = $this->collab->get_collab_invite($customer_sending->team_id, $customer_invite->id);

                    if ($collab) {
                        return $this->customer->send_response("The invitation has been sent before", null, 500);
                    }else{
                        $data_collab = [
                            "customer_id"   => $customer_invite->id,
                            "team_id"       => $customer_sending->team_id,
                            "status"        => 0,
                        ];
                        $this->collab->create($data_collab);

                        // Send mail invite 
                        $email_hash = $customer_invite->id . "$" . $user_id . "$" . Hash::make($customer_sending->email);
                        $url = route('customer.invite.confirm', ['code' => $email_hash]);
                        Mail::send('invite', array('url' => $url, 'customer_data' => $customer_sending), function($message) use ($email_invite) {
                            $message->from('techchat2110@gmail.com', 'Tsana - Confirm invite');
                            $message->to($email_invite)->subject('Tsana confirm invite!');
                        }); 
                        return $this->customer->send_response("Invitation sent successfully", null, 200);
                    } 
                } 
            }else{
                return $this->customer->send_response("Email does not exist", null, 500);
            }
        }else{
            return $this->customer_detail->send_response("Error Token", null, 404); 
        }
    }

    public function confirm(Request $request){  
        $code   = $request->code;
        list($user_invite, $user_sending, $email) = explode('$', $code, 3);  
        $data_user = $this->customer->find_with_id($user_sending);
        if ($data_user) {
            $user_email = $data_user->email;
            if (Hash::check($user_email, $email)) {
                $customer_sending_team   = $this->team->get_one($user_sending); 
                $collab = $this->collab->get_collab_invite($customer_sending_team->team_id, $user_invite);
                $this->collab->update(["status" => 1], $collab->id); 
                return redirect()->route('customer.view.login')->with('success', 'Inviting successfully');  
            }else{
                Cookie::queue(Cookie::forget('_token_'));
                return redirect()->route('customer.view.login')->with('error', 'String Wrong!! Code Undefine');  
            }
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return redirect()->route('customer.view.login')->with('error', 'String Wrong!! User Undefine');  
        }  
    }

    // Kiểm tra token hợp lệ
    public function check_token(Request $request){
        $token = $request->cookie('_token_');
        list($user_id, $token) = explode('$', $token, 2); 
        $user = $this->customer_detail->get_secret($user_id);
        if ($user) {
            return Hash::check($user_id . '$' . $user[0]->secret_key, $token);
        }else{
            return false;
        }
    }

    // Tách token
    public function unpack_token(Request $request){
        $token = $request->cookie('_token_');
        return explode('$', $token, 2); 
    }
}
