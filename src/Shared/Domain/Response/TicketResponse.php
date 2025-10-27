<?php

namespace App\Shared\Domain\Response;

use App\Parser\Entity\Ticket\Answer;
use App\Parser\Entity\Ticket\Question;
use App\Parser\Entity\Ticket\Ticket;

class TicketResponse implements \JsonSerializable
{
    public function __construct(
        private readonly string  $id,
        private readonly ?string $name,
        private readonly ?string $cipher,
        private readonly string  $status,
        private readonly ?float $price,
        private readonly array $questions,
    ){}

    public static function fromResult(Ticket $ticket, $limit = null): self
    {
        $price = null;

        if($ticket->hasPrice()) {
            $price = $ticket->getPrice()->getValue();
        }

        return new self(
            $ticket->getId(),
            $ticket->getName(),
            $ticket->getCipher(),
            $ticket->getStatus()->getValue(),
            $price,
            $ticket->getQuestions()->slice(0, $limit),
        );
    }
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cipher' => $this->cipher,
            'status' => $this->status,
            'price' => $this->price,
            'questions' => array_map(
                fn ($question) => [
                    'id' => $question->getId(),
                    'number' => $question->getNumber(),
                    'text' => $question->getText(),
                    'image' => $question->getQuestionMainImg(),
                    'answers' => array_map(
                        fn ($answer) => [
                            'id' => $answer->getId()->getValue(),
                            'text' => $answer->getText(),
                            'isCorrect' => $answer->isCorrect(),
                            'image' => $answer->getImg(),
                        ], $question->getAnswers()->toArray()
                    )
                ], $this->questions
            )
        ];
    }

    public function htmlSerialize(): string
    {
        $html = '<div class="ticket">';
        $html .= '<div class="ticket-header">';
        $html .= '<h2>Название: ' . htmlspecialchars($this->name ?? 'Без названия') . '</h2>';
        $html .= '<div class="ticket-info">';
        $html .= '<p><strong>Шифр:</strong> ' . htmlspecialchars($this->cipher ?? 'Не указан') . '</p>';
        $html .= '</div>';
        $html .= '</div>';


        $html .= '<div class="questions">';
        $html .= '<h3>Вопросы (' . count($this->questions) . '):</h3>';

        foreach ($this->questions as $index => $question) {
            $html .= $this->renderQuestion($question, $index + 1);
        }

        $html .= '</div>';
        $html .= '</div>';

        return $html;
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
