<?php

namespace App\Admin\Controllers;
use Dcat\Admin\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use  App\Models\Arctype;
class DeleteController extends AdminController
{
    /**
     * 栏目删除
     * @param   $request验证，栏目id
     *
     * @return redirect
     */
    function DeleteCategory(Request $request,$id){
        
        if(empty(Arctype::where('parent_id',$id)->value('id')))
        {
            Arctype::findOrFail($id)->delete();
            return '栏目删除成功';
        }else{
            return '当前栏目包含子栏目，请先删除子栏目';
        }

    }
}
