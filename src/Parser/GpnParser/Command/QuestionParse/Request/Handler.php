<?php

namespace App\Parser\GpnParser\Command\QuestionParse\Request;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Handler
{
    public function __construct(private readonly ClientInterface $client){}
    public function handle(Command $command)
    {
        $parser = $command->parser;
        try{
            $response  = $this->client->post($parser->getHost()->getFullPathToQuestions(), [
                    'form_params' => [
                        'materialId' => $parser->getCourse()->getMaterialId(),
                        'questionIds' => $parser->getCourse()->getQuestionIds(),
                        'topicId' => $parser->getCourse()->getTopicId(),
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
