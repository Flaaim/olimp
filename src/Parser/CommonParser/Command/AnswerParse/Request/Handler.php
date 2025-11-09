<?php

namespace App\Parser\CommonParser\Command\AnswerParse\Request;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class Handler
{
    public function __construct(private readonly ClientInterface $client){}
    public function handle(Command $command): array
    {
        $parser = $command->parser;

        try{
            return array_map(function($question) use($parser){
                $question['answers'] = $this->parseResponse(
                    $this->client->post($parser->getHost()->getFullPathToAnswers(), [
                        'form_params' => [
                            'materialId' => $parser->getCourse()->getId(),
                            'questionId' => $question['Id']
                        ],
                        'headers' => [
                            'Cookie' => $parser->getCookie()->getCookiesToString(),
                        ]])->getBody()->getContents());
                    return $question;
                    },

                $command->questions);
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
        if (preg_match('#"rows"\s*:\s*(.+)\s*}\,#', $content, $matches)) {

            $rowsTable = $matches[1];

            return json_decode($rowsTable, true) ?? [];
        }
    }
}
