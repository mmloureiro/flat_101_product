<?php

namespace Flat101\Product\Domain\Repository;

use Flat101\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function findAll(): array;

    public function find(int $id): ?Product;

    public function save(Product $product): void;

    public function remove(Product $product): void;
}
