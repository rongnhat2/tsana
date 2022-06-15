<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class AdminRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get_admin(){
        $sql = "SELECT * 
                FROM admin
                LEFT JOIN admin_detail
                ON admin.id = admin_detail.admin_id";
        return DB::select($sql);
    }
    
    // Kiểm tra Email tồn tại
    public function check_email($email){
        return $this->model->where('email', '=', $email)->first() ? true : false;
    }
    public function checkEmailPassword($request){
        $user = $this->model->where('email', '=', $request->email)->first();
        if ($user) {
            return Hash::check($request->password, $user->password) ? $user->id : false;
        }else{
            return false;
        }
    }
    // # Tạo token client
    public function createTokenClient($id){
        return $id . '$' . Hash::make($id . '$' . $this->model->findOrFail($id)->secret_key);
    }
    
}
