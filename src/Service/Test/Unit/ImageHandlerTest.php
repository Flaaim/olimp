<?php

namespace App\Service\Test\Unit;

use App\Parser\Entity\Parser\Host;
use App\Parser\Entity\Parser\HostMapper;
use App\Service\ImageHandler;
use PHPUnit\Framework\TestCase;

class ImageHandlerTest extends TestCase
{
    public function testExtractSuccess(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractAndProcessMainImage("<div><div><img style=\"width: 300px;\" src=\"/QuestionImages/c36820/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div>"
        );
        $expect = $this->getHost()->getValue(). 'QuestionImages/c36820/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg';

        $this->assertSame($expect, $extracted);
    }

    public function testExtractEmpty(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractAndProcessMainImage("");
        $this->assertSame("", $extracted);
    }

    public function testExtractOnlyText(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractAndProcessMainImage('<div><div>Some text</div></div>');
        $this->assertSame("", $extracted);
    }
    public function testExtractInvalidImage(): void
    {
        $imageHandler = new ImageHandler($this->getHost());

        $expected = "<div><div><img style=\"width: 300px;\" =\"/QuestionImages/c36820/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div>";

        $extracted = $imageHandler->extractAndProcessMainImage($expected);

        $this->assertSame($expected, $extracted);
    }


    public function testExtractFromContentSuccess(): void
    {
        $imageHandler = new ImageHandler($this->getHost());

        $extracted = $imageHandler->extractImagesFromContent(
            "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg\" width=\"350\" height=\"191\" data-mce-selected=\"1\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div>\"Работать в защитных перчатках\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>",
        );
        $expected = $this->getHost()->getValue() . 'QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg';

        $this->assertSame($expected, $extracted);
    }
    public function testExtractFromContentSuccessMultiple(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractImagesFromContent(
            "<div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg\" width=\"350\" height=\"191\" data-mce-selected=\"1\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><div><img src=\"/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg\" width=\"350\" height=\"191\" data-mce-selected=\"1\" xmlns:xd=\"http://schemas.microsoft.com/office/infopath/2003\" xd:content-type=\"png\" /></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>-<div>\"Работать в защитных перчатках\"</div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div></div>"
        );

        $expected = $this->getHost()->getValue() . 'QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg' .' '. $this->getHost()->getValue() . 'QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg';

        $this->assertSame($expected, $extracted);
    }

    public function testExtractFromContentEmpty(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractImagesFromContent("");

        $this->assertSame("", $extracted);
    }

    public function testExtractFromContentTextOnly(): void
    {
        $imageHandler = new ImageHandler($this->getHost());
        $extracted = $imageHandler->extractImagesFromContent('<div><div>Some text </div></div>');

        $this->assertSame("", $extracted);
    }

    private function getHost(): Host
    {
        $hosts = [
            'http://prk.kuzstu.ru:9001/',
            'http://olimpoks.chukk.ru:82/'
        ];
        $mapper = new HostMapper($hosts);
        return new Host('http://olimpoks.chukk.ru:82/', $mapper);
    }

}
