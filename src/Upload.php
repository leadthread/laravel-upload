<?php

namespace Zenapply\Upload;

use Illuminate\Http\UploadedFile;
use Storage;

class Upload {
	public function __construct(){
		$this->config = config('upload');
		$this->disk = Storage::disk($this->config['disk']);
	}

	public function create(UploadedFile $file){
		$alphanum   = array_merge(range('a','z'),range('0','9'));
		$directory1 = array_rand($alphanum);
		$directory2 = array_rand($alphanum);
		$filename   = str_repeat(array_rand($alphanum), 32);
		$extension  = $file->extension();

		$path = "/{$directory1}/{$directory2}/{$filename}.{$extension}";

	    $this->disk->put($path, file_get_contents($file));
	}

	public function read($id){
		// Code go here
	}

	public function destroy($id){
		// Code go here
	}
}

