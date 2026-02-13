<?php

namespace Flat101\Product\Application\Find;

use Flat101\Product\Domain\Entity\Product;
use Flat101\Product\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FindProductUseCase
{
    public function __construct(
        private readonly ProductRepositoryInterface $repository
    ) {
    }

    public function execute(int $id): Product
    {
        $product = $this->repository->find($id);

        if (!$product) {
            throw new NotFoundHttpException("Product with ID $id not found");
        }

        return $product;
    }

}
