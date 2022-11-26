<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    const Status_有效 = 1;
    const Status_无效 = 2;
    const Status_list = [
        self::Status_有效 => '有效',
        self::Status_无效 => '无效'
    ];

    const Yes_是 = 1;
    const No_否 = 2;
    const Yes_1_No_2_list = [
        self::Yes_是 => '是',
        self::No_否 => '否'
    ];

}
