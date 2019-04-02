<?php

$arrQuestionsLang = [
    "confirm" => [
        "back" => "Voltar",
        "no" => "Não",
        "remove_question_message" => "Tem certeza que deseja remover a questão ",
        "yes" => "Sim",
    ],
    "form" => [
        "add" => "Adicionar",
        "back" => "Voltar",
        "category_id" => "Categoria de questão",
        "description" => "Descrição",
        "description_placeholder" => "Digite aqui o texto da questão",
        "descriptive" => "Descritiva",
        "edit" => "Editar",
        "id" => "Código",
        "id_placeholder" => "Código gerado automaticamente",
        "image" => "Selecione a imagem da questão",
        "lines" => "Linhas",
        "lines_placeholder" => "Diga quantas linhas o aluno terá para responder a questão",
        "none" => "Nenhum",
        "optative" => "Optativa",
        "option-correct[]" => "",
        "options" => "Opções",
        "question" => "Questão",
        "right" => "Correta?",
        "selected_image" => "Imagem selecionada",
        "submit" => "Salvar",
        "title" => "Editar questão",
        "true_false" => "Verdadeira ou Falso",
        "type" => "Tipo",
        "type_placeholder" => "Selecione o tipo da questão",
    ],
    "view" => [
        "actions" => "Ações",
        "add" => "Adicionar",
        "back" => "Voltar",
        "code" => "Código",
        "description" => "Descrição",
        "edit" => "Editar",
        "image" => "Imagem",
        "mines_gender_a" => "Minhas",
        "none" => "Nenhum",
        "questions" => ":action questões :name",
        "remove" => "Remover",
        "see" => "Ver",
        "title" => ":action questões :name",
    ],
];
for ($i = 0; $i < 5; $i++) {
    $arrQuestionsLang["form"]["option-description[" . $i . "]"] = "";
    $arrQuestionsLang["form"]["option-image[" . $i . "]"] = "Selecione a imagem da opção";
    $arrQuestionsLang["form"]["option-description[" . $i . "]_placeholder"] = "Digite o texto da opção";
}
return $arrQuestionsLang;
