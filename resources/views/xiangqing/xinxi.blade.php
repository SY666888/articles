
<div class="ft">
        <div class="timeline-item">
            <p style="color:red;font-size:14px"><strong>客户信息：</strong></p>
        </div>
        <p >客户电话：{{$phone->phone}}</p>
        <p>客户姓名：{{$phone->name}}</p>
        <p>信息备注：{{$phone->remark}}</p>
        <p>信息来源：{{$phone->host}}</p>
        <p>信息创建日期：{{$phone->created_at}}</p>
        <hr>
        <div class="timeline-item">
            <p style="color:red;font-size:14px"><strong>信息状态：</strong></p>
        </div>
        @if($val->valid==1)
        <p>信息状态：<i class="fa fa-toggle-on" style="color:green"> 有效 </i></p>
           @if($val->yiyuan==0)
            <p>客户意愿：<i class='fa fa-circle' style='font-size: 13px;color:#E5E5E5'></i>&nbsp;&nbsp;弱</p>
            @elseif($val->yiyuan==1)
                <p>客户意愿：<i class='fa fa-circle' style='font-size: 13px;color: #FFE4C4'></i>&nbsp;&nbsp;一般</p>
            @elseif($val->yiyuan==2)
                <p>客户意愿：<i class='fa fa-circle' style='font-size: 13px;color: #F99037'></i>&nbsp;&nbsp;强</p>
            @elseif($val->yiyuan==3)
                <p>客户意愿：<i class='fa fa-circle' style='font-size: 13px;color: #cc3366'></i>&nbsp;&nbsp;很强</p>
            @elseif($val->yiyuan==4)
                <p>客户意愿：<i class='fa fa-circle' style='font-size: 13px;color: #cc0033'></i>&nbsp;&nbsp;超强</p>
            @endif

            @if($val->situation=='w')
                <p>跟进情况：<span class="bg-success">完成</span></p>
            @elseif($val->situation=='d')
                <p>跟进情况：<span class="bg-red">待确认</span></p>
            @elseif($val->situation=='r')
                <p>跟进情况：<span class="bg-info">进一步确认</span></p>
             @elseif($val->situation=='g')
                <p>跟进情况：<span class="bg-orange">跟进中</span></p>
              @endif

        @else($val->valid==0)
            <?php
            $remark_type=$val->remark_type;
            $type_index=array('电话不存在','电话多次打不通', '推销电话','被恶意留电话','没有任何意愿');
            $type_value=array('1','2', '3','4','5');
            $remark_type=str_replace($type_value,$type_index,$remark_type);
            ?>
            <p>信息状态：<i class="fa fa-toggle-off" style="text-decoration:line-through; color:red "> 无效 </i></p>
            <p>失效原因：{{$remark_type}}</p>
        @endif
    <hr>
    <div class="timeline-item" >
        <p style="color:red;font-size:14px"><strong>员工信息：</strong></p>
    </div>

    <p >员工：{{$user->name}}</p>
    <p>手机：{{$user->mobile}}</p>
    <p>QQ：{{$user->qq}}</p>
    <p>微信号：{{$user->wechat}}</p>
    <p>邮箱：{{$user->email}}</p>
        </div>





<style>
    .timeline-item, .timeline-header  {
        font-size: 10;
        padding-top: 20px;
        background: none !important;
        color: #a8a9bb !important;
    }
    .ft{color: green;}
</style>
