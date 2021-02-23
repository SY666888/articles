<?php

namespace App\Admin\Controllers;
use  App\Models\Phone;
use Carbon\Carbon;
use  App\Models\Kehuxiansuo;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Admin\Grid\Displayers\RowActions;
use phpDocumentor\Reflection\UsingTagsTest;
use Zhuzhichao\IpLocationZh\Ip;
use App\Admin\Actions\Grid\ToolAction\PhoneImportAction;
use App\Admin\Actions\Grid\RowAction\FollowUpAction;
use App\Admin\Actions\Grid\RowAction\ResetAction;
use Dcat\Admin\Widgets\Tab;
use Dcat\Admin\Widgets\Card;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Row;
class  XiansuoGenzongController  extends AdminController
{
    protected $title = '电话信息跟进处理';
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new  Kehuxiansuo(), function (Grid $grid) {
            $grid->model()->with(['Phone']);
            $grid->column('id')->sortable();
            $grid->column('Phone.phone', '电话')->display(function ($value) {
                if ($this->valid != -1) {
                    $url = admin_url('phone_genzong/' . $this->id);
                    return '<a href="' . $url . '">' . $value . '</a>';
                } else {
                    return $value;
                }
            });
            $grid->column('Phone.name', '姓名');
            $grid->column('valid', '信息状态')->using([0 => '无效', 1 => '有效', -1 => '未跟进'])->label([
                'default' => 'primary', // 设置默认颜色，不设置则默认为 default
                0 => 'dark60',
                1 => 'primary',
                -1 => 'warning',
            ])->display(function ($valid) {
                if ($this->situation == 'w')
                    return '<span class="label bg-primary">已完成</span>';
                else
                    return $valid;

            });
            if ($this->source_id == 1 || $this->source_id == 12 || $this->source_id == 4) {
                $grid->column('situation', '跟进情况')
                    ->if(function ($column) {
                        // $column->getValue() 是当前字段的值
                        return $this->valid == 1;
                    })
                    ->using(['w' => '已完成', 'd' => '待确认', 'r' => '进一步确认', 'g' => '跟进中'])
                    ->dot(['w' => 'success', 'd' => 'red', 'r' => 'info', 'g' => 'orange2'])
                    ->else()
                    ->display(function () {
                        return '<span class="fa fa-times" style="color:#bacad6"> 无需跟进</span>';
                    });
                $grid->column('num', '跟进次数')->display(function ($num) {

                    return "<span style='color:red;font-weight: bold;';>$num</span>";

                });

            }
            $source_id = array(1,2,12,13);
            if (in_array($this->source_id,$source_id))
            {
                $grid->column('remark','详情')
                    ->display('查看') // 设置按钮名称
                    ->modal(function ($modal) {
                        // 设置弹窗标题
                        $id = $this->id;
                        $val = Kehuxiansuo::find($id);
                        $phone = Phone::find($val->phone_id);
                        $user = Admin::user()->find($val->tracer_id);
                        $remarks = explode('|', $val->remark);
                        $modal->title('客户信息及跟进情况');
                        $card0 = new Card(null, view('xiangqing.history', compact('remarks', 'val')));
                        $card = new Card(null, view('xiangqing.xinxi', compact('val', 'phone', 'user')));
                        return "<div style='padding:10px 10px 0'>$card0.$card</div>";
                    });
            }
            $grid->column('tracer_id','跟单者')
                ->display(function ($tracer_id) {
               $user=Admin::user()->where('id',$tracer_id)->value('name');
                        return   $user;
            })->setHeaderAttributes(['style' => 'color:#d71345']);
            $grid->column('Phone.IP','归属地')->display(function ($IP) {
                if(stristr($IP,'192.168')||stristr($IP,'127.0.0'))
                {$area=$IP;}
                else{
                    $area=Ip::find($IP);
                    $area= $area[0].'-'.$area[1].'-'.$area[2];
                }

                return $area;
            });
            $grid->column('updated_at','最近跟进时间')->width('10%');
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
                $filter->scope('trashed', '回收站')->onlyTrashed();

            });
            $grid->setDialogFormDimensions('50%', '50%');
            //禁用
            $grid->disableViewButton();
            $grid->enableDialogCreate();
            $grid->disableBatchActions();
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableRowSelector();
            // 禁用
            $grid->disableCreateButton();
            $grid->toolsWithOutline(false);
            $grid->tools([
                new PhoneImportAction()
            ]);

            $grid->actions(function (RowActions $actions) {

                if (Admin::user()->can('phone_genzong.reset') && $this->valid==0) {
                    $actions->append(new ResetAction());
                }

                if (Admin::user()->can('FollowUp') && $this->valid!=0) {
                    if ($this->situation=='w')
                    {
                        $actions->prepend('<i class="fa fa-check-square"> 已完成 </i>');
                    }
                    else{
                        $actions->prepend(new FollowUpAction());
                    }



                }

            });

            //头部选项卡，调用不同得数据模型
            $grid->header(function () {
                $tab = Tab::make();
                if(Admin::user()->isRole('administrator'))
                {
                    $tab->addLink('未跟进客户', '?source_id=0',$this->source_id==0? true : false);
                    $tab->addLink('有效客户', '?source_id=1',$this->source_id==1 ? true : false);
                    $tab->addLink('无效客户', '?source_id=2',$this->source_id==2 ? true : false);
                    $tab->addLink('已完成客户', '?source_id=3',$this->source_id==3 ? true : false);
                    $tab->addLink('我的客户', '?source_id=4',$this->source_id==4 ? true : false);

                }
                 else
                     {
                         $tab->addLink('未跟进客户', '?source_id=11',$this->source_id==11 ? true : false);
                         $tab->addLink('有效客户', '?source_id=12',$this->source_id==12 ? true : false);
                         $tab->addLink('无效客户', '?source_id=13',$this->source_id==13 ? true : false);
                         $tab->addLink('已完成客户','?source_id=14',$this->source_id==14 ? true : false);
                     }

                return $tab;
            });

            //判断01
            if ($this->source_id ==0) {
                $grid->model()->where('valid',-1);
            } elseif ($this->source_id ==1) {
                $grid->model()->where('valid',1)->where('situation','!=','w');
                //查询过滤
                $grid->selector(function (Grid\Tools\Selector $selector) {
                    $selector->selectOne('situation', '跟进情况：', [
                        'd'=> '待确认',
                        'r' => '进一步确认',
                        'g'=> '跟进中'
                    ]);
                    $selector->selectOne('yiyuan', '客户意愿：', [
                        0 => '弱', 1=> '一般', 2 => '强',3=> '很强',5=> '超强'
                    ]);
                });
            } elseif ($this->source_id ==2 ){
                $grid->model()->where('valid',0);
            }
            elseif($this->source_id==3){
                $grid->model()->where('situation','w');
            }
            elseif($this->source_id==4){
                $grid->model()->where('tracer_id',Admin::user()->id);
                //查询过滤
                $grid->selector(function (Grid\Tools\Selector $selector) {
                    $selector->selectOne('valid', '信息情况：', [-1 => '未跟进', 1=> '有效', 0 => '无效']);
                    $selector->selectOne('situation', '跟进情况：', [
                        'w'=>'已完成',
                        'd'=> '待确认',
                        'r' => '进一步确认',
                        'g'=> '跟进中'
                    ]);
                    $selector->selectOne('yiyuan', '客户意愿：', [
                        0 => '弱', 1=> '一般', 2 => '强',3=> '很强',4=> '超强'
                    ]);
                });
            }
            //判断2
            if ($this->source_id ==11) {
                $grid->model()->where('tracer_id',Admin::user()->id)->where('valid',-1);
            } elseif ($this->source_id ==12) {
                $grid->model()->where('tracer_id',Admin::user()->id)->where('valid',1)->where('situation','!=','w');
                //查询过滤
                $grid->selector(function (Grid\Tools\Selector $selector) {
                    $selector->selectOne('situation', '跟进情况：', [
                        'd'=> '待确认',
                        'r' => '进一步确认',
                        'g'=> '跟进中'
                    ]);
                    $selector->selectOne('yiyuan', '客户意愿：', [
                        0 => '弱', 1=> '一般', 2 => '强',3=> '很强',5=> '超强'
                    ]);
                });
            } elseif ($this->source_id ==13 ){
                $grid->model()->where('tracer_id',Admin::user()->id)->where('valid',0);
            }
            elseif ($this->source_id ==14 ){
                $grid->model()->where('tracer_id',Admin::user()->id)->where('situation','w');
            }


        });
    }
    //获取浏览器参数
    public function __construct(Request $request)
    {
        $this->source_id = $request->source_id;
        return $this;
    }


    /**
     * 详情页构建器
     * 为了复写详情页的布局
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content): Content
    {
        $val = Kehuxiansuo::find($id);
        $phone=Phone::find($val->phone_id);
        $user=Admin::user()->find($val->tracer_id);
        $remarks=explode('|',$val->remark);
        return $content
            ->title($this->title())
            ->description($this->description()['index'] ?? trans('admin.show'))
            ->body(function (Row  $row) use ($id,$remarks,$val,$phone,$user) {
                  // $row->column(4, $this->detail($id));
                $card = new Card('详细信息:', view('xiangqing.xinxi',compact('val','phone','user')));
                $row->column(4, $card);
                    $card = new Card('跟进详情:', view('xiangqing.history',compact('remarks','val')));
                    $row->column(5, $card);
            });
    }
    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id):show
    {
        $model = Kehuxiansuo::with(['phone','user']);
        return Show::make($id,$model, function (Show $show) {
            $show->panel()
                ->tools(function ($tools) {
                    $tools->disableEdit();
                    $tools->disableList();
                    $tools->disableDelete();
                });
            $show->row(function (Show\Row $show) {
                $show->field('phone.phone', '电话')->label();
                $show->field('user.name','跟单者');

            });
            $show->row(function (Show\Row $show) {
                $show->field('valid','信息状态')->unescape()
                    ->using([0 => '<i class="fa fa-toggle-off" style="text-decoration:line-through; color:red "> 无效 </i>',
                        1 => '<i class="fa fa-toggle-on" style="color:green"> 有效 </i>']);

            });
            $show->row(function (Show\Row $show) {
                    $show->field('remark_type','失效类型')->as(function ($remark_type) {
                        if (!empty($remark_type)){
                            $type_index=array('电话不存在','电话多次打不通', '推销电话','被恶意留电话','没有任何意愿','无1314141');
                            $type_value=array('1','2', '3','4','5','0');
                            $remark_type=str_replace($type_value,$type_index,$remark_type);
                            return $remark_type;
                        }
                    })->explode(',')->badge('dark60');
            });
            $show->row(function (Show\Row $show) {
            $show->field('yiyuan','客户意愿')->using([0 => '弱', 1=> '一般', 2 => '强',3=> '很强',4=> '超强'])->dot([
                'default' => 'primary', // 设置默认颜色，不设置则默认为 default
                0 => 'dark50',
                1 => 'orange1',
                2 => 'orange2',
                3 => 'danger',
                4=> 'red-darker',
            ])->width(3);
            $show->field('situation','跟进进度')->unescape()
                ->using(['w' => '已完成', 'd' => '待确认','r' => '进一步确认','g'=>'跟进中'])
                ->dot(['w'=>'success','d'=>'red','r'=>'info','g'=>'orange2']);
            });
            $show->row(function (Show\Row $show) {
            $show->field('remark','跟进详情：')->unescape()
                ->as(function ($remark) {
                // 获取详细说明
                $remarks=explode('|',$remark);
                $mark='';
                $num=0;
                foreach (array_reverse($remarks) as $remark )
                {   $remark=str_replace('@','</span></p><p><span style="padding-left:30px">',$remark);
                    $mark.='<p><i class="fa fa-user-plus " style="color:red;padding-right: 10px"></i><span>'.$remark.'</span></p>';
                    $num=$num+1;
                }
                return "{$mark}";
            });
            });

        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Kehuxiansuo(), function (Form $form) {
            $form->width(5, 2);
            $form->display('id');
            $form->text('phone_id','当前电话id');
            $form->text('tracer_id','跟踪者id');
            $form->text('remark_type','备注类型');

            $form->textarea('remark','备注')->rows(5);

            $form->switch('valid','信息是否有效')->default(1);

            $form->display('created_at');
            $form->display('updated_at');
            $form->slider('age')->options(['超强' => 5, '弱' => 1, 'step' => 1, 'postfix' => '客户意愿']);

        });
    }


}
