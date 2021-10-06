<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Validator;

class UserController extends Controller
{

    public function login(Request $request,Response $response){
        $input = $request->all();

        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return  $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages'=>$validator->messages()])
                ->send();
        }

        if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']],'web')) {
            return  $response->setMessage('Successful Login, Congratulations !!!')->send();
        }
        else{
            return  $response->setSuccess(false)
                ->setMessage('No user with this profile was found, Please first register in panel')
                ->send();
        }

    }

    public function register(Request $request,Response $response){
        $input = $request->all();

        $validator = Validator::make($input['user'], [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            return  $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages'=>$validator->messages()])
                ->send();
        }

        $input['user']['password'] = bcrypt($input['user']['password']);
        $user = User::create($input['user']);
        if($user){
            if(Auth::loginUsingId($user->id)){
                return  $response->setMessage('Successful Register. Congratulations !!!')->send();
            }
            else{
                return  $response->setSuccess(false)
                    ->setMessage('Please try again ...')
                    ->send();
            }
        }
        else{
            return  $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }
    }

    public function edit(Request $request,Response $response){
        $input = $request->all();
        $validator = Validator::make($input['user'], [
            'name' => 'required|max:30',
        ]);
        if ($validator->fails()) {
            return  $response->setSuccess(false)
                ->setMessage('Please Enter Valid Character')
                ->setData(['errorMessages'=>$validator->messages()])
                ->send();
        }

        $user = User::where('id',$input['user']['id'])->first();
        $role = $input['user']['roles'][0];
        unset($input['user']['roles']);

        if(!empty($user)){
            $user->update($input['user']);
            $role = Role::where('id',$role['id'])->first();

            $user->syncRoles($role);

            return  $response->setMessage('Edit Successfully')->send();
        }
        else{
            return  $response->setSuccess(false)
                ->setMessage('Please try again ...')
                ->send();
        }


    }



}
