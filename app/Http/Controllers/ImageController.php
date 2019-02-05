<?php

namespace App\Http\Controllers;

class ImageController extends Controller
{

    private $uploadedFile;
    private $extension;

    public function __construct($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public static function makeThumb($uploadedFile, $maxWidth)
    {
        return (new self($uploadedFile))->_makeThumb($maxWidth);
    }

    public function _makeThumb($maxWidth)
    {
        $source = $this->getSource();
        if (!$source) return null;
        $virtualImage = $this->getVirtualImage($source, $maxWidth);
        $destination = $this->saveVirtualImage($virtualImage);
        if (!$destination) return null;
        return $this->convertBase64($destination);
    }

    private function getSource()
    {
        if ($this->isJPG()) {
            return imagecreatefromjpeg($this->uploadedFile);
        } elseif ($this->isPNG()) {
            return imagecreatefrompng($this->uploadedFile);
        } else {
            return null;
        }
    }

    private function isJPG()
    {
        return in_array($this->getExtension(), ['jpg', 'jpeg', 'JPG', 'JPEG']);
    }

    private function getExtension()
    {
        if (!$this->extension) {
            $this->extension = pathinfo($this->uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        }
        return $this->extension;
    }

    private function isPNG()
    {
        return in_array($this->getExtension(), ['png', 'PNG']);
    }

    private function getVirtualImage($source, $maxWidth)
    {
        $width = imagesx($source);
        $height = imagesy($source);
        $maxHeight = floor($height * ($maxWidth / $width));
        $virtualImage = imagecreatetruecolor($maxWidth, $maxHeight);
        imagecopyresampled($virtualImage, $source, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);
        return $virtualImage;
    }

    private function saveVirtualImage($virtualImage)
    {
        $destination = $this->getDestination();
        if ($this->isJPG() && imagejpeg($virtualImage, $destination) ||
            $this->isPNG() && imagepng($virtualImage, $destination)) {
            return $destination;
        }
        return false;
    }

    private function getDestination()
    {
        $destination = null;
        while (true) {
            $destination = sys_get_temp_dir() . "/" . uniqid() . '.' . $this->getExtension();
            if (!file_exists($destination)) break;
        }
        return $destination;
    }

    public function convertBase64($destination)
    {
        $data = base64_encode(file_get_contents($destination));
        return $base64 = 'data:image/' . $this->getExtension() . ';base64,' . $data;
    }

    public static function convertUploadedFile2Base64($uploadedFile)
    {
        $data = base64_encode(file_get_contents($uploadedFile));
        $type = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        return $base64 = 'data:image/' . $type . ';base64,' . $data;
    }

}
