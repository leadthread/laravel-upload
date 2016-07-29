<?php

namespace Zenapply\Upload;

use Illuminate\Http\UploadedFile;
use Storage;
use Exception;

class Upload {
	public function __construct(){
		$this->config = config('upload');
		
	}

	public function create(UploadedFile $file){
		$filename   = $this->getRandomString(32);
		$extension  = $file->extension();
		$directory  = $this->getRandomDirectory();

		$path = "/{$directory}/{$filename}.{$extension}";

	    $result = $this->getDisk()->put($path, file_get_contents($file));

	    if($result === false){
	    	throw new Exception("Could not save the file on the disk! Disk: ".$this->config['disk']);
	    }
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

