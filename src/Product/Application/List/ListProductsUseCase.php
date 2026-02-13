<?php

namespace Flat101\Product\Application\List;

use Flat101\Product\Domain\Repository\ProductRepositoryInterface;

class ListProductsUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->findAll();
    }
}
