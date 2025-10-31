<?php

namespace App\Shared\Test\Unit\Response;

use App\Http\JsonResponse;
use App\Shared\Domain\Response\TicketResponse;
use App\Shared\Domain\Response\TicketResponseFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Twig\Environment;


class ResponseFactoryTest extends TestCase
{
    public static function additionProvider(): array
    {
        return [
            ['json'],
            ['html'],
            ['yaml']
        ];
    }
    #[DataProvider('additionProvider')]
    public function testSuccess($type): void
    {
        $factory = new TicketResponseFactory($type, $this->createMock(Environment::class));
        self::assertEquals($type, $factory->getType());
    }

    public function testInvalid(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Type test not provided');
        new TicketResponseFactory('test', $this->createMock(Environment::class));
    }
    public function testWithOutTwig(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Twig is required for HTML responses');
        new TicketResponseFactory('html', null);
    }

    public function testResponse(): void
    {
        $ticket = $this->createMock(TicketResponse::class);
        $factory = new TicketResponseFactory('json', $this->createMock(Environment::class));
        $response = $factory->createResponse($ticket);

        self::assertInstanceOf(JsonResponse::class, $response);
    }


}
