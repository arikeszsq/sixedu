<?php


namespace App\Http\Controllers;

use App\Http\Services\CourseService;
use App\Http\Traits\ImageTrait;
use App\Models\Company;
use App\Models\CompanyChild;
use App\Models\CompanyCourse;
use Exception;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ImageTrait;

    public $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

    /**
     * @OA\Get(
     *     path="/api/course/type-lists",
     *     tags={"课程"},
     *     summary="课程分类",
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function typeLists()
    {
        $data = CompanyCourse::Type_类型列表;
        $type = [];
        foreach ($data as $v) {
            $type[] = $v;
        }
        return self::success($type);
    }

    /**
     * @OA\Get(
     *     path="/api/course/lists",
     *     tags={"课程"},
     *     summary="课程列表",
     *     @OA\Parameter(name="activity_id",in="query",description="活动id",required=true),
     *     @OA\Parameter(name="type",in="query",description="课程类型：1 => '早教',2 => '水育',3 => '美术',4 => '乐高',5 => '围棋',6 => '硬笔',7 => '软笔',8 => '国画',"),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * [
     * { "children": [{ "id": "14", "name": "办公", }, { "id": "13", "name": "形象与礼仪", }], "id": "1", "name": "通用课程", }
     * { "children": [{ "id": "14", "name": "办公", }, { "id": "13", "name": "形象与礼仪", }], "id": "1", "name": "通用课程", }
     * ]
     */
    public function lists(Request $request)
    {
        $inputs = $request->all();
        $validator = \Validator::make($inputs, [
            'activity_id' => 'required',
        ], [
            'activity_id.required' => '活动ID必填',
        ]);
        if ($validator->fails()) {
            return self::parametersIllegal($validator->messages()->first());
        }
        try {
            return self::success($this->courseService->getTypeCourseList($inputs));
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/course/detail/{id}",
     *     tags={"课程"},
     *     summary="课程详情",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="课程详情",
     *      @OA\Schema(
     *         type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param $id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function detail($id)
    {
        try {
            return self::success(CompanyCourse::query()->find($id));
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }

    /**
     * @OA\Get(
     *     path="/api/course/company-child-lists/{id}",
     *     tags={"课程"},
     *     summary="课程校区列表",
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      description="课程Id",
     *      @OA\Schema(
     *         type="integer"
     *      )
     *   ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     * @param $course_id
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function companyChildList($course_id)
    {
//        try {
            return self::success($this->courseService->companyChildList($course_id));
//        } catch (Exception $e) {
//            return self::error($e->getCode(), $e->getMessage());
//        }
    }


    /**
     * @OA\Get(
     *     path="/api/course/courseschool/info",
     *     tags={"通过课程id和学校id去拿4个报名的数据"},
     *     summary="通过课程id和学校id去拿4个报名的数据",
     *     @OA\Parameter(name="school_ids",in="query",description="校区ids:1,2,3,4",required=true),
     *     @OA\Parameter(name="course_ids",in="query",description="课程ids:1,2,3,4",required=true),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function courseAndSchool(Request $request)
    {
        $inputs = $request->all();
        try {
            $school_ids = explode(',', $inputs['school_ids']);
            $course_ids = explode(',', $inputs['course_ids']);
            $data = [];
            foreach ($school_ids as $key => $school_id) {
                $school = CompanyChild::query()->find($school_id);
                $course = CompanyCourse::query()->find($course_ids[$key]);
                $company = Company::query()->find($school->company_id);
                $data[] = [
                    'course_logo' => $this->fullImgUrl($course->logo),
                    'company_name' => $company->name,
                    'course_name' => $course->name
                ];
            }
            return self::success($data);
        } catch (Exception $e) {
            return self::error($e->getCode(), $e->getMessage());
        }
    }
}
