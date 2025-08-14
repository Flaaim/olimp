<?php

namespace App\Parser\Command\Parse\Request;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;


class Handler
{
    public function __construct(private readonly ClientInterface $client){}
    public function handle(Command $command): array
    {
        $parser = $command->parser;

        try{
            $response  = $this->client->post($parser->getHost()->getValue(), [
                    'form_params' => [
                        'branchId' => $parser->getCourse()->getId(),
                        'ticketId' => $parser->getCourse()->getTicketId(),
                    ],
                    'headers' => [
                        'Cookie' => $parser->getCookie()->getCookiesToString(),
                    ]
                ]
            );
            return $this->parseResponse($response->getBody()->getContents());
        }catch(GuzzleException $e){
            throw new \RuntimeException(
                'Failed to fetch data: ' . $e->getMessage(),
                $e->getCode(),
                $e
            );
        }catch (\Exception $e){
            throw new \Exception($e->getMessage(), $e->getCode());
        }
    }

    private function parseResponse(string $content): array
    {
        return json_decode($content, true) ?? [];
    }
}
