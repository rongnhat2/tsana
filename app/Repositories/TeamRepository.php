<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class TeamRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    } 
    
    public function get_one($id){
        return DB::table('customer')
                ->select("customer.id", "customer.email", "customer_detail.name", "team.id as team_id", "team.name as team_name")
                ->leftjoin("team", "team.customer_id", "=", "customer.id")
                ->leftjoin("customer_detail", "customer_detail.customer_id", "=", "customer.id")
                ->where("customer.id", "=", $id)
                ->first();
    }

}
