<?php

namespace App\Admin\Controllers;
use App\Admin\Repositories\Articlecreate;
use App\Admin\Repositories\Arctype;
use  App\Models\Arctype as ArctypeModel;
use  App\Models\Articlecreate as ArticlecreateModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Admin;
use Carbon\Carbon;
use Dcat\Admin\Http\Controllers\AdminController;
use App\Admin\Actions\Post\Restore;
use App\Admin\Actions\Post\BatchRestore;
use App\Admin\Extensions\Tools\IsmakePost;
use App\Admin\Actions\Grid\BatchResetTypeid;
class ArticlecreateController extends AdminController
{
    protected $title = '文章管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Articlecreate(), function (Grid $grid) {
            $grid->model()->with(['arctype']);
            $grid->column('id')->sortable();
            $grid->quickSearch(['id', 'title']);
            //限制数据范围
            $grid->model()->whereIn('typeid',ArctypeModel::where('mid',1)->pluck('id'));
            // 标题设置
            $grid->column('title','标题')->width('35%')
            ->setHeaderAttributes(['style' => 'color:#d71345'])->display(function ($title)
             {
                        $titleid=ArticlecreateModel::where('title',$title)->value('ismake');
                        if ($titleid==0){
                          return "<del style='color:red'>$title</del>";
                        }
                        else
                            {
                                return  $title  ;
                            }
            });
            #获取栏目名称
            $grid->column('arctype.title','栏目名称')->label();
            $grid->column('click','点击');
            $grid->column('write','发布人');
            $grid->column('created_at')->display(function ($created_at) {
                $expired_at=Carbon::now()->subDays(2);//addDays(30) 向前加30天，subDays(30)向后减掉30天
                if($created_at<$expired_at){
                    return  $created_at;
                }
                else{
                    return ArticlecreateModel::find($this->id)->created_at->diffForHumans ();
                }
            });
            $grid->column('updated_at')->sortable();

            $grid->column('ismake','状态');

