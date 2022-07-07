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


class TaskController extends Controller
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
            $data = $this->task->get_task_comming($user_id, $request->tab_id);
            return $this->task->send_response("Task List", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->task->send_response("Error Token", null, 404); 
        }
    }
    public function get_one(Request $request){ 
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data_task = $this->task->get_one_task($user_id, $request->id);
            $data_sub_task = $this->subtask->get_subtask_in_task($request->id);
            $data = [
                "task" => $data_task,
                "sub_task" => $data_sub_task,
            ];
            return $this->task->send_response("One Task", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->task->send_response("Error Token", null, 404); 
        }
    }


    public function create(Request $request){ 

        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data = [
                "customer_created"      => $user_id,
                "customer_assign"       => $user_id,
                "name"                  => $request->data_name,
                "start_date"            => "",
                "end_date"              => "",
                "type"                  => 0,
                "priority"              => 0,
                "description"           => "",
                "status"                => 0
            ];
            $this->task->create($data); 
            return $this->task->send_response("Create Done", null, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->task->send_response("Error Token", null, 404); 
        }
    }

    public function update(Request $request){  
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data = [ 
                "customer_assign"       => $request->data_assign,
                "project_id"            => $request->data_project,
                "name"                  => $request->data_name,
                "start_date"            => $request->data_start,
                "end_date"              => $request->data_end, 
                "priority"              => $request->data_priority,
                "description"           => $request->data_description, 
            ];
            $this->task->update($data, $request->data_id); 
            return $this->task->send_response("Create Done", null, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->task->send_response("Error Token", null, 404); 
        }
    }

    // Hoàn thiện task
    public function on_done(Request $request){ 
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request);  
            $data =$this->task->update(["status" => 1], $request->task_id); 
            return $this->task->send_response("Done Task", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->task->send_response("Error Token", null, 404); 
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
