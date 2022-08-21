<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Command\CreateTransaction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(
    path: '/api/transaction',
    name: 'transaction_create',
    methods: ['POST']
)]
class CreateTransactionController extends AbstractController
{
    public function __invoke(
        Request $request,
        MessageBusInterface $commandBus,
        SerializerInterface $serializer
    ): Response {
        /** @var CreateTransaction $command */
        $command = $serializer->deserialize(
            $request->getContent(),
            CreateTransaction::class,
            'json'
        );
        $commandBus->dispatch($command);

        return new JsonResponse(status: 201);
    }
}
