<?php

namespace App\Admin\Forms;
use  App\Models\Phone;
use  App\Models\Kehuxiansuo;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Http\JsonResponse;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;
use Carbon\Carbon;
use function GuzzleHttp\default_ca_bundle;

/**
 * 设备记录分配使用者
 * Class DeviceTrackForm
 * @package App\Admin\Forms
 */
class FollowUpForm extends Form implements LazyRenderable
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
        //获取当前行数据
        $tracer = Kehuxiansuo::where('id',$xiansuo_id)->first();
        // 如果没有获取当前线索id则返回错误
        if (!$xiansuo_id) {
            return $this->response()
                ->error('获取参数错误');
        }

        // 电话记录
        $tlephone = Phone::where('id', $tracer->phone_id )->first();
        // 如果没有找到这个电话记录则返回错误
        if (!$tlephone) {
            return $this->response()
                ->error('电话不存在');
        }



        //判断是否完成跟进
        if($tracer->situation=='w')
        {
            return $this->response()
                ->warning('订单已完成无需跟进！！');
        }

        // 更新数据
        $remark=$tracer->remark;
        $expired_at=Carbon::now();
        if ($input['valid']==1){
            if (!empty($remark)&&$tracer->valid==1){
                $remark.='|'.$expired_at.'@'.$input['remark'];
                $tracer->update([
                    'valid'=>$input['valid'],
                    'remark'=>$remark,
                    'yiyuan'=>$input['yiyuan'],
                    'situation'=>$input['situation'],
                    'num'=>$input['num'],
                    'remark_type'=>' ',
                ]);
            }

            else{
                $remark=$expired_at.'@'.$input['remark'];
                $tracer->update([
                    'valid'=>$input['valid'],
                    'remark'=>$remark,
                    'yiyuan'=>$input['yiyuan'],
                    'situation'=>$input['situation'],
                    'num'=>$input['num'],
                    'remark_type'=>'  ',
                ]);
            }

        }
        elseif($input['valid']==0)
        {
            if(!empty($remark)&&$tracer->valid==1)
            {
                $remark.='|'.$expired_at.'@'.$input['remark'];
                $tracer->update([
                    'valid'=>$input['valid'],
                    'remark'=>$remark,
                    'remark_type'=>$input['remark_type'],
                    'num'=>$input['num'],
                    'yiyuan'=>' ',
                    'situation'=>' ',
                ]);
            }
            else
            {
                $remark=$expired_at.'@'.$input['remark'];
                $tracer->update([
                    'valid'=>$input['valid'],
                    'remark'=>$remark,
                    'remark_type'=>$input['remark_type'],
                    'num'=>$input['num'],
                    'yiyuan'=>' ',
                    'situation'=>' ',
                ]);
            }

        }
        return $this->response()
            ->success('信息提交成功！')
            ->refresh();
    }

    /**
     * 构造表单
     */
    public function form()
    {
        $id = $this->payload['id'] ?? null;
        $val=Kehuxiansuo::where('id',$id)->first();
        $remarks=explode('|',$val->remark);

        //$remark_at=$val->updated_at->diffForHumans ();
        $num=1;
        $mark='';
        foreach ($remarks as $remark )
        {   $remark=str_replace('@','</span></p><p><span style="padding-left:30px">',$remark);
            $mark.='<p><i class="fa fa-user-plus " style="color:red;padding-right: 10px"></i><span>'.$remark.'</span></p>';
            $num=$num+1;
        }
        $this->radio('valid', '信息是否有效：')
            ->when(0,function (){
                $id = $this->payload['id'] ?? null;
                $val=Kehuxiansuo::where('id',$id)->first();
                $remark_type=explode(',',$val->remark_type);
                $this->multipleSelect('remark_type', '无效原因：')
                    ->options([1 => '电话不存在', 2 => '电话多次打不通', 3 => '推销电话',4=> '被恶意留电话',5=> '没有任何意愿'])
                    ->saving(function ($value) {
                        return implode(',',$value);
                    })
                    ->help('电话是否有效类型')
                    ->default($remark_type);
            })
            ->when(1,function (){
                $id = $this->payload['id'] ?? null;
                $val=Kehuxiansuo::where('id',$id)->first();
                $this->radio('yiyuan','客户意愿：')
                    ->options([0 => '弱', 1=> '一般', 2 => '强',3=> '很强',4=> '超强'])
                    ->default($val->yiyuan);
                $this->radio('situation','跟进情况：')
                    ->options(['w'=> '完成', 'd'=> '待确认', 'r' => '进一步确认','g'=> '跟进中'])
                    ->default($val->situation);

            })
            ->options([0 => '无效', 1 => '有效'])
            ->help('确认电话是否有效')
            ->required()->default($val->valid);
           if ($val->valid==1)
           {
               $this->textarea('remark','详细说明')->rows(5)
                   ->help('跟单详情：'. $mark.'上一次跟单时间：'.$val->updated_at)
                   ->required();
           }
           else{
               $this->textarea('remark','详细说明')->rows(5)
                   ->help('详细说明')
                   ->required();
           }
        $this->hidden('num')->default($num);
        }
        }
