<?php

namespace Zenapply\Upload\Tests;

use Zenapply\Upload\Upload;
use Upload as UploadFacade;

class UploadTest extends TestCase
{
    public function testItCreatesAnInstanceOfUpload(){
        $obj = new Upload();
        $this->assertInstanceOf(Upload::class,$obj);
    }
}
