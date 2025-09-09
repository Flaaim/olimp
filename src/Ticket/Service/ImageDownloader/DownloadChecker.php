<?php

namespace App\Ticket\Service\ImageDownloader;

use App\Parser\Entity\Ticket\Answer;
use App\Parser\Entity\Ticket\Question;

class DownloadChecker
{
    public function shouldDownloadQuestionImage(Question $question): bool
    {
        if (!empty($question->getQuestionMainImg()) &&
            filter_var($question->getQuestionMainImg(), FILTER_VALIDATE_URL)) {
            return true;
        }

        foreach ($question->getAnswers() as $answer) {
            if ($this->shouldDownloadAnswerImage($answer)) {
                return true;
            }
        }
        return false;
    }

    public function shouldDownloadAnswerImage(Answer $answer): bool
    {
        return !empty($answer->getImg()) &&
            filter_var($answer->getImg(), FILTER_VALIDATE_URL) &&
            $answer->getImg() !== '';
    }
}
