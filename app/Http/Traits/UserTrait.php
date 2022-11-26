<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait UserTrait
{
    /**
     * get auth user
     *
     * @return mixed
     */
    public static function authUser()
    {
        return Auth::guard('user')->user();
    }

    /**
     * get auth user id
     *
     * @return int|null
     */
    public static function authUserId()
    {
        return self::authUser() ? self::authUser()->id : null;
    }

    public function updateUserName($name)
    {
        User::query()->where('id',self::authUserId())->update(
            ['name'=>$name]
        );
    }


    public static function authUserOpenId()
    {
        return self::authUser() ? self::authUser()->openid : null;
    }

    public static function authUserEmail()
    {
        return self::authUser() ? self::authUser()->email : null;
    }

    public static function authUserPoints()
    {
        return self::authUser() ? self::authUser()->map_points : null;
    }

}
