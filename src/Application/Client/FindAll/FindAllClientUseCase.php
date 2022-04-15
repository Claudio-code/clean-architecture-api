<?php

namespace App\Application\Client\FindAll;

use App\Infrastructure\Persistence\Repository\ClientRepository;

class FindAllClientUseCase
{
    public function __construct(private readonly ClientRepository $clientRepository)
    {
    }

    public function findAll(FindAllClientInputData $inputData): FindAllClientOutPutData
    {
        $clientsPageable = $this->clientRepository->findAllPageable(
            page: $inputData->getPage(),
            size: $inputData->getSize()
        );
        return new FindAllClientOutPutData($clientsPageable);
    }
}
