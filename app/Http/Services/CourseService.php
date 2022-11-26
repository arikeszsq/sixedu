<?php

namespace App\Http\Services;

use App\Http\Traits\AreaTrait;
use App\Http\Traits\ImageTrait;
use App\Http\Traits\UserTrait;
use App\Models\CompanyChild;
use App\Models\CompanyCourse;
use Illuminate\Support\Facades\DB;

class CourseService
{
    use ImageTrait, UserTrait, AreaTrait;


    public function getTypeCourseList($inputs)
    {
        $list = $this->lists($inputs);
        $data = [];
//        $data[] = [
//            "id" => 1,
//            "name" => "全部",
//            "children" => $list['total']
//        ];
        $types = CompanyCourse::Type_类型列表;
        foreach ($types as $type_id => $type_name) {
            $data[] = [
                "id" => ($type_id + 1),
                "name" => $type_name,
                "children" => isset($list['type_list'][$type_id])&&$list['type_list'][$type_id]?$list['type_list'][$type_id]:[]
            ];
        }

        return $data;
    }

    public function lists($inputs)
    {
        $activity_id = $inputs['activity_id'];

        $query = DB::table('activity_sign_com as com')
            ->leftJoin('company_course as course', 'com.company_id', 'course.company_id')
            ->leftJoin('company', 'course.company_id', 'company.id')
            ->select(['course.id as id', 'course.logo', 'course.name', 'course.price', 'course.total_num', 'course.sale_num',
                'company.name as company_name', 'course.type as type'])
            ->where('com.activity_id', $activity_id);
        if (isset($inputs['type']) && $inputs['type']) {
            $query->where('course.type', $inputs['type']);
        }
        $lists = $query->get();

        $course_total = [];
        $course_type_list = [];
        foreach ($lists as $list) {
            $array = [
                'id' => $list->id,
                'logo' => $this->fullImgUrl($list->logo),
                'name' => $list->name,
                'price' => $list->price,
                'total_num' => $list->total_num,
                'sale_num' => $list->sale_num,
                'company_name' => $list->company_name,
                'gap' => '0km'
            ];
            $course_type_list[$list->type][] = $array;
            $course_total[] = $array;
        }
        return [
            'total' => $course_total,
            'type_list' => $course_type_list
        ];
    }


    public function companyChildList($course_id)
    {
        $course = CompanyCourse::query()->find($course_id);
        $children = CompanyChild::query()->where('company_id', $course->company_id)->get();
        $data = [];
        foreach ($children as $child) {

            $msg = '';
            $map_points_child = $child->map_points;
            if (!$map_points_child) {
                $msg = '请设置校区的位置';
            }
            $map_points_user = self::authUserPoints();
            if (!$map_points_user) {
                $msg = '请先设置用户家的位置';
            }
            if ($map_points_child && $map_points_user) {
                $gap = $this->getDistance($map_points_child, $map_points_user);
            } else {
                $gap = 0;
            }
            $data[] = [
                'id' => $child->id,
                'name' => $child->name,
                'map_area' => $child->map_area,
                'gap' => $gap,
                'msg' => $msg
            ];
        }
        return $data;
    }

}
