<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('create-new-client')
            ->setDescription('Create a new client')
            ->addArgument('mail', InputArgument::REQUIRED, 'Your email')
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getApplication()->getKernel()->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array($this->getContainer()->get('kernel')->getRootDir()));
        $client->setAllowedGrantTypes(array('password', 'refresh_token'));
        $clientManager->updateClient($client);
        $message = \Swift_Message::newInstance()
        ->setSubject('Your BileMo API access code')
        ->setFrom('noreply@tisch.fr')
        ->setTo($input->getArgument('mail'))
            ->setBody(
                $this->getContainer()->get('templating')->render(
                    'email.html.twig',
                    array(
                        'client_id' => $client->getPublicId(),
                        'client_secret' => $client->getSecret(),
                    )
                ),
                'text/html'
            )
        ;
        $output->writeln('Your BileMo API access code : ');
        $output->writeln('Your client_id : ' . $client->getPublicId());
        $output->writeln('Your client_secret : ' . $client->getSecret());

        if($this->getContainer()->get('mailer')->send($message)){
            $output->writeln('Your BileMo access code has been sent to your email address.');
        }else{
            $output->writeln('error while sending the email.');
        }
    }
}