<nav class="navbar navbar-expand-lg navbar-dark bg-dark sipro-navbar-user">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#siproNavbarSupportedContent"
            aria-controls="siproNavbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="siproNavbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @php(App\Helpers\Boostrap\NavItem::build('question_categories', url('/questionCategory/'), 'fa fa-list'))
            @php(App\Helpers\Boostrap\NavItem::build('questions', url('/question/'), 'fa fa-question'))
            @php(App\Helpers\Boostrap\NavItem::build('test_categories', url('/testCategory/'), 'fa fa-list'))
            @php(App\Helpers\Boostrap\NavItem::build('tests', url('/test/'), 'fa fa-file-text'))
            @php(App\Helpers\Boostrap\NavItem::build('my_account', url('/user/'), 'fa fa-user'))
        </ul>
    </div>
</nav>