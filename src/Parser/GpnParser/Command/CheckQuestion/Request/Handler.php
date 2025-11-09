<?php

namespace App\Parser\GpnParser\Command\CheckQuestion\Request;

use App\Parser\Service\Gpn\AnswersCorrectness;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Handler
{
    public function __construct(
        private readonly ClientInterface $client,
        private readonly AnswersCorrectness $answersCorrectness
    ){}
    public function handle(Command $command): array
    {
        try {
            $parser = $command->parser;
            foreach ($command->questions as &$question) {
                if($question['answerType'] === 1) {
                    $response = $this->client->post($parser->getHost()->getPathToCheckQuestions(), [
                        'form_params' => [
                            'QuestionId' => $question['id'],
                            'MaterialId' => $command->materialId,
                            'Info.Type' => $question['answerType'],
                            'Info.Ids' => array_column($question['answers'], 'id'),
                        ],
                        'headers' => [
                            'Cookie' => $parser->getCookie()->getCookiesToString(),
                        ]
                    ]);
                    $response = $this->parseResponse($response->getBody()->getContents());
                    $this->answersCorrectness->updateAnswersCorrectness($question['answers'], $response);
                }
                if($question['answerType'] === 0){
                    foreach ($question['answers'] as $index => &$answer) {
                        $response = $this->client->post($parser->getHost()->getPathToCheckQuestions(), [
                            'form_params' => [
                                'QuestionId' => $question['id'],
                                'MaterialId' => $command->materialId,
                                'Info.Type' => $question['answerType'],
                                'Info.Ids' => $index,
                            ],
                            'headers' => [
                                'Cookie' => $parser->getCookie()->getCookiesToString(),
                            ]
                        ]);
                        $response = $this->parseResponse($response->getBody()->getContents());
                        $this->answersCorrectness->updateOneAnswerCorrectness($answer, $response);
                    }


                }

            }
            return $command->questions;
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
