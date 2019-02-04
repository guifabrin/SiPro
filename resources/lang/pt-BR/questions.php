<?php

$arrQuestionsLang = [
    'view' =>[
        'title' => 'Minhas questões',
        'back' => 'Voltar',
        'add' => 'Adicionar',
        'code' => 'Código',
        'image' => 'Imagem',
        'description' => 'Descrição',
        'actions' => 'Ações',
        'see' => 'Ver',
        'categorie' => [
            'none' => 'Nenhum'
        ],
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
