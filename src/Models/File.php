<?php

namespace Zenapply\Upload\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table;
    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        if (empty($this->table)) {
            $this->table = config('upload.table');
        }
        parent::__construct($attributes);
    }

    // [
    //  'mime'
    //  'path'
    //  'disk'
    //  'filename'
    //  'extension'
    //  'fingerprint'
    // ]
}
