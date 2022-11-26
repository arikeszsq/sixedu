<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class UserApplyCashOut extends Model
{

    protected $table = 'user_apply_cash_out';

    const Status_审核状态 = [
        1 => '待审核',
        2 => '通过',
        3 => '拒绝',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function PayToUser($id)
    {
        //企业打款到个人微信钱包
    }

}
