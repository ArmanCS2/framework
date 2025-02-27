<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Admin\UserRequest;
use App\Http\Services\ImageUpload;
use App\User;

class UserController extends ApiController
{


    public function update($id)
    {
        $request = new UserRequest();
        $inputs = $request->all();
        $updateables = ['first_name', 'last_name'];
        $inputs = array_intersect_key($inputs, array_flip($updateables));
        $file = $request->file('avatar');
        if (!empty($file['tmp_name'])) {
            $inputs['avatar'] = ImageUpload::uploadAndFitImage($file, path('avatars'), name(), 100, 100);
        }
        $inputs['id'] = $id;
        User::update($inputs);
        return redirect('admin/user');
    }

    public function changeStatus($id)
    {
        $user = User::find($id);
        if ($user->is_active == 0) {
            User::update(['is_active' => 1, 'id' => $id]);
        } else {
            User::update(['is_active' => 0, 'id' => $id]);
        }
        return redirect('admin/user');
    }
}