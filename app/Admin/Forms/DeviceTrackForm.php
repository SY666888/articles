<?php

namespace App\Admin\Forms;
use  App\Models\Phone;
use  App\Models\Kehuxiansuo;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

/**
 * 设备记录分配使用者
 * Class DeviceTrackForm
 * @package App\Admin\Forms
 */
class DeviceTrackForm extends Form implements LazyRenderable
{
    use LazyWidget;

    /**
     * 处理表单提交逻辑
     * @param array $input
     * @return JsonResponse
     */
    public function handle(array $input): JsonResponse
    {
        // 获取当前行线索id
        $xiansuo_id = $this->payload['id'] ?? null;

        // 如果没有获取当前线索id则返回错误
        if (!$xiansuo_id) {
            return $this->response()
                ->error('获取参数错误');
        }

        // 获取销售员id，来自表单传参
        $saler_id = $input['saler_id'] ?? null;

        // 分配者记录
        $user = Admin::user()->where('id', $saler_id)->first();
        // 如果没有找到这个分配者记录则返回错误
        if (!$user) {
            return $this->response()
                ->error('该分配者不存在');
        }

        // 电话记录
        $tlephone = Phone::where('id', $xiansuo_id)->first();
        // 如果没有找到这个电话记录则返回错误
        if (!$tlephone) {
            return $this->response()
                ->error('电话不存在');
        }

        $saler = Kehuxiansuo::where('phone_id', $xiansuo_id)->first();
        if (!empty($saler)) {
            // 如果新使用者和旧使用者相同，返回错误
            if ($saler->tracer_id == $user->id) {
                return $this->response()
                    ->error('该记录已经分配给该用户，无需重新分配！！');
            } else {
                $saler->update(['tracer_id'=>$saler_id]);

                return $this->response()
                    ->success('使用者重新分配成功！')
                    ->refresh();
            }

        }
        else{
            // 创建新的使用者
            $tracer = new Kehuxiansuo();
            $tracer->phone_id = $xiansuo_id;
            $tracer->tracer_id = $saler_id;
            $tracer->save();
            return $this->response()
                ->success('使用者分配成功')
                ->refresh();
        }

    }



    /**
     * 构造表单
     */
    public function form()
    {
        $this->select('saler_id', '新使用者')
            ->options(Admin::user()->pluck('name', 'id'))
            ->help('选择新使用者后，将会自动解除此设备与老使用者的归属关系。')
            ->required();
    }
}
