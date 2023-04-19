<?php

namespace Tests\ImageMimeTypeSniffer;

use \ImageMimeTypeSniffer\ImageMimeTypeSniffer;
use \PHPUnit\Framework\TestCase;
use org\bovigo\vfs\vfsStream;

class ImageMimeTypeSnifferTest extends TestCase
{

    private function mimeSniff($fileName)
    {
        return ImageMimeTypeSniffer::detect(__DIR__ . '/images/' . $fileName);
    }


    public function testBMP()
    {
        $this->assertEquals('image/bmp', $this->mimeSniff('bmp-test.bmp'));
    }

    public function testGIF()
    {
        $this->assertEquals('image/gif', $this->mimeSniff('gif-test.gif'));
    }

    public function testHeic()
    {
        $this->assertEquals('image/heic', $this->mimeSniff('heic-test.heic'));
    }

    /*public function testHeif()
    {
        $this->assertEquals('image/heif', $this->mimeSniff('heif-test.heif'));
        //$this->assertEquals('image/heif', $this->mimeSniff('sample1.heif'));
    }*/

    public function testPNG()
    {
        $this->assertEquals('image/png', $this->mimeSniff('png-test.png'));
        $this->assertEquals('image/png', $this->mimeSniff('png-very-small.png'));
        $this->assertEquals('image/png', $this->mimeSniff('png-with-jpeg-extension.jpg'));
        $this->assertEquals('image/png', $this->mimeSniff('png-without-extension'));
        $this->assertEquals('image/png', $this->mimeSniff('png-not-true-color.png'));
    }

    public function testJpeg()
    {
        $this->assertEquals('image/jpeg', $this->mimeSniff('jpg-test.jpg'));

        $this->assertEquals('image/jpeg', $this->mimeSniff('.jpg-beginning-with-dot.jpg'));

        // Adding a file to the repo which ends with a dot makes checkout fail on Windows.
        // See here: https://github.com/rosell-dk/image-mime-type-sniffer/runs/5832821464?check_suite_focus=true
        // So, we cannot run this test:
        // $this->assertEquals('image/jpeg', $this->mimeSniff('jpg-ending-with-dot.jpg.'));

        $this->assertEquals('image/jpeg', $this->mimeSniff('jpg-with space.jpg'));
    }

    public function testJpeg2000()
    {
        $this->assertEquals('image/jp2', $this->mimeSniff('jpeg-2000-jp2-test.jp2'));
        // TODO: test jpx, etc
    }

    public function testPSD()
    {
        $this->assertEquals('application/psd', $this->mimeSniff('psd-test.psd'));
    }

    public function testSVG()
    {
        $this->assertEquals('image/svg+xml', $this->mimeSniff('svg-test.svg'));
    }

    public function testTiff()
    {
        $this->assertEquals('image/tiff', $this->mimeSniff('tif-test.tif'));
    }

    public function testWebP()
    {
        $this->assertEquals('image/webp', $this->mimeSniff('webp-test.webp'));
    }

    public function testAvif()
    {
        //$this->assertEquals('image/avif', $this->mimeSniff('avif-test.avif'));
        $this->assertEquals('image/avif', $this->mimeSniff('avif-test.avif'));
    }

    /* --------- below here: files that are not images, should NOT be recognized ------------- */
    public function testTxt()
    {
        $this->assertNull($this->mimeSniff('not-images/txt-test.txt'));
        $this->assertNull($this->mimeSniff('not-images/txt-test-very-small.txt'));
        $this->assertNull($this->mimeSniff('not-images/text-with-jpg-extension.jpg'));
    }
    public function testODT()
    {
        $this->assertNull($this->mimeSniff('not-images/odt-test.odt'));
    }

    /* --------- below here: exceptions ------------- */

    public function testFilenameNotString()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect(10);
        //$this->mimeSniff(10);
    }

    public function testFilenameHasNULChar()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect("a\0");
    }
    public function testFilenameHasControlChars()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect("..\1..");
    }

    public function testFilenameIsEmpty()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect("");
    }

    public function testFilenameIsPhar()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect('phar://aoeu');
    }

    public function testFileNotFound()
    {
       // why does this fail in PHP 7.2 ? (Uninitialized string offset: 0)
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect(__DIR__ . '/images/no-such-file.jpg');
    }
    public function testFileIsDir()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect(__DIR__ . '/images');
    }

    public function testFileOnWebNotFound()
    {
       // why does this fail in PHP 7.2 ? (Uninitialized string offset: 0)
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect('http://aoeuhtaoeu.eau');
    }

    public function testPhPStreamWrapper()
    {
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect('php://input');
    }

    public function testFileNoReadPermission()
    {
        $root = vfsStream::setup();
        $file = vfsStream::newFile('hello.txt')
            ->withContent('hello')
            ->at($root)
            ->chmod(0000);

        // fopen should now fail...
        $this->expectException(\Exception::class);
        ImageMimeTypeSniffer::detect($file->url());
    }

    // https://github.com/bovigo/vfsStream/pull/212

    /*
    public function testICO()
    {
        $this->assertEquals('image/ico', $this->mimeSniff('ico-test.ico'));
        $this->assertEquals('image/ico', $this->mimeSniff('ico2-test.ico'));
    }*/


//        doDetectTest('not-images/txt-test.txt', false);

}
