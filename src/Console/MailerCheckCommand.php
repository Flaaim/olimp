<?php

namespace App\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
use Symfony\Component\Mime\Email;

class MailerCheckCommand extends Command
{
    public function configure(): void
    {
        $this->setName('mailer:check');
        $this->setDescription('Check mail status');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $transport = (new EsmtpTransport('mailer', 1025))
            ->setUsername('app')
            ->setPassword('secret');

        $mailer = new Mailer($transport);
        try{
            $output->writeln('<info>Checking mail status</info>');
            $mailer->send(
                (new Email())
                    ->subject('Test email')
                    ->from('app@test.ru')
                    ->to('user@test.ru')
                    ->text('Test email')
            );
            $output->writeln('<info>Done...</info>');
        }catch (TransportExceptionInterface $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
        }


        return Command::SUCCESS;
    }
}
