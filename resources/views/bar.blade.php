<nav class="navbar navbar-expand-lg navbar-dark bg-dark sipro-navbar-user">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siproNavbarSupportedContent"
			aria-controls="siproNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="siproNavbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			@php(BootstrapHelper::navItem('/questionCategory/', 'bar.question_categories', 'fa fa-list'))
			@php(BootstrapHelper::navItem('/question/', 'bar.questions', 'fa fa-question'))
			@php(BootstrapHelper::navItem('/testCategory/', 'bar.test_categories', 'fa fa-list'))
			@php(BootstrapHelper::navItem('/tests/', 'bar.tests', 'fa fa-file-text'))
			@php(BootstrapHelper::navItem('/user/', 'bar.my_account', 'fa fa-user'))
		</ul>
	</div>
</nav>