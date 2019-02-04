<?php

namespace App\Http\Controllers;

class ImageController extends Controller {

	public static function convertBase64($uploadedFile) {
	    $data = base64_encode(file_get_contents($uploadedFile));
        $type = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
		return $base64 = 'data:image/' . $type . ';base64,' . $data;
	}

	public static function makeThumb($uploadedFile, $desired_width) {
        $type = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG') {
            $source_image = imagecreatefromjpeg($uploadedFile);
        } elseif ($type == 'png' || $type == "PNG"){
            $source_image = imagecreatefrompng($uploadedFile);
        }else{
            return null;
        }
		$width = imagesx($source_image);
		$height = imagesy($source_image);

		/* find the "desired height" of this thumbnail, relative to the desired width  */
		$desired_height = floor($height * ($desired_width / $width));

		/* create a new, "virtual" image */
		$virtual_image = imagecreatetruecolor($desired_width, $desired_height);

		/* copy source image at a resized size */
		imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        while (true) {
            $dest = uniqid('sipro', true) . '.'.$type;
            if (!file_exists(sys_get_temp_dir() . $dest)) break;
        }if ($type == 'jpg' || $type == 'jpeg' || $type == 'JPG' || $type == 'JPEG') {
            imagejpeg($virtual_image, $dest);
        } elseif ($type == 'png' || $type == "PNG"){
            imagepng($virtual_image, $dest);
        }
		/* create the physical thumbnail image to its destination */
        return self::convertBase64($uploadedFile);
	}

}
