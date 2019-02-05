<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Essas credenciais não correspondem aos nossos registros.',
    'throttle' => 'Muitas tentativas de login. Tente novamente em :seconds segundos.',
    'login' => [
        'email' => 'E-mail',
        'email_placeholder' => 'Digite aqui seu e-mail',
        'email_helper' => 'O e-mail é a única forma de entrada no sistema e tem formato parecido com "fulano@dominio.com"',
        'password' => 'Senha',
        'password_placeholder' => 'Digite aqui sua senha',
        'password_helper' => 'A senha é a única forma de garantir o acesso as questões do sistema. Caso tenha esquecido clique em "Esqueci minha senha" abaixo e te enviaremos um email para redefinir esta.',
        'title' => 'Entrar no Sistema de Provas',
        'facebook' => 'Login com Facebook',
        'remember' => 'Lembrar-me',
        'submit' => 'Entrar',
        'forgot' => 'Esqueci minha senha',
    ],
    'register' => [
        'title' => 'Registrar-se no Sistema de Provas',
        'facebook' => 'Registrar com Facebook',
        'name' => 'Nome',
        'name_placeholder' => 'Digite seu nome',
        'name_helper' => 'Digite seu nome ou como gostaria de ser chamado',
        'email' => 'E-mail',
        'email_placeholder' => 'Digite seu e-mail',
        'email_helper' => 'Digite o e-mail de sua escolha para entrar no sistema futuramente',
        'password' => 'Senha',
        'password_placeholder' => 'Digite uma senha',
        'password_helper' => 'Escolha uma senha de no mínimo 6 caracteres',
        'password_confirmation' => 'Confirme',
        'password_confirmation_placeholder' => 'Digite a senha anterior',
        'submit' => 'Registrar',
    ],
    'passwords' => [
        'email' => [
            'title' => 'Resetar Senha',
            'email' => 'E-mail',
            'email_placeholder' => 'Digite seu e-mail',
            'email_helper' => 'Apenas com o e-mail é possivel recuperar a conta',
            'submit' => 'Enviar',
        ],
        'reset' => [
            'title' => 'Resetar Senha',
            'email' => 'E-mail',
            'email_placeholder' => 'Digite seu e-mail',
            'email_helper' => 'Digite o seu e-mail',
            'password' => 'Senha',
            'password_placeholder' => 'Digite uma senha',
            'password_helper' => 'Escolha uma senha de no mínimo 6 caracteres',
            'password_confirmation' => 'Confirme',
            'password_confirmation_placeholder' => 'Digite a senha anterior',
            'submit' => 'Resetar',
        ]
    ]
];

