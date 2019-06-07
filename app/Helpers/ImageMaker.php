<?php

namespace App\Http\Helpers;

use Illuminate\Http\UploadedFile;

class ImageMaker {
    private $uploadedFile;
    private $extension;

    /**
     * ImageMaker constructor.
     * @param UploadedFile $uploadedFile
     */
    public function __construct(UploadedFile $uploadedFile) {
        $this->uploadedFile = $uploadedFile;
    }

    /**
     * @param $uploadedFile
     * @param $maxWidth
     * @return string|false
     */
    public static function makeThumb($uploadedFile, $maxWidth) {
        return (new self($uploadedFile))->thumb($maxWidth);
    }

    /**
     * @param $maxWidth
     * @return string|false
     */
    public function thumb($maxWidth) {
        $source = $this->getSource();
        if (!$source) return false;
        $virtualImage = $this->getVirtualImage($source, $maxWidth);
        $destination = $this->saveVirtualImage($virtualImage);
        if (!$destination) return false;
        return $this->convertBase64($destination);
    }

    /**
     * @return resource|false
     */
    private function getSource() {
        if ($this->isJPG()) {
            return imagecreatefromjpeg($this->uploadedFile);
        } elseif ($this->isPNG()) {
            return imagecreatefrompng($this->uploadedFile);
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    private function isJPG() {
        return in_array($this->getExtension(), ["jpg", "jpeg", "JPG", "JPEG"]);
    }

    /**
     * @return mixed
     */
    private function getExtension() {
        if (!$this->extension) {
            $this->extension = pathinfo($this->uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        }
        return $this->extension;
    }

    /**
     * @return bool
     */
    private function isPNG() {
        return in_array($this->getExtension(), ["png", "PNG"]);
    }

    /**
     * @param $source
     * @param $maxWidth
     * @return resource|false
     */
    private function getVirtualImage($source, $maxWidth) {
        $width = imagesx($source);
        $height = imagesy($source);
        $maxHeight = intval(floor($height * ($maxWidth / $width)));
        $virtualImage = imagecreatetruecolor($maxWidth, $maxHeight);
        imagecopyresampled($virtualImage, $source, 0.0, 0.0, 0.0, 0.0, $maxWidth, $maxHeight, $width, $height);
        return $virtualImage;
    }

    /**
     * @param $virtualImage
     * @return bool|string|null
     */
    private function saveVirtualImage($virtualImage) {
        $destination = $this->getDestination();
        if (
            ($this->isJPG() && imagejpeg($virtualImage, $destination)) ||
            ($this->isPNG() && imagepng($virtualImage, $destination))
            ) {
            return $destination;
        }
        return false;
    }

    /**
     * @return string|false
     */
    private function getDestination() {
        $destination = false;
        while (true) {
            $destination = sys_get_temp_dir() . "/" . uniqid() . "." . $this->getExtension();
            if (!file_exists($destination)) break;
        }
        return $destination;
    }

    /**
     * @param $destination
     * @return string
     */
    public function convertBase64($destination) {
        $data = base64_encode(file_get_contents($destination));
        return "data:image/" . $this->getExtension() . ";base64," . $data;
    }

    /**
     * @param $uploadedFile
     * @return string
     */
    public static function convertUploadedFile2Base64($uploadedFile) {
        $data = base64_encode(file_get_contents($uploadedFile));
        $type = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        return "data:image/" . $type . ";base64," . $data;
    }

}
