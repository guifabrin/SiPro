<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Variáveis de caminho dos arquivos Blade
     */
    private $userViewBlade = "user.view";
    private $passwordFormBlade = "user.password.form";

    /**
     * Array de mensagens de retorno das ações executadas no UserController
     */
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
     * Construtor
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Função de retorno da página de configuração do usuário
     *
     * @return view
     */
    public function read()
    {
        return view($this->userViewBlade);
    }

    /**
     * Função de retorno da página de alteração de senha do usuário
     *
     * @return view
     */
    public function passwordForm()
    {
        return view($this->passwordFormBlade);
    }

    /**
     * Função de alteração de senha do usuário
     *
     * @return view
     */
    public function updatePassword(Request $request)
    {
        $args = ['id' => \Auth::user()->id];
        $userQuery = User::where($args);
        $user = $userQuery->first();

        $input = $request->all();

        $password = $input['password'];
        $newPassword = $input['new-password'];

        $oldPasswordSetted = isset($input['old-password']);

        //Caso o usuário tenha registrado com o Facebook não existirá uma senha antiga.
        if ($oldPasswordSetted) {
            $oldPassword = $input['old-password'];
        }

        if ($password == $newPassword) {
            if ($user->password != "" && $oldPasswordSetted && !\Hash::check($oldPassword, $user->password)) {
                return view($this->passwordFormBlade)->with('message', $this->messages['diff_old']);
            }
            //Caso a senha do usuário exista e a senha antiga esteja setada e corresponda a existente.
            $bcryptPassword = bcrypt($password);
            if ($userQuery->update(['password' => $bcryptPassword])) {
                \Auth::user()->password = $bcryptPassword;
                return view($this->passwordFormBlade)->with('message', $this->messages['ok']);
            } else {
                return view($this->passwordFormBlade)->with('message', $this->messages['error']);
            }
        } else {
            //Caso as novas senhas não correspondam.
            return view($this->passwordFormBlade)->with('message', $this->messages['diff_new']);
        }
    }
}