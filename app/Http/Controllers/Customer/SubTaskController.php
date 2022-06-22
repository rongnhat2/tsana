<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\CollabRepository;
use App\Models\Collaborator;

use App\Repositories\CustomerRepository;
use App\Models\Customer;
use App\Models\CustomerDetail;

use App\Repositories\TeamRepository; 
use App\Models\Team;

use App\Repositories\TaskRepository; 
use App\Models\Task;

use App\Repositories\SubTaskRepository; 
use App\Models\SubTask;

use Redirect,Response,Config;
use Mail;
use App\Mail\MailNotify;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class SubTaskController extends Controller
{
    protected $collab; 
    protected $customer;
    protected $customer_detail;
    protected $team; 
    protected $task; 
    protected $subtask; 

    public function __construct(Collaborator $collab, Customer $customer, CustomerDetail $customer_detail, Team $team, Task $task, SubTask $subtask){
        $this->collab               = new CollabRepository($collab); 
        $this->customer             = new CustomerRepository($customer);
        $this->customer_detail      = new CustomerRepository($customer_detail);
        $this->team                 = new TeamRepository($team);
        $this->task                 = new TaskRepository($task);
        $this->subtask              = new SubTaskRepository($subtask);
    }
    public function get(Request $request){

        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data = $this->subtask->get_subtask_in_task($task_id);
            return $this->subtask->send_response("Task List", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->subtask->send_response("Error Token", null, 404); 
        }
    }
    // Tạo mới subtask
    public function create(Request $request){  
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data = [
                "task_id"           => $request->task_id,
                "description"       => $request->data_name, 
            ];
            $this->subtask->create($data); 
            $data = $this->subtask->get_subtask_in_task($request->task_id);
            return $this->subtask->send_response("Create Done", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->subtask->send_response("Error Token", null, 404); 
        }
    }
    // cấp nhật trạng thái
    public function update(Request $request){  
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request);  
            $this->subtask->update_status($request->id); 
            $data = $this->subtask->get_subtask_in_task($request->task_id);
            return $this->subtask->send_response("Update Done", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->subtask->send_response("Error Token", null, 404); 
        }
    }
    // Xóa subtask
    public function delete(Request $request){  
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request);  
            $this->subtask->delete($request->id); 
            $data = $this->subtask->get_subtask_in_task($request->task_id);
            return $this->subtask->send_response("Update Done", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->subtask->send_response("Error Token", null, 404); 
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
