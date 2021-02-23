<?php

namespace App\Admin\Forms;

use Dcat\Admin\Widgets\Form;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;

class AdminSetting extends Form
{
    /**
     * 主题颜色.
     *
     * @var array
     */
    protected $colors = [
        'blue' => '支付宝蓝',
        'blue-light' => '飞书蓝',
        'green'      => '微信绿',
	    'default'  =>'政府蓝',
    ];


    /**
     * 处理表单请求.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        $bodyClass = $input['layout']['body_class'];

        $input['layout']['body_class'] = is_array($bodyClass) ? implode(' ', $bodyClass) : $bodyClass;

        foreach (Arr::dot($input) as $k => $v) {
            $this->update($k, $v);
        }

        //return $this->ajaxResponse('设置成功');
		 return $this->response()->success('设置成功')->refresh();
    }

    /**
     * 构建表单.
     */
    public function form()
    {
        $this->text('name')->required()->help('网站名称')->default(admin_setting('crmname', '13231'));
        $this->text('logo')->required()->help('logo设置');
        $this->text('logo-mini', 'Logo mini')->required();
        $this->radio('lang', '语言')->required()->options(['en' => 'English', 'zh_CN' => '简体中文'])->default('zh_CN');
        $this->radio('layout.color', '主题')
            ->required()
            ->help('主题颜色，支持自定义！')
            ->options($this->colors)
            ->default('green');
        $this->radio('layout.sidebar_style', '侧栏颜色')
            ->options(['light' => '默认', 'primary' => '主题色','dark' => '黑色'])
            ->help('切换侧栏颜色')
            ->default('light');
			$this->radio('layout.navbar_color', '顶栏颜色')
            ->options(['light' => '默认', 'bg-primary' => 'bg-primary','bg-info' => 'bg-info','bg-warning' => 'bg-warning','bg-success' => 'bg-success','bg-danger' => 'bg-danger','bg-dark' => 'bg-dark'])
            ->help('切换顶栏颜色')->default('light');

		$this->radio('layout.body_class', '侧栏布局')->options(['default' => '默认', 'sidebar-separate' => '分离']);
//        $this->switch('https', '启用HTTPS');
        $this->switch('helpers.enable', '开发工具');
    }

    /**
     * 设置接口保存成功后的回调JS代码.
     *
     * 1.2秒后刷新整个页面.
     *
     * @return string|void
     */
    public function addSavedScript()
    {
        return <<<'JS'
    if (data.status) {
        setTimeout(function () {
          location.reload()
        }, 1200);
    }
JS;
    }

    /**
     * 返回表单数据.
     *
     * @return array
     */
    public function default()
    {
        return user_admin_config();
    }

    /**
     * 更新配置.
     *
     * @param string $key
     * @param string $value
     */
    protected function update($key, $value)
    {
        user_admin_config([$key => $value]);
    }
}
