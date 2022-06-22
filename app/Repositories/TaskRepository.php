<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class TaskRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get_task_comming($id){
        return DB::table('task')  
                ->where("customer_assign", "=", $id)
                ->where("status", "=", 0)
                ->get();
    }
    public function get_one_task($id, $task_id){
        return DB::table('task')  
                ->where("id", "=", $task_id)
                ->where("customer_assign", "=", $id) 
                ->first();
    }


}
