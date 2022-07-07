<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class ProjectRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function get_data($user_id){
        return DB::table("customer_project")
                ->select("project.id", 
                            "project.customer_id", 
                            "project.name", 
                            "project.description", 
                            "project.privacy", 
                            "project.type", 
                            "project.status",
                             DB::raw('COUNT(task.project_id) as total_task'))
                ->leftjoin("project", "customer_project.project_id", "=", "project.id")
                ->leftjoin("task", "customer_project.project_id", "=", "task.project_id")
                ->where("customer_project.customer_id", "=", $user_id)
                ->groupBy("project.id", 
                            "project.customer_id", 
                            "project.name", 
                            "project.description", 
                            "project.privacy", 
                            "project.type", 
                            "project.status", 
                            "task.project_id")
                ->get();
    }

}
