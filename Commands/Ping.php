<?php

namespace Commands;

use Core\Commands\Command;
use Core\Commands\CommandHandler;
use Core\Disabled;
use Discord\Builders\CommandBuilder;
use Discord\Parts\Interactions\Interaction;

use function Core\messageWithContent;

#[Disabled]
#[Command]
class Ping implements CommandHandler
{
    public function handle(Interaction $interaction): void
    {
        $interaction->respondWithMessage(messageWithContent('Pong :ping_pong:'), true);
    }

    public function autocomplete(Interaction $interaction): void
    {
    }

    public function getConfig(): CommandBuilder
    {
        return (new CommandBuilder())
            ->setName('ping')
            ->setDescription('Ping the bot');
    }
}
