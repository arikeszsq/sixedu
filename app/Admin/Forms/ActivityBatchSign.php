<?php

namespace App\Admin\Forms;

use App\Models\Activity;
use App\Models\ActivitySignCom;
use App\Models\Company;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;

class ActivityBatchSign extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return mixed
     */
    public function handle(array $input)
    {
        $id = explode(',', $input['id'] ?? null);
        if (!$id) {
            return $this->response()->error('参数错误');
        }
        $activity_id = $input['activity_id'] ?? null;
        $companies = Company::query()->find($id);

        if ($companies->isEmpty()) {
            return $this->response()->error('用户不存在');
        }

        // 这里改为循环批量修改
        $companies->each(function ($company) use ($activity_id) {
            $data = [
                'company_id' => $company->id,
                'activity_id' => $activity_id,
                'created_at'=>date('Y-m-d H:i:s',time())
            ];
            ActivitySignCom::query()->insert($data);
        });

        return $this
            ->response()
            ->success('Processed successfully.')
            ->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $activities = Activity::query()
//            ->where('start_time', '>', Carbon::now())
            ->orderBy('id', 'desc')
            ->get();
        $options = [];
        foreach ($activities as $activity) {
            $options[$activity->id] = $activity->title;
        }

        // Since v1.6.5 弹出确认弹窗
        $this->confirm('您确定要提交表单吗', 'content');

        $this->hidden('id')->attribute('id', 'select-ids');
        
        $this->select('activity_id')->options($options)->default()->required();
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'activity_id'  => request()->get('activity_id'),
        ];
    }
}
