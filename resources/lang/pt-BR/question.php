<?php

$arrQuestionsLang = [
    'view' => [
        'title' => 'Minhas questões',
        'back' => 'Voltar',
        'add' => 'Adicionar',
        'code' => 'Código',
        'image' => 'Imagem',
        'description' => 'Descrição',
        'actions' => 'Ações',
        'see' => 'Ver',
        'none' => 'Nenhum',
        'mines_gender_a' => 'Minhas',
        'questions' => 'Questões',
        'remove' => 'Remover',
        'edit' => 'Editar',

    ],
    'form' => [
        'add' => 'Adicionar',
        'id' => 'Código',
        'id_placeholder' => 'Código gerado automaticamente',
        'categorie_id' => 'Categoria de questão',
        'description' => 'Descrição',
        'image' => 'Selecione a imagem da questão',
        'none' => 'Nenhum',
        'type' => 'Tipo',
        'descriptive' => 'Descritiva',
        'optative' => 'Optativa',
        'true_false' => 'Verdadeira ou Falso',
        'lines' => 'Linhas',
        'submit' => 'Salvar',
        'options' => 'Opções',
        'right' => 'Correta?',
        'option-correct[]' => '',
        'back' => 'Voltar',
        'edit' => 'Editar',
        'question' => 'Questão',
        'title' => 'Editar questão',
        'description_placeholder' => 'Digite aqui o texto da questão',
        'lines_placeholder' => 'Diga quantas linhas o aluno terá para responder a questão',
        'type_placeholder' => 'Selecione o tipo da questão',
        'selected_image' => 'Imagem selecionada'
    ],
    'from' => [
        'category' => [
            'controller' => [
                'index' => [
                    'none_message' => 'Nenhuma questão cadastrada'
                ]
            ]
        ]
    ],
    'confirm' => [
        'back' => 'Voltar',
        'yes' => 'Sim',
        'no' => 'Não',
        'remove_question_message' => "Tem certeza que deseja remover a questão "
    ]
];
for ($i = 0; $i < 5; $i++) {
    $arrQuestionsLang['form']['option-description[' . $i . ']'] = '';
    $arrQuestionsLang['form']['option-image[' . $i . ']'] = 'Selecione a imagem da opção';
    $arrQuestionsLang['form']['option-description[' . $i . ']_placeholder'] = 'Digite o texto da opção';
}
return $arrQuestionsLang;
