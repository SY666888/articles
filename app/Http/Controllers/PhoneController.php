<?php

namespace App\Http\Controllers;
use  App\Models\Phone;
use Illuminate\Http\Request;

class   PhoneController  extends Controller
{
    public  function index (Request  $request)
    {
        $request['ip']=$request->getClientIp();
        $request['host']=$request->input('host');
        $request['referer']=$_SERVER['HTTP_REFERER'];
        $data=Phone::create($request->except('_token'));//向数据库中添加除却_token之外的数据
        if ($data){
            $info=['status'=>1,'message'=>'添加成功'];
        }else{
            $info=['status'=>0,'message'=>'添加失败'];
        }
        return $info;
    }
}
