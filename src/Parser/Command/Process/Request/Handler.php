<?php

namespace App\Parser\Command\Process\Request;

class Handler
{
    public function handle(Command $command): array
    {
        $rows = $this->extractRows($command->rawData);
        $options = $command->options;

        if($options->has('limit')) {
            $rows = array_splice($rows, 0, $options->getValue('limit'));
        }

        if ($options->has('offset')) {
            $rows = array_slice($rows, $options->getValue('offset'));
        }

        return $rows;
    }

    private function extractRows(array $rawData): array
    {
        return $rawData['rows'] ?? [];
    }

}
