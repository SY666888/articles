<?php
namespace App\Admin\Forms;
use Dcat\Admin\Widgets\Form;
use Symfony\Component\HttpFoundation\Response;

class Setting extends Form
{
    /**
     * Handle the form request.
     *
     * @param array $input
     *
     * @return Response
     */
    public function handle(array $input)
    {
        // dump($input);
        admin_setting($input);

        // return $this->error('Your error message.');

        return $this->response()->success('设置成功')->location('settings');
    }

    /**
     * Build a form here.
     * 你不仅仅可以在工具表单里使用上面的方法，你可以在整个laravel项目里，都可以使用上面的方法。比如你需要在视图文件里调用logo。
     * 那么你直接在试图文件里使用admin_setting('logo', '默认值');就可以获取到配置表里logo这一项的value值了。
     */
    public function form()
    {
           $this->tab('基本设置', function () {
            $this->confirm('您确定要提交表单吗', 'content');
            $this->url('web_url', '网站地址')->default(admin_setting('web_url', '/'));
            $this->text('web_name', '网站名称')->default(admin_setting('web_name', 'zsy-admin管理系统'));
            $this->text('web_title', '网站标题')->required()->rules('required|string|min:2')
                ->placeholder('请输入网站标题（一般不超过80个字符）')
                ->default(admin_setting('web_title'));
            $this->text('web_keywords', '网站关键词')->required()->rules('required|string|min:5')
                ->placeholder('请输入关键词（多个之间以,隔开！）')
                ->default(admin_setting('web_keywords'));
            $this->textarea('web_description', '网站描述')->required()->rules('required|string|min:5')
                ->placeholder('请输入网站标题（一般不超过200个字符）')
                ->default(admin_setting('web_description'));
            $this->text('web_icp_record', 'ICP备案')->rules('nullable|string')
                ->placeholder('ICP备XXXX号')
                ->default(admin_setting('web_icp_record'));
            $this->text('web_police_record', '公安备案')->rules('nullable|string')
                ->placeholder('公安备XXXX号')
                ->default(admin_setting('web_police_record'));
            $this->email('support_email', '服务邮箱')->rules('nullable|email')
                ->placeholder('support@xxx.com')
                ->default(admin_setting('support_email'));
            $this->image('web_logo', '网站LOGO')->accept('jpg,png,gif,jpeg')->maxSize(512)
                ->required()->autoUpload()->help('大小不要超过512K')->default(admin_setting('web_logo'));
        });
        $this->tab('系统设置', function () {
            $this->switch('mip_enabled', '启用MIP支持')->default(admin_setting('mip_enabled'));
            $this->switch('amp_enabled', '启用Amp支持')->default(admin_setting('amp_enabled'));
            $this->switch('download_pictures', '下载远程图片')->default(admin_setting('download_pictures'));
            $this->switch('local_censor', '启用本地文本智能审核')->default(admin_setting('local_censor'));

        });

    }
    public function default()
    {
        if (admin_setting('body_class', 0)) {
            $body_class = 0;
        } else {
            $body_class = 1;
        }

        return [
            'logo' => admin_setting('logo', public_path().'/static/img/logo.png'),
            'color' => admin_setting('color', 'green'),
            'body_class' => $body_class,
            'sidebar_style' => admin_setting('sidebar_style', 'light'),
            'menu_layout' => admin_setting('menu_layout', 'sidebar-separate'),
        ];
    }
}
