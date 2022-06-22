<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class SubTaskRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }
 
    public function get_subtask_in_task($task_id){
        return DB::table('sub_task')   
                ->where("task_id", "=", $task_id) 
                ->get();
    }
    public function update_status($task_id){
        $sql = 'UPDATE sub_task set status = !status WHERE id = '.$task_id;
        DB::select($sql);
    }


}
