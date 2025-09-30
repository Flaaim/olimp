<?php

namespace App\Permit\Command\CreatePayment\Request;

use App\Flusher;
use App\Permit\Command\CreatePayment\Response\Response;
use App\Permit\Entity\Email;
use App\Permit\Entity\Payment\Currency;
use App\Permit\Entity\Payment\Payment;
use App\Permit\Entity\Payment\PaymentRepository;
use App\Permit\Entity\Payment\Price;
use App\Permit\Entity\Payment\Status;
use App\Shared\Domain\Service\Payment\DTO\MakePaymentDTO;
use App\Shared\Domain\Service\Payment\PaymentException;
use App\Shared\Domain\Service\Payment\PaymentProviderInterface;
use App\Shared\Domain\ValueObject\Id;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Handler
{
    public function __construct(
        private readonly PaymentRepository $payments,
        private readonly Flusher $flusher,
        private readonly PaymentProviderInterface $paymentProvider,
    )
    {}

    public function handle(Command $command): Response
    {
        $payment = new Payment(
            new Id(Uuid::uuid4()->toString()),
            new Email($command->email),
            new Price(150.00, new Currency('RUB')),
            Status::pending(),
            $command->ticketId,
            new DateTimeImmutable()
        );
        try {
            $paymentInfo = $this->paymentProvider->initiatePayment(
                new MakePaymentDTO(
                    $payment->getPrice()->getValue(),
                    $payment->getPrice()->getCurrency()->getValue(),
                    'Оплата доступа к ответам на курс',
                    [
                        'email' => $payment->getEmail()->getValue(),
                        'ticketId' => $payment->getTicketId(),
                        'paymentId' => $payment->getId()->getValue(),
                    ],
                )
            );
            $payment->setExternalId($paymentInfo->paymentId);

        }catch (PaymentException $e){
            $payment->setStatus(Status::failed());

            $this->payments->create($payment);
            $this->flusher->flush();

            throw new PaymentException('Payment initiation failed');
        }

        $this->payments->create($payment);
        $this->flusher->flush();

        return new Response(
            $payment->getId()->getValue(),
            $payment->getStatus()->getValue(),
            $paymentInfo->redirectUrl,
        );
    }
}
