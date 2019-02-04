<?php

namespace App\Http\Controllers;

use App\Image;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionStoreController extends Controller
{

    private $request;
    private $input;
    private $question;
    private $options;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->input = $request->all();
        $this->options = [];
    }

    public static function store($request){
        return (new QuestionStoreController($request))->_store();
    }

    public function _store()
    {
        $this->validate($this->request);
        if (!$this->createQuestion()) return false;
        if ($this->input['type'] != QuestionController::DESCRIPTIVE) {
            foreach ($this->createOptions() as $option) {
                if (!$option) {
                    $this->destroy();
                    return false;
                }
            }
        }
        return true;
    }

    public function validate(Request $_request, array $_rules = [], array $_messages = [],
                             array $_customAttributes = [])
    {
        $this->request->validate([
            'description' => 'required',
            'lines' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $this->validateOptionsNotDescriptive();
    }

    private function validateOptionsNotDescriptive()
    {
        if ($this->input['type'] != QuestionController::DESCRIPTIVE) {
            $rules = [];
            for ($i = 0; $i < 5; $i++) {
                $rules['option-description.' . $i] = 'required';
            }
            $rules['option-correct'] = 'required';
            $this->validate($this->request, $rules);
        }
    }

    private function createQuestion()
    {
        try {
            $this->question = Question::create([
                "categorie_id" => $this->getQuestionCategoryId(),
                "user_id" => Auth::user()->id,
                "description" => $this->input['description'],
                "image_id" => $this->getImageId($this->input['image']),
                "type" => $this->input['type'],
                "lines" => $this->getLines(),
                "soft_delete" => false
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
        return $this->question;
    }

    private function getQuestionCategoryId()
    {
        $questionCategoryId = $this->input['categorie_id'];
        processIfNull($questionCategoryId);
        $questionCategory =  Auth::user()->questionCategories()->where('id', $questionCategoryId)->first();
        return isset($questionCategory) ? $questionCategory->id : null;
    }

    private function getImageId($image = null)
    {
        if (!isset($image)) return null;
        $imageObj = Image::firstOrCreate([
            "imageb64" => ImageController::convertBase64($image),
            "imageb64_thumb" => ImageController::makeThumb($image, 100)
        ]);
        return ($imageObj) ? $imageObj->id : null;
    }

    private function getLines()
    {
        switch ($this->input['type']) {
            case 1:
            case 2:
                return -1;
                break;
        }
        return $this->input['lines'];
    }

    private function createOptions()
    {
        $optionsValues = $this->getOptionsValues();
        for ($i = 0; $i < 5; $i++) {
            try {
                $imageOption = $optionsValues['image'][$i];
                $imageOptionId = isset($imageOption) ? $this->getImageId($imageOption) : null;
                $optionCorrect = false;
                for ($j = 0; $j < count($optionsValues['correct']); $j++) {
                    if ($optionsValues['correct'][$j] == $i) {
                        $optionCorrect = true;
                        break;
                    }
                }
                $this->options[] = Option::create([
                    'question_id' => $this->question->id,
                    'description' => $optionsValues['description'][$i],
                    'image_id' => $imageOptionId,
                    'correct' => $optionCorrect,
                ]);
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
        return $this->options;
    }

    private function getOptionsValues()
    {
        $options = [];
        $keys = ["description", "image", "correct"];
        foreach ($keys as $key) {
            $value = $this->input["option-" . $key];
            if (isset($value)) {
                $options["description"] = $value;
            }
        }
        return $options;
    }

    private function destroy()
    {
        foreach ($this->options as $option) {
            if ($option) {
                $option->delete();
            };
        }
        if ($this->question) {
            $this->question->delete();
        }
    }
}