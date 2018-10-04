<?php

namespace App\Http\Controllers\Tool;

use Image;
use File;

class ImageGetTool  {
    public function resize($filename, $width, $height) {
		//linux
        // if (!is_file(DIR_IMAGE . $filename) || substr(str_replace('\\', '/', realpath(DIR_IMAGE . $filename)), 0, strlen(DIR_IMAGE)) != DIR_IMAGE) {
            
		// 	return;
		// }
		//windows
		if (!is_file(DIR_IMAGE . $filename)) {
            
			return;
		}
        
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
        
		$image_old = $filename;
        $image_new = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . (int)$width . 'x' . (int)$height . '.' . $extension;
        if (!is_file(DIR_IMAGE . $image_new) || (filectime(DIR_IMAGE . $image_old) > filectime(DIR_IMAGE . $image_new))) {
			list($width_orig, $height_orig, $image_type) = getimagesize(DIR_IMAGE . $image_old);
				 
			if (!in_array($image_type, array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF))) { 
				return DIR_IMAGE . $image_old;
			}
						
			$path = '';

			$directories = explode('/', dirname($image_new));
                        
            
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				if (!is_dir(DIR_IMAGE . $path)) {
                    File::makeDirectory(DIR_IMAGE . $path, 0777,TRUE);
				}
			}
            
			if ($width_orig != $width || $height_orig != $height) {
                Image::make(DIR_IMAGE . $image_old)->fit($width, $height)->save(DIR_IMAGE . $image_new);
			} else {
				copy(DIR_IMAGE . $image_old, DIR_IMAGE . $image_new);
            }
        }
        $image_new = str_replace(' ', '%20', $image_new);  // fix bug when attach image on email (gmail.com). it is automatic changing space " " to +
		
            
        return IMAGES . $image_new;
    }
}