<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Command\CreateWallet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/api/wallet',
    name: 'wallet_create',
    methods: ['POST']
)]
class CreateWalletController extends AbstractController
{
    public function __invoke(MessageBusInterface $commandBus): Response
    {
        $commandBus->dispatch(new CreateWallet());

        return new Response(status: 201);
    }
}
