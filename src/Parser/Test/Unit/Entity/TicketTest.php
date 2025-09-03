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
            'id' => '90f3b701-3602-4050-a27f-a246ee980fe7',
            'name' => null,
            'cipher' => null,
            'questions' => [
                [
                    'id' => '49336cb09422414399ec69aa582f60e4',
                    'number' => '1',
                    'text' => 'Какое требование предъявляется к кабелю переносной лампы, применяемой в работе с кислотными аккумуляторными батареями?',
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/49336cb0-9422-4143-99ec-69aa582f60e4/8/1.jpg',
                    'answers' => [
                        [
                            'id' => 'e587aa55-e210-40cf-80c1-4fab48209192',
                            'text' => 'Кабель должен быть в кислостойком шланге',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '6fb5b3db-2a8b-4c3b-95a0-c9c13ddae3a4',
                            'text' => 'Кабель должен иметь не более 3 скруток',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'e6dac57f-2c3d-43f2-87b4-79ba3b92c8ae',
                            'text' => 'Кабель должен быть только в тканевой оплетке',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'e09aa4b3-0474-4e25-90ba-240565a62a0a',
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
                            'id' => '87c1f2f9-395b-4517-afb8-9b2146660445',
                            'text' => '"Запрещается прикасаться. Опасно"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/1.jpg">'
                        ],
                        [
                            'id' => 'a9c8a646-4cd6-481d-bb93-1fdc9da1e782',
                            'text' => '"Осторожно. Возможно травмирование рук"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/2.jpg">'
                        ],
                        [
                            'id' => '67e194bd-2526-40c7-9eac-6e64e99419f4',
                            'text' => '"Работать в защитных перчатках"',
                            'isCorrect' => true,
                            'image' => '<img src="http://olimpoks.chukk.ru:82/QuestionImages/81703c22-7f8e-4a37-9591-e0d59f4fc093/8/3.jpg">'
                        ],
                        [
                            'id' => 'ed70bd9b-f661-439a-99ac-82595324d2f8',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/7c7f0af4-2f28-4864-8401-0dccaf6942c8/8/1.jpg',
                    'answers' => [
                        [
                            'id' => '50d0ebdd-6c82-4fca-aa6c-6f7054c54dde',
                            'text' => 'Сообщить о возгорании по телефону в пожарную охрану',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => 'deafa7ab-76c5-4f24-afa2-de5bce32aacc',
                            'text' => 'Принять меры по эвакуации людей',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => 'b46f838d-3a5a-4104-887c-6ae04652076c',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/27b164d1-9347-4fb0-8555-e08d5f9c2393/8/1.jpg',
                    'answers' => [
                        [
                            'id' => 'ac5c09df-fc6a-4ece-865d-7d12db0f6e74',
                            'text' => 'Работники, которым выданы памятки по обращению с кислотой, щелочью и свинцом',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'abccbc1e-4013-45c2-9e21-0965322c7bc1',
                            'text' => 'Работники, достигшие возраста 16 лет',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'ca4f8fc7-b5ff-4fb9-9ef5-e0dc2603365b',
                            'text' => 'Работники, прошедшие специальное обучение',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '0eec148c-6877-4653-bb04-4eacedbce22f',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/5f2c5383-dfb8-4189-8721-e977ad747171/8/1.jpg',
                    'answers' => [
                        [
                            'id' => 'a767507f-e7db-435c-b737-10635f882ba5',
                            'text' => 'Памяткой для работников организации',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'bdfb9645-2c42-465a-8b69-d68ea77b8829',
                            'text' => 'Коллективным договором',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'ee942067-7d6b-4f81-8c57-5f8a56d8436e',
                            'text' => 'Инструкцией по эксплуатации и ремонту аккумуляторных батарей',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '1906ba77-a589-4bff-8bba-3120c3558c8c',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/7f1c0a2b-b52a-4ff5-876e-9ab636cd1eb7/8/1.jpg',
                    'answers' => [
                        [
                            'id' => 'd5eeaed8-bbfb-4b90-82aa-95aa1216a85a',
                            'text' => 'Кислота должна храниться в стеклянных бутылях с притертыми пробками, снабженных бирками с названием кислоты',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => 'da7e3776-b766-4ba8-9621-79a42930265e',
                            'text' => 'Кислота должна храниться в металлических емкостях, снабженных бирками, на которых указана валентность кислотного остатка',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '62eb60c1-21c9-44e5-80cf-8bb9b82cbfb6',
                            'text' => 'Бутыли с кислотой и порожние бутыли должны находиться в одном помещении с аккумуляторными батареями',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'e28074d7-b146-425f-a2fe-89bdbbfd7479',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/106e0525-5877-4517-8958-92d5545dcd67/8/1.jpg',
                    'answers' => [
                        [
                            'id' => '98448734-be3c-4b2f-a891-d8dc12d36f6e',
                            'text' => 'Ограничение или лишение свободы либо принудительные работы',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => 'd069dff6-d278-48ba-8c1f-8f6393d6c8af',
                            'text' => 'Увольнение без привлечения к уголовной ответственности',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '94a0b725-201c-41e6-b67e-54220c2bcac3',
                            'text' => 'Исключение из первичной профсоюзной организации',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '6e9507f3-0659-4784-801a-927bc6d49b2e',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/9c6d0c71-2e9e-4286-afbe-39b4d6c89d95/8/1.jpg',
                    'answers' => [
                        [
                            'id' => '42a637d4-fefd-4764-896f-faadb6045655',
                            'text' => 'В одиночку, держа бутыль одной рукой за горловину, а другой рукой придерживая дно',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '40278d5b-4ed9-4f73-8fcf-b9fd0b35d4c1',
                            'text' => 'В одиночку, держа бутыль в руках перед собой',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '19f685e2-78c6-432b-b4ec-60580cb75f4c',
                            'text' => 'Используя носилки, тележки, тачки, обеспечивающие безопасность выполняемых операций',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '3de19940-9b92-4d61-800a-6580c2e15aef',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/f1c21c40-e2e3-4310-940c-9a2b70fe0067/8/1.jpg',
                    'answers' => [
                        [
                            'id' => '19372be2-8a28-44d4-bc90-e70a9b5a969e',
                            'text' => 'Аккумуляторное помещение должно быть открыто и должно иметь свободный доступ',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => '2f544d76-0280-410a-9eda-f451b1889c01',
                            'text' => 'Аккумуляторное помещение должно быть заперто на замок',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '66e2cf0d-9e08-4fe0-acc7-168d9bfd8c4e',
                            'text' => 'Аккумуляторное помещение должно быть заперто на засов',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'c7c5862e-915e-4554-9531-bf0e7f87b4fd',
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
                    'image' => 'http://olimpoks.chukk.ru:82/QuestionImages/c37111/1a7bf743-e39a-4587-a7ba-fc43de76045d/8/1.jpg',
                    'answers' => [
                        [
                            'id' => 'd80d83d2-09e6-42f5-b99c-a8cdf1e177d2',
                            'text' => '"Аккумуляторная", "Огнеопасно", "Запрещается курить"',
                            'isCorrect' => true,
                            'image' => ''
                        ],
                        [
                            'id' => '3a232537-ab98-451d-bc39-643c5f51d08b',
                            'text' => '"Внимание! Опасность", "Не открывать! Работают люди", "Посторонним вход воспрещен"',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'cd570142-63fc-4558-88d9-716160dd1727',
                            'text' => '"Аккумуляторы", "Опасно! Ядовитые вещества", "Посторонним вход воспрещен"',
                            'isCorrect' => false,
                            'image' => ''
                        ],
                        [
                            'id' => 'bba90557-d45d-4459-869d-6942b08c891c',
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
