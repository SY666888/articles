<script type="text/javascript" src="/liuyan/jquery.min.js"></script>
<script type="text/javascript" src="/liuyan/jquery.SuperSlide.2.1.1.js"></script>
<link rel="stylesheet" type="text/css" href="/liuyan/liuyan.css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
 <!--我要留言 开始-->
<div class="gbook" id="msg">
    <div class="hd">用户留言<span class="gb_tips">（如果您对该项目感兴趣，请留言立即获得最新加盟资料！）</span></div>
    <div class="bd">
        <div class="bd_mag">
            <form class="message_form" onsubmit="return false" >
                @csrf
                <ul>
                       <input type="hidden" name="project_id"  id="project_id"  value="123" >
                        <input type="hidden" name="cid" id="cid" value="1">
                        <input type="hidden" name="title" id="fm_title" value="乐仕汉堡加盟">
                        <input type="hidden" name="cla" id="cla" value="快餐">
                        <input type="hidden" name="combrand" id="combrand" value="乐仕汉堡加盟">
                         <input type="hidden" name="referer" id="referer" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
                                        <li> <span class="txt"><i>*</i>姓名</span>
                        <input name="name" id="sub_name" value="" class="input_bk" placeholder="您的真实姓名" type="text">
                    </li>
                    <li><span class="txt"><i>*</i>手机</span>
                        <input class="input_bk" name="phone" id="sub_iphone" placeholder="电话是与您联系的重要方式" type="text">
                    </li>
                    <li><span class="txt"><i>*</i>金额</span>
                        <select name="jine" class="select_money">
                            <option value="0">请选择金额</option>
                            <option value="1">1-5万</option>
                            <option value="2">5-10万</option>
                            <option value="3">10-15万</option>
                            <option value="4">15-30万</option>
                            <option value="5">30-50万</option>
                            <option value="6">50-100万</option>
                            <option value="7">100万以上</option>
                        </select>
                    </li>
                    <li> <span class="txt"><i>*</i>留言</span>
                        <textarea id="content" name="content" class="textarea_bk" placeholder="请输入您的留言内容或选择快捷留言"></textarea>
                        <div class="check_msg">
                            <div class="check_msg_tit"><i>◆</i>您可以根据下列意向，快捷留言</div>
                            <div class="check_msg_bd">
                                <ul>
                                    <li><a href="javascript:;" class="no" target="_self">我有意向，请问加盟费是多少？</a></li>
                                    <li><a href="javascript:;" class="no" target="_self">很想合作，来电话细谈吧。</a></li>
                                    <li><a href="javascript:;" class="no" target="_self">请问具体的加盟流程是怎样的？</a></li>
                                    <li><a href="javascript:;" class="no" target="_self">请问贵公司哪里有样板店或直营店？</a></li>
                                    <li><a href="javascript:;" class="no" target="_self">请给我打电话并寄送加盟资料。</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li> <span class="txt">&nbsp;</span>
                        <input value="提交-立即获得最新加盟资料" id="sub_btn" class="btn" type="submit">
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
<!--我要留言 结束-->
<script>
$(function(){

//客户留言
    jQuery("#js_msg").slide({mainCell:".bd ul",autoPlay:true,effect:"topMarquee",vis:3,interTime:50,pnLoop:false,trigger:"click"});

$(".liuyan-right li").click(function(){
    $(".liuyan-cen textarea").val($(this).text());
});

$(".check_msg_bd li").click(function(){
    $("#content").val($(this).text());
});


//留言
    $(function(){
        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#sub_btn").click(function(){
            var phone = $("#sub_iphone").val();
            var name = $("#sub_name").val();
            var note = $("#content").val();
            var project_id = $("#project_id").val();
            var cid = $("#cid").val();
            var referer = $("#referer").val();
            var title = $("#fm_title").val();
            var cla = $("#cla").val();
            var combrand = $("#combrand").val();
            var remark= $("#content").val();
            var host=window.location.href;
            if( phone  && /^1[3|4|5|6|7|8|9]\d{9}$/.test(phone) ){
                $.ajax({
                    //提交数据的类型 POST GET
                    type:"POST",
                    //提交的网址
                    url:"Phone",
                    //提交的数据
                    data:{"phone":phone,"host":host,"name":name,"remark":remark,"referer":referer},
                    //返回数据的格式
                    datatype: "html",    //"xml", "html", "script", "json", "jsonp", "text"
                    success:function () {
                    alert("电话提交成功！");
                }
                });
            } else{
                alert("您输入的手机号码"+phone+"不正确，请重新输入")
            }
        })
    });

});

</script>




