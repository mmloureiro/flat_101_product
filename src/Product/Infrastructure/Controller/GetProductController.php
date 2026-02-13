<?php

declare(strict_types=1);

namespace Flat101\Product\Infrastructure\Controller;

use Flat101\Product\Application\Find\FindProductUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use OpenApi\Attributes as OA;

#[Route('/api/products/{id}', name: 'api_products_get', methods: ['GET'])]
class GetProductController extends AbstractController
{
    #[OA\Get(
        path: '/api/products/{id}',
        summary: 'Get details of a product',
        tags: ['Product'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'ID of the product to retrieve',
                schema: new OA\Schema(type: 'integer')
            )
        ]
    )]
    #[OA\Response(
        response: 200,
        description: 'Returns the product details',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'Producto Ejemplo'),
                new OA\Property(property: 'price', type: 'number', format: 'float', example: 29.99),
                new OA\Property(
                    property: 'createdAt',
                    type: 'string',
                    format: 'date-time',
                    example: '2026-02-11T10:30:00+00:00'
                )
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: 'Product not found',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'error', type: 'string', example: 'Product not found'),
                new OA\Property(property: 'code', type: 'integer', example: 404)
            ]
        )
    )]
    public function __invoke(
        int $id,
        FindProductUseCase $useCase,
        SerializerInterface $serializer
    ): JsonResponse {
        try {
            $product = $useCase->execute($id);
        } catch (NotFoundHttpException $exception) {
            return new JsonResponse(
                [
                    'error' => $exception->getMessage(),
                    'code'  => Response::HTTP_NOT_FOUND
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            $serializer->serialize($product, 'json', ['groups' => 'product:read']),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
