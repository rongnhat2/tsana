<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class CollabRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get_all($team_id){
        return DB::table('collaborator') 
                ->select('collaborator.team_id', 'collaborator.status', 'customer.id as customer_id', 'customer.email', 'customer_detail.name', 'customer_detail.avatar')
                ->leftjoin("customer", "customer.id", "=", "collaborator.customer_id")
                ->leftjoin("customer_detail", "customer_detail.customer_id", "=", "collaborator.customer_id")
                ->where("collaborator.team_id", "=", $team_id)
                ->get();
    }
    public function get_assign($team_id){
        return DB::table('collaborator') 
                ->select('collaborator.team_id', 'collaborator.status', 'customer.id as customer_id', 'customer.email', 'customer_detail.name', 'customer_detail.avatar')
                ->leftjoin("customer", "customer.id", "=", "collaborator.customer_id")
                ->leftjoin("customer_detail", "customer_detail.customer_id", "=", "collaborator.customer_id")
                ->where([["collaborator.team_id", "=", $team_id], ["collaborator.status", "=", 1]])
                ->get();
    }
    public function get_collab_invite($team_id, $invite_id){
        return DB::table('collaborator') 
                ->where([["customer_id", "=", $invite_id], ["team_id", "=", $team_id]])
                ->first();
    }

}
