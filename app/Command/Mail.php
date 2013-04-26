<?php
namespace Command;

// bibliotecas utilizadas.
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aws\Common\Enum\Region;
use Aws\Ses\SesClient;

class Mail extends Command {
    const BASE = 'http://www.sambaderaiz.net';

    protected function configure() {
        $this
                ->setName('mail:test')
                ->setDescription('Testa o envio de e-mail pela Amazon SES')
                ->addArgument('email', InputArgument::REQUIRED, 'e-mail de destino')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $albumUrl = $input->getArgument('email');

        try {
            // Read configuration file
            $config = new \SimpleXMLElement(file_get_contents(XML_CONFIG));

            try {
                // Getting Amazon Web Service Credentials
                $credentials = $config->xpath("//services/service[@name='Amazon']");
                $credentials = array_shift($credentials);

                // Instantiate the SES client with your AWS credentials
                $client = SesClient::factory(array(
                            'key' => $credentials->key,
                            'secret' => $credentials->secret,
                            'region' => Region::US_EAST_1
                        ));

                // Getting Amazon SES Sending Limits
                /* @var $cota array */
                $cota = $client->GetSendQuota()->toArray();
                $limite = round($cota ['Max24HourSend']);
                $envios = round($cota ['SentLast24Hours']);

                if ($envios >= $limite) {
                    try {
                        $sent = $client->SendEmail(array(
                            'Source' => 'postmaster@mrprompt.com.br',
                            'Destination' => array(
                                'ToAddresses' => array(
                                    $to
                                )
                            ),
                            'Message' => array(
                                'Subject' => array(
                                    'Charset' => 'UTF-8',
                                    'Data' => $title
                                ),
                                'Body' => array(
                                    'Html' => array(
                                        'Charset' => 'UTF-8',
                                        'Data' => $message
                                    )
                                )
                            )
                                ));

                        return $sent;
                    } catch (Exception $e) {
                        throw $e;
                    }
                }

                // Amazon SES Statistics
                /* @var $status array */
                $status = $client->GetSendStatistics()->toArray();
                print_r($status);

                // Identities authorized to sent e-mails
                /* @var $identities array */
                $identities = $client->ListIdentities()->toArray();
                print_r($identities);

                // verify an e-mail address to use as sender
                $verifyEmail = $client->VerifyEmailIdentity(array(
                    'EmailAddress' => 'thiago.paes@flexy.com.br'
                        ));

                // send an e-mail test
                $destinations = array(
                    1 => 'thiago.paes@flexy.com.br',
                    2 => 'mrprompt@gmail.com'
                );

                foreach ($destinations as $destination) {
                    try {
                        /* @var $sent array */
                        mail($destination, 'Teste');
                    } catch (\Aws\Ses\Exception\SesException $e) {
                        echo $e->getMessage(), PHP_EOL;
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage(), PHP_EOL;
            }
        } catch (Exception $e) {
            die($e->getMessage() . PHP_EOL);
        }

        $output->writeln('ok');
    }

}