            $grid->column('ismake','状态')->display(function ($ismake) {
                if ($ismake==1){
                    return  '审核';
                }
                else{return  '未审核';}

            });
            $grid->filter(function (Grid\Filter $filter) {
                $datas=ArctypeModel::where('mid',1)->get();
                $fl=[];
                foreach ($datas as $data){
                    $fl[$data->id] = $data->title;
                }
                $filter->panel();
                //$filter->equal('write');
                $filter->equal('typeid','栏目')->select($fl)->width(3);
                $filter->between('created_at','发布时间')->date()->width(4);
                $filter->scope('trashed', '回收站')->onlyTrashed();
                $filter->scope('write','我的文章')->where('write',Admin::user()->name);
                // 多条件查询
                $filter->scope('new', '最近修改')
                    ->whereDate('created_at', date('Y-m-d'))
                    ->orWhere('updated_at', date('Y-m-d'));
            });
            //表格规格筛选器
            $grid->selector(function (Grid\Tools\Selector $selector) {
                $datas=ArctypeModel::where('parent_id',1)->get();
                $fl=[];
                foreach ($datas as $data){
                    $fl[$data->id] = $data->title;
                }
                $selector->selectone('typeid', '品牌分类:', $fl);
                $selector->selectOne('ismake', '文章状态：', [
                    0 => '未审核',
                    1 => '已审核',

                ]);
            });
            //$grid->tools('<a  href="/admin/article?write='.Admin::user()->name.'"  class="btn btn-primary ">我的文章</a>');
            //批量恢复操作
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(ArticlecreateModel::class));
                }
            });
            //单行恢复操作
            /*$grid->actions(function (Grid\Displayers\Actions $actions) {
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(ArticlecreateModel::class));
                }
            });*/
            $grid->batchActions([
                new IsmakePost('审核文章', 1),
                new IsmakePost('文章下线', 0)
            ]);

            $grid->batchActions([new BatchResetTypeid()]);

            // 禁用删除、编辑、显示等按钮
            $grid->disableDeleteButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            //切换行操作显示方法
            $grid->setActionClass(Grid\Displayers\Actions::class);

            //添加操作按纽
            $grid->actions(function (Grid\Displayers\Actions $actions) {

                $actions->append('  <a  title="预览" href="/admin/article/'.$this->id.'" class="label bg-primary ">预览</a>');
                $actions->append('  <a  title="编辑" href="/admin/article/'.$this->id.'/edit" class="label bg-info ">编辑</a>');
                $actions->append('  <a  title="删除" href="javascript:void(0);" data-message="ID - '.$this->id.'" data-url="/admin/article/'.$this->id.'" data-action="delete" class="label bg-red">删除</a>');

            });

        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Articlecreate(), function (Show $show) {
            $show->field('id');
            $show->field('typeid');
            $show->field('title');
            $show->field('shorttitle');
            $show->field('tags');
            $show->field('keywords');
            $show->field('description');
            $show->field('ismake');
            $show->field('click');
            $show->field('flags');
            $show->field('write');
            $show->field('litpic');
            $show->field('body');
            $show->field('published_at');
            $show->field('imagepics');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Articlecreate(), function (Form $form) {
            $form->fieldset('文章基本信息', function (Form $form) {
                    $form->width(6, 2);
                    $form->display('id');
                    $form->select('typeid','所属栏目')->options(ArctypeModel::SelectOptions());
                    $form->text('title','文章标题');
                   $form->checkbox('flags','自定义属性')
                   ->options(['h'=>'头条', 'c'=>'推荐', 'r'=>'热门', 'f'=>'幻灯', 's'=>'滚动','a'=>'特荐','p'=>'图片'])
                   ->saving(function ($value) {
                       $value=implode(',', $value);
                       //提取文章中的图片
                       $img=preg_match('/<[img|IMG].*?src=[\' | \"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/i',request()->get('body'),$match);
                       if(request('litpic')||$img)
                       {
                                 if(empty($value)){
                                     $value.='p';
                                 }
                                 else{
                                     $value.=',p';
                                 }
                          }
                        // 转化成json字符串保存到数据库
                        //return json_encode($value);
                       // 可以转化为由 , 隔开的字符串格式
                       return str_replace('p,p','p',$value);
                        });
                    $form->text('shorttitle','简略标题');
                    $form->text('tags','tag标签');
                    $form->text('keywords','关键字');
                    $form->textarea('description','文档描述')->rows(5)
                        ->saving(function ($description){
                            //自动获取文章前100字作为描述
                            return Articlecreate::StringToText(request()->body,100);
                        });
                    $form->radio('ismake','文章状态')->options(['0' => '未审核', '1'=> '已审核'])->default('1');
                    $form->datetime('published_at','预选发布时间');
            });
            //缩略图处理
           $form->fieldset('缩略图上传', function (Form $form) {
               $form->image('litpic','缩略图')->autoUpload()
                   ->accept('jpg,png,gif,jpeg')
                   ->maxSize(10240)   //设置为10M
                   ->uniqueName()
                   ->move('images'.date('/Y/m/d',time()))
                   //自动提取文章中第一张图片作为缩略图
                   ->saving(function ($path) {
                     $img=preg_match('/<[img|IMG].*?src=[\' | \"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?>/i',request()->get('body'),$match);
                      if(empty($path)&&$img)
                      {
                          $path=$match[1];
                      }
                    return $path;
                   });
            });

            //图集处理
           $form->fieldset('批量上传图集', function (Form $form) {
                $form->multipleImage('imagepics','图集处理')->limit(4)
                    ->accept('jpg,png,gif,jpeg')
                    ->maxSize(10240)   //设置为10M
                    ->uniqueName()
                    ->move('images'.date('/Y/m/d',time()))
                    ->saving(function ($paths){
                    // 可以转化为由 , 隔开的字符串格式
                    return implode(',', $paths);
                    // 也可以转化为json
                    //return json_encode($paths);
                 });
            });
            $form->fieldset('内容编辑', function (Form $form) {
               $form->editor('body','内容')->height('600')->width(10,2);
            });
            $form->hidden('click')->saving(function ($value) {
                return rand(100,900);
            });

            $form->hidden('write');
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    $form->write=Admin::user()->name;}
                if ($form->isEditing()) {
                    $form->write=Admin::user()->name;
                   }
                });
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
