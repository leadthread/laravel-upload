<?php

namespace Zenapply\Upload;

use Illuminate\Http\UploadedFile;
use Storage;
use Exception;
use Zenapply\Upload\Models\File;

class Upload
{
    protected $config = [];
    
    public function __construct()
    {
        $this->config = config('upload');
    }

    /**
     * Takes an UploadedFile, stores it to the disk and records it in the database.
     * @param  UploadedFile $file The file to handle
     * @return File               The Eloquent Model for the file
     */
    public function create(UploadedFile $file)
    {
        $fingerprint = $this->getFingerprint($file);

        if ($this->config['hash']['enabled'] === true) {
            $duplicate = File::where('fingerprint', $fingerprint)->first();
            
            if ($duplicate) {
                return $duplicate;
            }
        }
    
        $disk        = $this->config['disk'];
        $filename    = $this->getRandomString(32);
        $extension   = $file->extension();
        $directory   = $this->getRandomDirectory();
        $contents    = file_get_contents($file);
        $mime        = mime_content_type($file->path());

        $path = "/{$directory}/{$filename}.{$extension}";

        $result = $this->getDiskInstance()->put($path, $contents);

        if ($result === false) {
            throw new Exception("Could not save the file on the disk! Disk: ".$disk);
        }

        $model = new File(
            [
            "filename" => $filename,
            "mime" => $mime,
            "path" => $path,
            "disk" => $disk,
            "extension" => $extension,
            "fingerprint" => $fingerprint,
            ]
        );

        $model->save();

        return $model;
    }

    /**
     * Returns the storage disk instance to use
     * @return Storage The Storage disk
     */
    protected function getDiskInstance()
    {
        return Storage::disk($this->config['disk']);
    }

    /**
     * Produces a random alphanumberic string
     * @param  integer $len The length that you want
     * @return string       A random alphanumberic string
     */
    protected function getRandomString($len = 16)
    {
        $alphanum = array_merge(range('a', 'z'), range('0', '9'));
        $str = "";
        for ($i = 0; $i < $len; $i++) {
            $str.=$alphanum[array_rand($alphanum)];
        }
        return $str;
    }

    /**
     * Returns two random directories
     * @return string A path with two directories: 'a/b', '1/g', '9/4', etc...
     */
    protected function getRandomDirectory()
    {
        $directory1 = $this->getRandomString(1);
        $directory2 = $this->getRandomString(1);
        return "{$directory1}/{$directory2}";
    }
    
    /**
     * Returns the hash value of a file
     * @param  UploadedFile $file The file
     * @return string             The hash
     */
    protected function getFingerprint(UploadedFile $file)
    {
        if ($this->config['hash']['enabled'] !== true) {
            return null;
        }

        $algo = $this->config['hash']['algo'] ?: 'md5';

        if (!in_array($algo, hash_algos())) {
            throw new Exception("The hashing algorithm '{$algo}' is not supported on this system", 1);
        }

        return hash_file($algo, $file->path());
    }
}
