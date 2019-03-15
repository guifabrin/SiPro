<div class="sidebar-header">
    <h3>{{__('app.menu')}}</h3>
</div>

<ul class="list-unstyled navbar-nav mr-auto">
    @php(App\Helpers\Boostrap\NavItem::build('home', url('/'), 'fa fa-home'))
    @php(App\Helpers\Boostrap\NavItem::build('teacher', '#teacher-sub-menu', 'fas fa-chalkboard-teacher', [
        ['question_categories', url('/questionCategory/'), 'fa fa-list'],
        ['questions', url('/question/'), 'fa fa-question'],
        ['test_categories', url('/testCategory/'), 'fa fa-list'],
        ['tests', url('/test/'), 'fa fa-file-text'],
    ]))
    @php(App\Helpers\Boostrap\NavItem::build('student', '#student-sub-menu', 'fas fa-chalkboard-teacher'))
    @php(App\Helpers\Boostrap\NavItem::build('my_account', url('/user/'), 'fa fa-user'))
</ul>