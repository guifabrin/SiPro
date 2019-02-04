<?php

$arrQuestionsLang = [
    'categories' => [
        'view' => [
            'back' => 'Voltar',
            'add' => 'Adicionar',
            'categorie' => [
                'none' => 'Nenhum'
            ],
            'see' => 'Ver',
            'remove' => 'Remover',
            'edit' => 'Editar'
        ],
        'confirm' => [
            'back' => 'Voltar',
            'remove_categorie_question_message' => 'Removendo a categoria de questão, você também remove as questões. Caso você tenha algum teste com questões dessa categoria de questão a questão irá ser removida. Tem certeza que deseja remover a categoria de questão',
            'yes' => 'Sim',
            'no' => 'Não    ',
        ],
        'form' => [
            'id' => 'Código',
            'id_placeholder' => 'Código gerado automaticamente',
            'categorie' => [
                'none' => 'Nenhum'
            ],
            'description' => 'Descrição',
            'description_placeholder' => 'Coloque aqui a descrição da sua categoria',
            'back' => 'Voltar',
            'submit' => 'Salvar'
        ]
    ],
    'view' =>[
        'title' => 'Minhas questões',
        'back' => 'Voltar',
        'add' => 'Adicionar',
        'code' => 'Código',
        'image' => 'Imagem',
        'description' => 'Descrição',
        'actions' => 'Ações',
        'see' => 'Ver'
    ],
    'form' => [
        'id' => 'Código',
        'id_placeholder' => 'Código gerado automaticamente',
        'categorie_id' => 'Categoria de questão',
        'description' => 'Descrição',
        'image' => 'Selecione a imagem da questão',
        'categorie' => [
            'none' => 'Nenhum'
        ],
        'type' => 'Tipo',
        'descriptive' => 'Descritiva',
        'optative' => 'Optativa',
        'true_false' => 'Verdadeira ou Falso',
        'lines' => 'Linhas',
        'submit' => 'Salvar',
        'options' => 'Opções',
        'right' => 'Correta?',
        'option-correct[]' => '',
        'back' => 'Voltar'
    ]
];
for ($i =0; $i< 5; $i++) {
    $arrQuestionsLang['form']['option-description['.$i.']'] = '';
    $arrQuestionsLang['form']['option-image['.$i.']'] = 'Selecione a imagem da opção';
}
return $arrQuestionsLang;
