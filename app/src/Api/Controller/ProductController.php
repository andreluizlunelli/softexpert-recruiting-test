<?php

namespace RecruitingApp\Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Service\CreateProductService;

class ProductController
{
    /**
     * @var CreateProductService $createProductService
     */
    private $createProductService;

    /**
     * ProductController constructor.
     * @param CreateProductService $createProductService
     */
    public function __construct(CreateProductService $createProductService)
    {
        $this->createProductService = $createProductService;
    }

    public function post(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $product = $this->createProductService->create($request->getParsedBody());

            $response = $response->withStatus(201);
            $response = $response->withHeader('location', "/api/product/{$product->getId()}");

            return $response;

        } catch (\Exception $exception) {
            $response = $response->withStatus(500);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }
}