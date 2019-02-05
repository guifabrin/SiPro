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

    public function __construct(Request $request, Question $question = null)
    {
        $this->request = $request;
        $this->input = $request->all();
        if ($question) {
            $this->question = $question;
            $this->options = $question->options()->get();
        }
    }

    public static function store(Request $request, Question $question = null)
    {
        return (new QuestionStoreController($request, $question))->_store();
    }

    public function _store()
    {
        $this->validate($this->request);
        if (!$this->processQuestion()) return false;
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
            $this->request->validate($rules);
        }
    }

    private function processQuestion()
    {
        $uploadedFile = isset($this->input['image']) ? $this->input['image'] : null;
        $args = [
            "categorie_id" => $this->getQuestionCategoryId(),
            "user_id" => Auth::user()->id,
            "description" => $this->input['description'],
            "image_id" => $this->getImageId($uploadedFile),
            "type" => $this->input['type'],
            "lines" => $this->getLines(),
            "soft_delete" => false
        ];
        if ($this->question) {
            $this->question->update($args);
        } else {
            $this->question = Question::create($args);
        }
        return $this->question;
    }

    private function getQuestionCategoryId()
    {
        $questionCategoryId = $this->input['categorie_id'];
        processIfNull($questionCategoryId);
        $questionCategory = Auth::user()->questionCategories()->where('id', $questionCategoryId)->first();
        return isset($questionCategory) ? $questionCategory->id : null;
    }

    private function getImageId($image = null)
    {
        if ($image) {
            $imageObj = Image::firstOrCreate([
                "imageb64" => ImageController::convertBase64($image),
                "imageb64_thumb" => ImageController::makeThumb($image, 100)
            ]);
        } else {
            $imageObj = null;
        }
        if ($imageObj) {
            $imageId = $imageObj->id;
        } else {
            $imageId = isset($this->input['image_id']) ? $this->input['image_id'] : null;
        }
        return $imageId;
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
        if ($this->options->count() > 0) {
            $this->destroyOptions();
        }
        $optionsValues = $this->getOptionsValues();
        for ($i = 0; $i < 5; $i++) {
            $imageOption = isset($optionsValues['image']) && isset($optionsValues['image'][$i]) ? $optionsValues['image'][$i] : null;
            $imageOptionId = isset($imageOption) ? $this->getImageId($imageOption) : null;
            $optionCorrect = false;
            if (isset($optionsValues['correct'])) {
                for ($j = 0; $j < count($optionsValues['correct']); $j++) {
                    if ($optionsValues['correct'][$j] == $i) {
                        $optionCorrect = true;
                        break;
                    }
                }
            }
            Option::create([
                'question_id' => $this->question->id,
                'description' => $optionsValues['description'][$i],
                'image_id' => $imageOptionId,
                'correct' => $optionCorrect,
            ]);
        }
        $this->options = $this->question->options()->get();
        return $this->options;
    }

    private function destroyOptions()
    {
        foreach ($this->options as $option) {
            if ($option) {
                $option->forceDelete();
            };
        }
    }

    private function getOptionsValues()
    {
        $options = [];
        $keys = ["description", "image", "correct"];
        foreach ($keys as $key) {
            if (isset($this->input["option-" . $key])) {
                $options[$key] = $this->input["option-" . $key];
            }
        }
        return $options;
    }

    private function destroy()
    {
        $this->destroyOptions();
        if ($this->question) {
            $this->question->forceDelete();
        }
    }
}