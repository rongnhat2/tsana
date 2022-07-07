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

use App\Repositories\ProjectRepository; 
use App\Models\Project;
use App\Models\CustomerProject;

use App\Repositories\SprintRepository; 
use App\Models\Sprint;

use App\Repositories\SectionRepository; 
use App\Models\Section;

use Redirect,Response,Config;
use Mail;
use App\Mail\MailNotify;
use Carbon\Carbon;
use Session;
use Hash;
use DB;

class ProjectController extends Controller
{

    protected $collab; 
    protected $customer;
    protected $customer_detail;
    protected $team; 
    protected $task; 
    protected $subtask; 
    protected $project; 
    protected $customer_project; 
    protected $sprint; 
    protected $section; 

    public function __construct(Collaborator $collab, Customer $customer, CustomerDetail $customer_detail, 
        Team $team, Task $task, SubTask $subtask, Project $project, CustomerProject $customer_project, Sprint $sprint, Section $section){
        $this->collab               = new CollabRepository($collab); 
        $this->customer             = new CustomerRepository($customer);
        $this->customer_detail      = new CustomerRepository($customer_detail);
        $this->team                 = new TeamRepository($team);
        $this->task                 = new TaskRepository($task);
        $this->subtask              = new SubTaskRepository($subtask);
        $this->project              = new ProjectRepository($project);
        $this->customer_project     = new ProjectRepository($customer_project);
        $this->sprint               = new SprintRepository($sprint);
        $this->section              = new SectionRepository($section);
    }

    public function get(Request $request){ 
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 
            $data = $this->project->get_data($user_id);
            return $this->project->send_response("Project List", $data, 200); 
        }else{
            Cookie::queue(Cookie::forget('_token_'));
            return $this->project->send_response("Error Token", null, 404); 
        }
    }

    // Tạo mới project
    public function create(Request $request){   
        $is_user = static::check_token($request);  
        if ($is_user) { 
            list($user_id, $token) = static::unpack_token($request); 

            // Tạo project mới
            $data = [
                "customer_id"    => $user_id,
                "name"           => $request->data_name,
                "privacy"        => $request->data_privacy,
                "type"           => $request->data_type, 
            ];
            $project_new = $this->project->create($data); 

            // Tạo liên kết với project
            $project_customer = [
                "customer_id"    => $user_id,
                "project_id"     => $project_new->id,
            ];
            $this->customer_project->create($project_customer);

            // Project 1 sprint thì tạo luôn mặc định
            if ($request->data_type == 1) {
                $data_sprint = [
                    "project_id" => $project_new->id,
                    "name"      => "Sprint Final",
                    "type"       => 1,
                ];
                $sprint_new = $this->sprint->create($data_sprint); 

                $data_section_backlog = [
                    "sprint_id" => $sprint_new->id,
                    "name"      => "Backlog",
                    "privacy"      => "0",
                ];
                $data_section_todo = [
                    "sprint_id" => $sprint_new->id,
                    "name"      => "To do",
                    "privacy"      => "1",
                ];
                $data_section_doing = [
                    "sprint_id" => $sprint_new->id,
                    "name"      => "Doing",
                    "privacy"      => "1",
                ];
                $data_section_pending = [
                    "sprint_id" => $sprint_new->id,
                    "name"      => "Pending",
                    "privacy"      => "1",
                ];
                $this->section->create($data_section_backlog); 
                $this->section->create($data_section_todo); 
                $this->section->create($data_section_doing); 
                $this->section->create($data_section_pending);  
            } 
            return $this->subtask->send_response("Create Done", $project_new, 200); 
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
