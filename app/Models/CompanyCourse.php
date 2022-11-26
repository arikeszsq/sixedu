<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyCourse extends Model
{

    protected $table = 'company_course';

    protected $fillable = ['type', 'company_id', 'logo', 'name', 'price', 'total_num', 'sale_num'];

    const Type_早教 = 1;
    const Type_水育 = 2;
    const Type_美术 = 3;
    const Type_乐高 = 4;
    const Type_围棋 = 5;
    const Type_硬笔 = 6;
    const Type_软笔 = 7;
    const Type_国画 = 8;

    const Type_类型列表 = [
        1 => '早教',
        2 => '水育',
        3 => '美术',
        4 => '乐高',
        5 => '围棋',
        6 => '硬笔',
        7 => '软笔',
        8 => '国画',
    ];
}
