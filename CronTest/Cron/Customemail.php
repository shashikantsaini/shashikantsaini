<?php

namespace Bluethink\CronTest\Cron;

class Customemail
{
    private $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->logger = $logger;
    }

    public function execute()
    {

        //send custom mail
        $this->logger->info('Cron Works Shashi');

    }
}