<?php

return [
	"no" => "Não",
	"see" => "Ver",
	"yes" => "Sim",
	"back" => "Voltar",
	"edit" => "Editar",
	"add" => "Adicionar",
	"remove" => "Remover",
	"none" => "Nenhum(a)",
	"question" => "questão",
	"Question" => "Questão",
	"test" => "teste",
	"Test" => "Teste",
	"submit" => "Salvar",
	"image" => "Imagem",
	"id" => "Código",
	"id_placeholder" => "Código gerado automaticamente",
	"actions" => "Ações",
	"description" => "Descrição",
	"mines_gender_male" => "Meus",
	"mines_gender_female" => "Minhas",
	"questions_category" => "Categoria de Questões",
	"questions_categories" => "Categorias de Questões",
	"tests_category" => "Categoria de Testes",
	"category" => [
		"confirm" => [
			"title" => "Remover categoria de :name",
			"message" => "Removendo a categoria, você também remove os itens que adicionou nela. Tem certeza que deseja remover a categoria "
		],
		"form" => [
			"title" => ":action categoria de :name",
			"description_placeholder" => "Coloque aqui a descrição da sua categoria"
		],
		"view" => [
			"title" => "Categorias de :name"
		],
	],
	"question_none" => "Nenhuma questão cadastrada",
	"question_category_none" => "Nenhuma categoria de questão cadastrada",
	"test_none" => "Nenhum teste cadastrado",
	"test_category_none" => "Nenhuma categoria de teste cadastrada",
	"welcome" => [
		"description" => "O sistema é parte constituinte do Trabalho de Conclusão de Curso (TCC) de Ciência da Computação do aluno Guilherme Fabrin Franco (RG 715656), orientado pelo professor Mestre Romário Lopes Alcântara ambos constituintes da Universidade Regional do Noroeste do Estado do Rio Grande do Sul (UNIJUI).</br>Por conseguinte, objetiva melhorar o uso do tempo de um professor na criação, execução e correção de provas.",
		"license" => "está licenciado com uma Licença <a rel='license' href='http://creativecommons.org/licenses/by-nc-nd/4.0/'>Creative Commons - Atribuição-NãoComercial-SemDerivações 4.0 Internacional",
		"message" => "No princípio, havia apenas o lápis e o papel, então foi dito: 'que haja o mimeógrafo' então o mimeógrafo se fez!</br>Esqueça as 172 horas editando um arquivo do Microsoft Word ou Libre Office.</br>Cadastre questões e gere provas em menos tempo!</br>",
		"thanks" => "Com gratidão pelo conhecimento,",
		"title" => "Bem vindo!!!"
	],
	"questions_in_tests" => [
		"form" => [
			"category_id" => "Categoria de questão",
			"questions" => "Questões",
		]
	],
	"questions" => [
		"name" => "Questões",
		"confirm" => [
			"title" => "Remover questão",
			"message" => "Tem certeza que deseja remover a questão ",
		],
		"form" => [
			"title" => "Editar questão",
			"category_id" => "Categoria de questão",
			"description_placeholder" => "Digite aqui o texto da questão",
			"descriptive" => "Descritiva",
			"image" => "Selecione a imagem da questão",
			"lines" => "Linhas",
			"lines_placeholder" => "Diga quantas linhas o aluno terá para responder a questão",
			"optative" => "Optativa",
			"option-correct[]" => "",
			"options" => "Opções",
			"right" => "Correta?",
			"selected_image" => "Imagem selecionada",
			"true_false" => "Verdadeira ou Falso",
			"type" => "Tipo",
			"type_placeholder" => "Selecione o tipo da questão",
		],
		"view" => [
			"title" => ":action questões :name",
			"questions" => ":action questões :name",
		]
	],
	"tests" => [
		"form" => [
			"title" => "Formulário de testes",
			"category_id" => "Categoria de teste",
			"description_placeholder" => "Digite o texto que identificará o seu teste",
		],
		"view" => [
			"title" => "Meus testes",
			"see" => "Ver testes",
			"tests" => ":action testes :name",
		],
		"confirm" => [
			"title" => "Confirmação para remoção de teste",
			"message" => "Tem certeza que deseja remover o teste ",
		]
	],
	"developed_by" => "Desenvolvido por",
	"license" => "Licença Creative Commons",
	"rights" => "Direitos Reservados",
	"title" => "SiPRO - Sistema de Provas",
	"logo_sipro" => "Logotipo SiPRO",
	"menu" => "Menu",
];
for ($i = 0; $i < 5; $i++) {
	$arrQuestionsLang["form"]["option-description[" . $i . "]"] = "";
	$arrQuestionsLang["form"]["option-image[" . $i . "]"] = "Selecione a imagem da opção";
	$arrQuestionsLang["form"]["option-description[" . $i . "]_placeholder"] = "Digite o texto da opção";
}
return $arrQuestionsLang;
