<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Query\GetBalanceQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Webmozart\Assert\Assert;

#[Route(
    path: '/api/wallet/{id}/balance',
    name: 'wallet_balance_get',
    methods: ['GET']
)]
class GetBalanceController extends AbstractController
{
    public function __invoke(Request $request, MessageBusInterface $queryBus): Response
    {
        $id = $request->attributes->get('id');
        Assert::string($id);

        $envelope = $queryBus->dispatch(new GetBalanceQuery($id));
        /** @var HandledStamp $handled */
        $handled = $envelope->last(HandledStamp::class);

        return new JsonResponse(['balance' => $handled->getResult()]);
    }
}
