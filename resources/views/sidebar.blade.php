<div class="sidebar-header">
    <h3>{{__('app.menu')}}</h3>
</div>

<ul class="list-unstyled navbar-nav mr-auto">
    @php(App\Helpers\Boostrap\NavItem::build('home', url('/'), 'fa fa-home'))
    @php(App\Helpers\Boostrap\NavItem::build('teacher', '#teacher-sub-menu', 'fas fa-chalkboard-teacher', [
        ['question_categories', url('/questionCategory/'), 'fas fa-stream'],
        ['questions', url('/question/'), 'fas fa-question'],
        ['test_categories', url('/testCategory/'), 'fas fa-stream'],
        ['tests', url('/test/'), 'fas fa-tasks'],
    ]))
    @php(App\Helpers\Boostrap\NavItem::build('student', '#student-sub-menu', 'fas fa-user-graduate'))
    @php(App\Helpers\Boostrap\NavItem::build('my_account', url('/user/'), 'fa fa-user'))
</ul>