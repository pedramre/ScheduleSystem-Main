<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Validator;

class RoleController extends Controller
{
    public function edit(Request $request, Response $response)
    {
        $input = $request->all();
        $validator = Validator::make($input['role'], [
            'name' => 'required|max:30',
        ]);

        if ($validator->fails()) {
            return $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages' => $validator->messages()])
                ->send();
        }

        $role = Role::where('id', $input['role']['id'])->first();

        if (!empty($role)) {
            $role->name = $input['role']['name'];
            $role->save();
            $role->syncPermissions($input['localPermissions']);

            return $response->setMessage('Edit Successfully')->send();
        } else {
            return $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }

    }
}
