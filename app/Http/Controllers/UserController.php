<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller {

	private $userViewBlade = "user.view";
	private $passwordFormBlade = "user.password.form";

	private $messages = [
		'ok' => [
			'status' => 'success',
			'message' => 'A senha foi atualizada.',
		],
		'error' => [
			'status' => 'danger',
			'message' => 'As novas senhas não condizem.',
		],
		'diff_new' => [
			'status' => 'danger',
			'message' => 'As novas senhas não condizem.',
		],
		'diff_old' => [
			'status' => 'danger',
			'message' => 'A senha antiga não condiz.',
		],
	];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	public function read() {
		return view($this->userViewBlade);
	}

	public function passwordForm() {
		return view($this->passwordFormBlade);
	}

	public function updatePassword(Request $request) {
		$args = ['id' => \Auth::user()->id];
		$userQuery = User::where($args);
		$user = $userQuery->first();

		$input = $request->all();

		$password = $input['password'];
		$newPassword = $input['new-password'];
		if (isset($input['old-password'])) {
			$oldPassword = $input['old-password'];
		}

		if ($password == $newPassword) {
			if ($user->password != "" && isset($oldPassword) && !\Hash::check($oldPassword, $user->password)) {
				return view($this->passwordFormBlade)->with('message', $this->messages['diff_old']);
			}
			$bcryptPassword = bcrypt($password);
			if ($userQuery->update(['password' => $bcryptPassword])) {
				\Auth::user()->password = $bcryptPassword;
				return view($this->passwordFormBlade)->with('message', $this->messages['ok']);
			} else {
				return view($this->passwordFormBlade)->with('message', $this->messages['error']);
			}
		} else {
			return view($this->passwordFormBlade)->with('message', $this->messages['diff_new']);
		}
	}
}