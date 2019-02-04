<nav class="navbar navbar-expand-lg navbar-dark bg-dark sipro-navbar-user">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siproNavbarSupportedContent"
			aria-controls="siproNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="siproNavbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			@php(BootstrapHelper::navItem('/questions/categories/', 'bar.question_categories', 'fa fa-list'))
			@php(BootstrapHelper::navItem('/questions/', 'bar.questions', 'fa fa-question'))
			@php(BootstrapHelper::navItem('/tests/categories/', 'bar.test_categories', 'fa fa-list'))
			@php(BootstrapHelper::navItem('/tests/', 'bar.tests', 'fa fa-file-text'))
			@php(BootstrapHelper::navItem('/user/', 'bar.my_account', 'fa fa-user'))
		</ul>
	</div>
</nav>