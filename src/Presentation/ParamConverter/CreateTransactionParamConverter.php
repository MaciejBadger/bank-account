<?php

declare(strict_types=1);

namespace App\Presentation\ParamConverter;

use App\Application\Command\CreateTransaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Webmozart\Assert\Assert;

class CreateTransactionParamConverter implements ParamConverterInterface
{
    public function apply(Request $request, ParamConverter $configuration): bool
    {
        $id = $request->attributes->get('id');
        Assert::string($id);
        Assert::uuid($id);
        $content = $request->getContent();
        Assert::string($content);
        $requestBody = json_decode($content, true);
        Assert::isArray($requestBody);
        $type = $requestBody['type'];
        Assert::string($type);
        $amount = (float) $requestBody['amount'];

        $createTransactionCommand = new CreateTransaction(
            walletId: $id,
            amount: $amount,
            type: $type
        );
        $request->attributes->set('command', $createTransactionCommand);

        return true;
    }

    public function supports(ParamConverter $configuration): bool
    {
        return CreateTransaction::class === $configuration->getClass();
    }
}
