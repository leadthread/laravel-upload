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

    public function testItGeneratesRandomDirectory(){
    	$obj = new Upload();
    	$result = $this->invokeMethod($obj, 'getRandomDirectory', []);
    	$this->assertEquals(strlen($result),3);
    	$this->assertContains("/",$result);
    }

    public function testItGeneratesRandomString(){

    	$obj = new Upload();
    	$lengths = range(1,32);

    	foreach ($lengths as $l) {
    		$result = $this->invokeMethod($obj, 'getRandomString', [$l]);
    		$this->assertEquals($l,strlen($result));
    	}

    	$results = [];
    	foreach (range(0,100) as $l) {
    		$results[] = $this->invokeMethod($obj, 'getRandomString', [32]);
    	}

    	$uniqueResults = array_unique($results);

    	$this->assertEquals(count($uniqueResults),count($results));
    }
}
