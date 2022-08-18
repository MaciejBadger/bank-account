<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Command\CreateTransaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/wallet/{id}/transaction',
    name: 'wallet_transaction_create',
    methods: ['POST']
)]
class CreateTransactionController extends AbstractController
{
    public function __invoke(CreateTransaction $command, MessageBusInterface $commandBus): Response
    {
        $commandBus->dispatch($command);

        return new Response(status: 201);
    }
}
