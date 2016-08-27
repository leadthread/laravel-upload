<?php

namespace Zenapply\Upload\Tests;

use Zenapply\Upload\Upload;
use Upload as UploadFacade;
use Illuminate\Http\UploadedFile;
use Exception;

class UploadTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->migrate();
    }

    public function tearDown()
    {
        $this->migrateReset();
        parent::tearDown();
    }

    public function testUploadCreate()
    {
        $obj = new Upload();
        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model = $obj->create($file);
        $this->assertEquals(file_exists(__DIR__.'/tmp'.$model->path), true);
        $this->assertNotEquals($model->fingerprint, null);
    }

    public function testUploadCreateReturnsADuplicate()
    {
        $obj = new Upload();
        
        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model1 = $obj->create($file);

        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model2 = $obj->create($file);

        $this->assertEquals($model2->id, $model1->id);
    }

    public function testUploadCreateDoesNotReturnADuplicate()
    {
        config()->set('upload.hash.enabled', false);
        $obj = new Upload();
        
        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model1 = $obj->create($file);

        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model2 = $obj->create($file);

        $this->assertNotEquals($model2->id, $model1->id);
    }

    public function testTurningHashingOff()
    {
        config()->set('upload.hash.enabled', false);
        $obj = new Upload();
        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model = $obj->create($file);
        $this->assertEquals($model->fingerprint, null);
    }

    public function testUsingUnsupportedAlgorithm()
    {
        $this->setExpectedException(Exception::class);
        config()->set('upload.hash.algo', 'notsupportedalgo');
        $obj = new Upload();
        $file = new UploadedFile(__DIR__."/files/testfile.txt", "testfile.txt");
        $model = $obj->create($file);
        $this->assertEquals($model->fingerprint, null);
    }
    
    public function testItCreatesAnInstanceOfUpload()
    {
        $obj = new Upload();
        $this->assertInstanceOf(Upload::class, $obj);
    }

    public function testItGeneratesRandomDirectory()
    {
        $obj = new Upload();
        $result = $this->invokeMethod($obj, 'getRandomDirectory', []);
        $this->assertEquals(strlen($result), 3);
        $this->assertContains("/", $result);
    }

    public function testItGeneratesRandomString()
    {

        $obj = new Upload();
        $lengths = range(1, 32);

        foreach ($lengths as $l) {
            $result = $this->invokeMethod($obj, 'getRandomString', [$l]);
            $this->assertEquals($l, strlen($result));
        }

        $results = [];
        foreach (range(0, 100) as $l) {
            $results[] = $this->invokeMethod($obj, 'getRandomString', [32]);
        }

        $uniqueResults = array_unique($results);

        $this->assertEquals(count($uniqueResults), count($results));
    }
}
