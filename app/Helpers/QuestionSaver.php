<?php

namespace App\Http\Helpers;

use App\Image;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class QuestionSaver
{

    const DESCRIPTIVE = 0;
    const OPTIONS_KEYS = ["description", "image", "correct"];

    private $input;
    private $options;
    private $request;
    private $question;

    public static function run(Request $request, Question $question = null)
    {
        return (new self($request, $question))->save();
    }

    public function __construct(Request $request, Question $question = null)
    {
        $this->request = $request;
        $this->input = $request->all();
        $this->descriptive = $this->input["type"] == self::DESCRIPTIVE;
        if (!$question) return;
        $this->question = $question ? $question : new Question();
        $this->options = $question->options()->get();
    }

    private function ruleOptions()
    {
        $rules = [];
        for ($i = 0; $i < 5; $i++) {
            $rules["option-description." . $i] = "required";
        }
        $rules["option-correct"] = "required";
        return $rules;
    }

    public function validate()
    {
        $array = [
            "description" => "required",
            "image" => "image|mimes:jpeg,png,jpg,gif,svg|max:1024",
        ];
        if ($this->descriptive)
            $array["lines"] = "required";
        else
            $array = array_merge($array, $this->ruleOptions());
        $this->request->validate($array);
    }

    private function getLines()
    {
        if ($this->descriptive)
            return $this->input["lines"];
        return -1;
    }

    private function getQuestionCategoryId()
    {
        if (is_input_null($this->input["category_id"])) return null;
        $questionCategory = Auth::user()->questionCategories()->find($this->input["category_id"]);
        return $questionCategory ? $questionCategory->id : null;
    }

    private function getUploadedImage(UploadedFile $uploadedImage)
    {
        return Image::firstOrCreate([
            "imageb64" => ImageMaker::convertUploadedFile2Base64($uploadedImage),
            "imageb64_thumb" => ImageMaker::makeThumb($uploadedImage, 100)
        ]);
    }

    private function getImageFromHidden($hiddenValue = null)
    {
        return Image::where('imageb64_thumb', $hiddenValue)->first();
    }

    private function getImageId(UploadedFile $uploadedImage = null, $hiddenValue = null)
    {
        if ($uploadedImage) return $this->getUploadedImage($uploadedImage)->id;
        if ($hiddenValue) return $this->getImageFromHidden($hiddenValue)->id;
        return null;
    }

    private function parametersQuestion()
    {
        return [
            "soft_delete" => false,
            "lines" => $this->getLines(),
            "user_id" => Auth::user()->id,
            "type" => $this->input["type"],
            "description" => $this->input["description"],
            "category_id" => $this->getQuestionCategoryId(),
            "image_id" => $this->getImageId(
                get_item_from_array($this->input, "image"),
                get_item_from_array($this->input, "hidden-image")
            )
        ];
    }

    private function saveQuestion()
    {
        $this->question->fill($this->parametersQuestion());
        $this->question->save();
        return $this->question;
    }

    private function destroyOptions()
    {
        if (empty($this->options)) return;
        foreach ($this->options as $option) {
            if ($option) $option->forceDelete();
        }
    }

    private function parametersOptions()
    {
        $options = [];
        foreach (self::OPTIONS_KEYS as $key) {
            if (empty($this->input["option-" . $key])) continue;
            $options[$key] = $this->input["option-" . $key];
        }
        $options["hidden"] = $this->input["hidden-option-image"];
        return $options;
    }

    private function createOption($parameters, $index)
    {
        Option::create([
            "question_id" => $this->question->id,
            "description" => get_item_from_array($parameters["description"], $index),
            "image_id" => $this->getImageId(
                get_item_from_array($parameters["image"], $index),
                get_item_from_array($parameters["hidden"], $index)
            ),
            "correct" => in_array($index, $parameters["correct"]),
        ]);
    }

    private function createOptions()
    {
        $parameters = $this->parametersOptions();
        for ($index = 0; $index < 5; $index++) {
            $this->createOption($parameters, $index);
        }
        $this->options = $this->question->options()->get();
        return $this->options;
    }

    private function destroy()
    {
        $this->destroyOptions();
        if ($this->question)
            $this->question->forceDelete();
    }

    private function saveOptions()
    {
        $this->destroyOptions();
        foreach ($this->createOptions() as $option) {
            if ($option) continue;
            $this->destroy();
            return false;
        }
        return true;
    }

    public function save()
    {
        $this->validate();
        $question = $this->saveQuestion();
        $options = $this->descriptive ? true : $this->saveOptions();
        return $question && $options;
    }
}
