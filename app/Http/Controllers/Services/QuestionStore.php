<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\QuestionController;
use App\Image;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class QuestionStore
{

    private $request;
    private $input;
    private $question;
    private $options;

    /**
     * QuestionStore constructor.
     * @param Request $request
     * @param Question|null $question
     */
    public function __construct(Request $request, Question $question = null)
    {
        $this->request = $request;
        $this->input = $request->all();
        if ($question) {
            $this->question = $question;
            $this->options = $question->options()->get();
        }
    }

    /**
     * @param Request $request
     * @param Question|null $question
     * @return bool
     */
    public static function run(Request $request, Question $question = null)
    {
        return (new QuestionStore($request, $question))->store();
    }

    /**
     * @return bool
     */
    public function store()
    {
        $this->validate();
        return $this->processQuestion() && ($this->input["type"] == QuestionController::DESCRIPTIVE || (
            $this->input["type"] != QuestionController::DESCRIPTIVE && $this->processOptions())
        );
    }

    private function processOptions(){
        $this->destroyOptions();
        foreach ($this->createOptions() as $option) {
            if (!$option) {
                $this->destroy();
                return false;
            }
        }
        return true;
    }

    public function validate()
    {
        $array = [
            "description" => "required",
            "image" => "image|mimes:jpeg,png,jpg,gif,svg|max:1024",
        ];
        if ($this->input["type"] == QuestionController::DESCRIPTIVE) {
            $array["lines"] = "required";
        }
        $this->request->validate($array);
        $this->validateOptionsNotDescriptive();
    }

    private function validateOptionsNotDescriptive()
    {
        if ($this->input["type"] != QuestionController::DESCRIPTIVE) {
            $rules = [];
            for ($i = 0; $i < 5; $i++) {
                $rules["option-description." . $i] = "required";
            }
            $rules["option-correct"] = "required";
            $this->request->validate($rules);
        }
    }

    private function questionArgs(){
        return [
            "category_id" => $this->getQuestionCategoryId(),
            "user_id" => Auth::user()->id,
            "description" => $this->input["description"],
            "image_id" => $this->getImageId($this->input["image"], $this->input["hidden-image"]),
            "type" => $this->input["type"],
            "lines" => $this->getLines(),
            "soft_delete" => false
        ];
    }

    private function processQuestion()
    {
        $args = $this->questionArgs();
        if ($this->question) {
            $this->question->update($args);
        } else {
            $this->question = Question::create($args);
        }
        return $this->question;
    }

    private function getQuestionCategoryId()
    {
        $questionCategoryId = $this->input["category_id"];
        process_if_null($questionCategoryId);
        $questionCategory = Auth::user()->questionCategories()->where("id", $questionCategoryId)->first();
        return isset($questionCategory) ? $questionCategory->id : null;
    }

    private function processUploadedImage(UploadedFile $uploadedImage = null){
        if (!isset($uploadedImage)){
            return null;
        }
        return Image::firstOrCreate([
            "imageb64" => ImageMaker::convertUploadedFile2Base64($uploadedImage),
            "imageb64_thumb" => ImageMaker::makeThumb($uploadedImage, 100)
        ]);
    }

    private function getImageFromHidden($hiddenValue = null){
        if (!isset($hiddenValue)){
            return null;
        }
        return Image::where('imageb64_thumb', $hiddenValue)->first();
    }

    private function getImageId(UploadedFile $uploadedImage = null, $hiddenValue = null)
    {
        if ($imageObj = ($this->processUploadedImage($uploadedImage) ?: $this->getImageFromHidden($hiddenValue))) {
            return $imageObj->id;
        }
       return null;
    }

    private function getLines()
    {
        switch ($this->input["type"]) {
            case 1:
            case 2:
                return -1;
                break;
        }
        return $this->input["lines"];
    }

    private function tryGetValue($array, $key) {
        return (array_key_exists($key, $array)) ? $array[$key] : NULL;
    }

    private function createOption($values, $index){
        Option::create([
            "question_id" => $this->question->id,
            "description" => $this->tryGetValue($values["description"], $index),
            "image_id" => $this->getImageId(
                $this->tryGetValue($values["image"], $index),
                $this->tryGetValue($values["hidden"], $index)
            ),
            "correct" => in_array($index, $values["correct"]),
        ]);
    }

    private function createOptions()
    {
        $values = $this->getOptionsValues();
        for ($index = 0; $index < 5; $index++) {
            $this->createOption($values, $index);
        }
        $this->options = $this->question->options()->get();
        return $this->options;
    }

    private function destroyOptions()
    {
        if ($this->options && $this->options->count() > 0) {
            foreach ($this->options as $option) {
                if ($option) $option->forceDelete();
            }
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
        $options["hidden"] = $this->input["hidden-option-image"];
        return $options;
    }

    private function destroy()
    {
        $this->destroyOptions();
        if ($this->question)
            $this->question->forceDelete();
    }
}