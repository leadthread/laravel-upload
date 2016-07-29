<?php

namespace Zenapply\Upload;

use Illuminate\Http\UploadedFile;
use Storage;
use Exception;
use Zenapply\Upload\Models\File;

class Upload {
	public function __construct(){
		$this->config = config('upload');
		
	}

	public function create(UploadedFile $file){
		$disk        = $this->config['disk'];
		$filename    = $this->getRandomString(32);
		$extension   = $file->extension();
		$directory   = $this->getRandomDirectory();
		$contents    = file_get_contents($file);
		$mime        = mime_content_type($file->path());
		$fingerprint = md5_file($file->path());

		$path = "/{$directory}/{$filename}.{$extension}";

	    $result = $this->getDisk()->put($path, $contents);

	    if($result === false){
	    	throw new Exception("Could not save the file on the disk! Disk: ".$disk);
	    }

	    $model = new File([
	    	"filename" => $filename,
	    	"mime" => $mime,
			"path" => $path,
			"disk" => $disk,
			"extension" => $extension,
			"fingerprint" => $fingerprint,
	    ]);

	    return $model;
	}

	public function read($id){
		// Code go here
	}

	public function destroy($id){
		// Code go here
	}

	protected function getDisk(){
		return Storage::disk($this->config['disk']);
	}

	protected function getRandomString($len = 16){
		$alphanum = array_merge(range('a','z'),range('0','9'));
		$str = "";
		for($i = 0; $i < $len; $i++){
			$str.=$alphanum[array_rand($alphanum)];
		}
		return $str;
	}

	protected function getRandomDirectory(){
		$directory1 = $this->getRandomString(1);
		$directory2 = $this->getRandomString(1);
		return "{$directory1}/{$directory2}";
	}
}

