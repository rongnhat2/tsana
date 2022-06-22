<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Session;
use Hash;
use DB;

class CustomerRepository extends BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getOne($id){
        return $this->model->where('id', '=', $id)->get();
    }
    // Kiểm tra Email tồn tại
    public function check_email($email){
        return $this->model->where('email', '=', $email)->first() ? true : false;
    }

    // Tìm customer với Email
    public function find_with_email($email){
        return $this->model->where('email', '=', $email)->first();
    }

    // Tìm customer với Id
    public function find_with_id($id){
        return $this->model->where('id', '=', $id)->first();
    }
    
    // Kiểm tra Email / Mật khẩu
    public function checkEmailPassword($request){
        $user = $this->model->where('email', '=', $request->data_email)->first();
        if ($user) {
            return Hash::check($request->data_password, $user->password) ? $user->id : false;
        }else{
            return false;
        }
    }

    // lấy ra thông tin để assign
    public function get_assign($id){
        return DB::table('customer') 
                    ->select('customer.id as customer_id', 'customer.email', 'customer_detail.name', 'customer_detail.avatar') 
                    ->leftjoin("customer_detail", "customer_detail.customer_id", "=", "customer.id") 
                    ->where("customer.id", "=", $id)
                    ->first();
    }


    // Tạo token client
    public function createTokenClient($id){
        return $id . '$' . Hash::make($id . '$' . $this->model->findOrFail($id)->secret_key);
    }

    // Lấy ra secret_key
    public function get_secret($id){
         $sql = "SELECT secret_key
                    FROM customer
                    WHERE id = ".$id;
        return DB::select($sql);
    } 

    // Lấy ra Name, Phone, Address 
    public function get_profile($id){
         $sql = "SELECT id, name, address, phone
                    FROM customer_detail 
                    WHERE customer_id = ".$id;
        return DB::select($sql);
    }
 
    
}
