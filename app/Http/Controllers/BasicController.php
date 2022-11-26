<?php


namespace App\Http\Controllers;


use App\Http\Traits\ImageTrait;
use App\Models\Activity;
use App\Models\ActivitySignCom;
use App\Models\BasicSetting;
use App\Models\CompanyChild;
use Exception;
use Illuminate\Http\Request;


class BasicController extends Controller
{
    use ImageTrait;

    /**
     * @OA\Get(
     *     path="/api/basic/settings",
     *     tags={"基础信息"},
     *     summary="基础配置",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function settings()
    {
        try {
            $info = BasicSetting::query()->find(1);
            $data = [
                'buy_protocal' => $info->buy_protocal,
                'my_activity_pic' => $this->fullImgUrl($info->my_activity_pic),
                'my_activity_mobile' => $info->my_activity_mobile,
            ];
            return self::success($data);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }


    public function kflist($activity_id)
    {
        $data = [];
        //即使是单商家，也可能有多个校区，每个校区都有一个联系方式客服等信息
        $sign_companys = ActivitySignCom::query()->where('activity_id', $activity_id)->get();
        $company_ids = [];
        foreach ($sign_companys as $company) {
            $company_ids[] = $company->company_id;
        }
        $schools = CompanyChild::query()->whereIn('company_id', $company_ids)->get();
        foreach ($schools as $school) {
            if ($school->mobile || $school->map_area) {
                $points = explode(',', $school->map_points);
                $data[] = [
                    'name' => $school->name,
                    'mobile' => $school->mobile,
                    'pic' => $this->fullImgUrl($school->wx_pic),
                    'area' => $school->map_area,
                    'jd' => isset($points[1]) && $points[1] ? $points[1] : 0,
                    'wd' => isset($points[0]) && $points[0] ? $points[0] : 0,
                ];
            }
        }

        return self::success($data);
    }
}
