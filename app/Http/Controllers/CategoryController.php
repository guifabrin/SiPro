<?php

namespace App\Http\Controllers;

use App\Helpers\Boostrap\Alert;
use App\TestCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    protected function type(){
        throw new \Exception(_v('need_implement_type'));
    }

    protected function typeBasicObj(){
        throw new \Exception(_v('need_implement_typeBasicObj'));
    }

    public function create()
    {
        $categories = $this->getUserCategories();
        return view('categories.form', [
            'type' => $this->type(),
            'category' => new TestCategorie(),
            'categories' => $categories
        ]);
    }

    protected function getUserCategories()
    {
        throw new \Exception(_v('need_implement_getUserCategories'));
    }

    public function edit($category)
    {
        $categories = $this->getUserCategories();
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
        return redirect()->to('testCategory');
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
            return TestCategorie::create($input);
        } else {
            $category->update($input);
            return $category;
        }
    }

    public function index()
    {
        $categories = $this->getUserCategories();
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
        return redirect()->to('testCategory');
    }

    public function update(Request $request, $category)
    {
        Alert::clear();
        $this->validate($request);
        $categoryObj = $this->save($request->input(), $category);
        $this->message('updated', $categoryObj);
        return redirect()->to('testCategory');
    }
}
