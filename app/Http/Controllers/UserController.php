<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Base\Controller;

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
}