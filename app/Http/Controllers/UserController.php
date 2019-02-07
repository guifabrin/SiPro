<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends Controller
{

    public function index()
    {
        return view('user.view', ['isSocialAccount' => $this->isSocialAccount()]);
    }

    private function isSocialAccount()
    {
        return Auth::user()->password == "";
    }

    public function update(Request $request)
    {
        $validator = $this->validate($request);
        if (!$validator->fails()) {
            $user = \Auth::user();
            $user->update(['password' => bcrypt($request->input('password'))]);
        }
        return redirect()->to('user')->withErrors($validator);
    }

    public function validate(Request $request, array $_rules = [], array $_messages = [],
                             array $_customAttributes = [])
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|same:new-password'
        ]);
        $validator->after(function ($validator) use ($request) {
            if (!$this->isSocialAccount() && !\Hash::check($request->input('old-password'), \Auth::user()->password)) {
                $validator->errors()->add('old-password', _v('old-password'));
            }
        });
        return $validator;
    }

//    public function updatePassword(Request $request)
//    {
//        $args = ['id' => \Auth::user()->id];
//        $userQuery = User::where($args);
//        $user = $userQuery->first();
//
//        $input = $request->all();
//
//        $password = $input['password'];
//        $newPassword = $input['new-password'];
//
//        $oldPasswordSetted = isset($input['old-password']);
//
//        //Caso o usuário tenha registrado com o Facebook não existirá uma senha antiga.
//        if ($oldPasswordSetted) {
//            $oldPassword = $input['old-password'];
//        }
//
//        if ($password == $newPassword) {
//            if ($user->password != "" && $oldPasswordSetted && !\Hash::check($oldPassword, $user->password)) {
//                return view($this->passwordFormBlade)->with('message', $this->messages['diff_old']);
//            }
//            //Caso a senha do usuário exista e a senha antiga esteja setada e corresponda a existente.
//            $bcryptPassword = bcrypt($password);
//            if ($userQuery->update(['password' => $bcryptPassword])) {
//                \Auth::user()->password = $bcryptPassword;
//                return view($this->passwordFormBlade)->with('message', $this->messages['ok']);
//            } else {
//                return view($this->passwordFormBlade)->with('message', $this->messages['error']);
//            }
//        } else {
//            //Caso as novas senhas não correspondam.
//            return view($this->passwordFormBlade)->with('message', $this->messages['diff_new']);
//        }
//    }
}