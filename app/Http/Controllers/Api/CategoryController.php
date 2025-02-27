<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends ApiController{

    public function store(){
        $request= new CategoryRequest();
        $inputs=$request->all();
        if(empty($request->parent_id)){
            unset($inputs['parent_id']);
        }
        Category::create($inputs);
        return redirect('admin/category');
    }

    public function update($id){
        $request= new CategoryRequest();
        $inputs=$request->all();
        Category::update(array_merge($inputs,['id'=>$id]));
        return redirect('admin/category');
    }
    public function destroy($id){
        Category::delete($id);
        return redirect('admin/category');
    }
}
