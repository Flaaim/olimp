<?php

namespace App\Parser\Test\Unit\Entity;

use App\Parser\Command\ResponseParse;
use App\Parser\Entity\Ticket\Ticket;
use PHPUnit\Framework\TestCase;

class TicketTest extends TestCase
{

    public function testFromArray(): void
    {
        $ticket = Ticket::fromArray($this->getArrayData());
        $array = ResponseParse::fromTicket($ticket)->jsonSerialize();

        $this->assertEquals($this->getArrayData(), $array);
    }

    private function getArrayData(): array
    {

        return [
            'id' => '9f094fe9-8b56-47ac-bfb7-192fa2d628de',
            'name' => null,
            'cipher' => null,
            'questions' => [
                [
                    'id' => '49336cb09422414399ec69aa582f60e4',
                    'number' => '1',
                    'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Кабель должен быть в кислостойком шланге',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Кабель должен иметь не более 3 скруток',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Кабель должен быть только в тканевой оплетке',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Кабель должен быть длиной не более 1,5 м',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '81703c227f8e4a379591e0d59f4fc093',
                    'number' => '2',
                    'text' => 'Установите соответствие между знаками безопасности и их значениями.',
                    'image' => '',
                    'answers' => [
                        [
                            'text' => '"Запрещается прикасаться. Опасно"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg">'
                        ],
                        [
                            'text' => '"Осторожно. Возможно травмирование рук"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg">'
                        ],
                        [
                            'text' => '"Работать в защитных перчатках"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg">'
                        ],
                        [
                            'text' => '"Опасно. Едкие и коррозионные вещества"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/4.jpg">'
                        ]
                    ]
                ],
                [
                    'id' => '7c7f0af42f28486484010dccaf6942c8',
                    'number' => '3',
                    'text' => 'Установите правильную последовательность действий работника в случае обнаружения пожара.',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/7c7f0af4-2f28-4864-8401-0dccaf6942c8/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Сообщить о возгорании по телефону в пожарную охрану',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Принять меры по эвакуации людей',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Приступить к тушению пожара в начальной стадии (при отсутствии угрозы жизни и здоровью людей)',
                            'isCorrect' => true,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '27b164d193474fb08555e08d5f9c2393',
                    'number' => '4',
                    'text' => 'Какие работники допускаются к работе с кислотой, щелочью и свинцом?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/27b164d1-9347-4fb0-8555-e08d5f9c2393/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Работники, которым выданы памятки по обращению с кислотой, щелочью и свинцом',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Работники, достигшие возраста 16 лет',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Работники, прошедшие специальное обучение',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Работники, имеющие минимальные представления и знания по применению кислоты, щелочи и свинца',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '5f2c5383dfb841898721e977ad747171',
                    'number' => '5',
                    'text' => 'Каким документом определяются специальные меры предосторожности при выполнении работ с аккумуляторными батареями во избежание отравления свинцом и его соединениями?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/5f2c5383-dfb8-4189-8721-e977ad747171/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Памяткой для работников организации',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Коллективным договором',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Инструкцией по эксплуатации и ремонту аккумуляторных батарей',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Положением об организации работы по охране труда на предприятии',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '7f1c0a2bb52a4ff5876e9ab636cd1eb7',
                    'number' => '6',
                    'text' => 'Что соответствует требованиям безопасности при хранении кислоты, предназначенной для приготовления электролита?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/7f1c0a2b-b52a-4ff5-876e-9ab636cd1eb7/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Кислота должна храниться в стеклянных бутылях с притертыми пробками, снабженных бирками с названием кислоты',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Кислота должна храниться в металлических емкостях, снабженных бирками, на которых указана валентность кислотного остатка',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Бутыли с кислотой и порожние бутыли должны находиться в одном помещении с аккумуляторными батареями',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Бутыли следует устанавливать на полу на диэлектрический коврик',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '106e052558774517895892d5545dcd67',
                    'number' => '7',
                    'text' => 'Какое наказание предусматривается за причинение тяжкого вреда здоровью по неосторожности, совершенное вследствие ненадлежащего исполнения работником своих профессиональных обязанностей?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/106e0525-5877-4517-8958-92d5545dcd67/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Ограничение или лишение свободы либо принудительные работы',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Увольнение без привлечения к уголовной ответственности',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Исключение из первичной профсоюзной организации',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Выговор либо лишение заработной платы',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '9c6d0c712e9e4286afbe39b4d6c89d95',
                    'number' => '8',
                    'text' => 'Каким образом допускается перемещать бутыли с кислотой от места разгрузки до складского помещения и обратно?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/9c6d0c71-2e9e-4286-afbe-39b4d6c89d95/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'В одиночку, держа бутыль одной рукой за горловину, а другой рукой придерживая дно',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'В одиночку, держа бутыль в руках перед собой',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Используя носилки, тележки, тачки, обеспечивающие безопасность выполняемых операций',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'С применением шестов, продеваемых сквозь ручки корзины',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => 'f1c21c40e2e34310940c9a2b70fe0067',
                    'number' => '9',
                    'text' => 'Какое требование предъявляется к аккумуляторному помещению по окончании в нем работ?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/f1c21c40-e2e3-4310-940c-9a2b70fe0067/8/1.jpg',
                    'answers' => [
                        [
                            'text' => 'Аккумуляторное помещение должно быть открыто и должно иметь свободный доступ',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'Аккумуляторное помещение должно быть заперто на замок',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => 'Аккумуляторное помещение должно быть заперто на засов',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => 'На входной двери должна быть вывешена табличка "Опасно. Не входить"',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ],
                [
                    'id' => '1a7bf743e39a4587a7bafc43de76045d',
                    'number' => '10',
                    'text' => 'Какие надписи должны быть на дверях аккумуляторного помещения?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c36820/1a7bf743-e39a-4587-a7ba-fc43de76045d/8/1.jpg',
                    'answers' => [
                        [
                            'text' => '"Аккумуляторная", "Огнеопасно", "Запрещается курить"',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'text' => '"Внимание! Опасность", "Не открывать! Работают люди", "Посторонним вход воспрещен"',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => '"Аккумуляторы", "Опасно! Ядовитые вещества", "Посторонним вход воспрещен"',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'text' => '"Посторонним вход воспрещен", "Огнеопасно", "Внимание! Опасность"',
                            'isCorrect' => false,
                            'image' => ''
                        ]
                    ]
                ]
            ]
        ];

    }
}
