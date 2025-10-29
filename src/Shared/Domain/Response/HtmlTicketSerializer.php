<?php

namespace App\Shared\Domain\Response;

use App\Parser\Entity\Ticket\Answer;
use App\Parser\Entity\Ticket\Question;

class HtmlTicketSerializer implements TicketSerializer
{
    public function serialize(TicketResponse $response): string
    {
        try{
            $html = '<div class="ticket">';
            $html .= '<div class="ticket-header">';
            $html .= '<h2>Название: ' . htmlspecialchars($response->name ?? 'Без названия') . '</h2>';
            $html .= '<div class="ticket-info">';
            $html .= '<p><strong>Шифр:</strong> ' . htmlspecialchars($response->cipher ?? 'Не указан') . '</p>';
            $html .= '</div>';
            $html .= '</div>';


            $html .= '<div class="questions">';
            $html .= '<h3>Вопросы (' . count($response->questions) . '):</h3>';

            foreach ($response->questions as $index => $question) {
                $html .= $this->renderQuestion($question, $index + 1);
            }

            $html .= '</div>';
            $html .= '</div>';

            return $html;
        }catch (\Throwable $e){
            throw new \RuntimeException('Failed to serialize ticket to HTML', 0, $e);
        }

    }

    private function renderQuestion(Question $question, int $number): string
    {
        $html = '<div class="question" id="question-' . htmlspecialchars($question->getId()) . '">';
        $html .= '<p class="question-text"><b>'. $number. '. ' .nl2br(htmlspecialchars($question->getText())) . ' </b></p>';


        if(!empty($question->getQuestionMainImg())){
            $html .= '<img class="question-img" src="' . $question->getQuestionMainImg() . '">';
        }

        foreach ($question->getAnswers() as $index => $answer) {
            $html .= $this->renderAnswers($answer, $index + 1);
        }

        return $html . '</div>';
    }

    private function renderAnswers(Answer $answer, int $number): string
    {

        $correct = $answer->isCorrect() ? 'style="color:green"' : '';
        $image = !empty($answer->getImg()) ? '<img class="answer-img" width="100px" src="' . $answer->getImg() . '">' : '';

        $html = '<ul class="answer" id="answer-' . htmlspecialchars($answer->getId()) . '">';

        $html .= '<li class="answer-item" '. $correct . '>' . nl2br(htmlspecialchars($answer->getText())) . '</li>';
        $html .= $image;

        $html .= '</ul>';
        return $html;
    }
}
