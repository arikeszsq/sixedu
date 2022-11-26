<?php

namespace App\Admin\Forms;

use App\Models\Activity;
use App\Models\ActivitySignCom;
use App\Models\Company;
use Dcat\Admin\Widgets\Form;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Contracts\LazyRenderable;

class ActivityRowSign extends Form implements LazyRenderable
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
        $id = $this->payload['id'] ?? null;

        $activity_id = $input['activity_id'] ?? null;

        $data = [
            'company_id' => $id,
            'activity_id' => $activity_id,
            'created_at'=>date('Y-m-d H:i:s',time())
        ];
        ActivitySignCom::query()->insert($data);

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
        $options = Activity::getActivityListOptions();
        $this->confirm('您确定要提交表单吗', 'content');
        $this->select('activity_id','活动')->options($options)->required();
    }

    /**
     * The data of the form.
     *
     * @return array
     */
    public function default()
    {
        return [
            'name' => 'John Doe',
            'email' => 'John.Doe@gmail.com',
        ];
    }
}
