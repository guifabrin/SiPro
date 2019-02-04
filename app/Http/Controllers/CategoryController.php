<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected function type(){
        throw new \Exception(_v('need_implement_type'));
    }

    protected function typeBasicClass(){
        throw new \Exception(_v('need_implement_typeBasicClass'));
    }

    public function create()
    {
        $categories = $this->_getUserCategories();
        $class = $this->typeBasicClass();
        return view('categories.form', [
            'type' => $this->type(),
            'category' => new $class(),
            'categories' => $categories
        ]);
    }

    protected function _getUserCategories()
    {
        throw new \Exception(_v('need_implement__getUserCategories'));
    }

    public function edit($category)
    {
        $categories = $this->_getUserCategories();
        return view('categories.form', [
            'type' => $this->type(),
            'category' => $category,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        Alert::clear();
        $this->validate($request);
        $categoryObj = $this->save($request->input());
        $this->message('created', $categoryObj);
        return redirect()->to($this->type().'Category');
    }

    public function validate(Request $request, array $rules = [], array $messages = [], array $customAttributes = [])
    {
        $request->validate([
            'description' => 'required',
        ]);
    }

    private function message(string $key, $object = null)
    {
        $status = ($object) ? "success" : "danger";
        $message = ($object) ? _v($key) : _v("not_" . $key);
        Alert::build($message, $status);
    }

    private function save(array $input = [], $category = null)
    {
        $input['user_id'] = Auth::user()->id;
        processIfNull($input['father_id']);
        $input['soft_delete'] = isset($input['soft_delete']) ? $input['soft_delete'] : false;
        if (empty($category)) {
            return $this->typeBasicClass()::create($input);
        } else {
            $category->update($input);
            return $category;
        }
    }

    public function index()
    {
        $categories = $this->_getUserCategories();
        if ($categories->count() == 0) {
            Alert::build(_v('none_message'), 'info');
        }
        return view('categories.view', [
            'type' => $this->type(),
            'categories' => $categories
        ]);
    }

    public function show($category)
    {
        return view('categories.confirm', [
            'type' => $this->type(),
            'category' => $category,
        ]);
    }

    public function destroy($category)
    {
        $categoryObj = $this->save(['soft_delete' => true], $category);
        $this->message('removed', $categoryObj);
        return redirect()->to($this->type().'Category');
    }

    public function update(Request $request, $category)
    {
        Alert::clear();
        $this->validate($request);
        $categoryObj = $this->save($request->input(), $category);
        $this->message('updated', $categoryObj);
        return redirect()->to($this->type().'Category');
    }
}
