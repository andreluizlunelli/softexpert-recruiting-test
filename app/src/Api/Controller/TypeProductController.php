<?php

namespace RecruitingApp\Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Service\CreateTypeProductService;

class TypeProductController
{
    /**
     * @var CreateTypeProductService $createService
     */
    private $createService;

    /**
     * TypeProductController constructor.
     * @param CreateTypeProductService $createService
     */
    public function __construct(CreateTypeProductService $createService)
    {
        $this->createService = $createService;
    }

    public function post(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $typeProduct = $this->createService->create($request->getParsedBody());

            $response = $response->withStatus(201);
            $response = $response->withHeader('location', "/api/type-product/{$typeProduct->getId()}");

            return $response;

        } catch (\Exception $exception) {
            $response = $response->withStatus(500);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }
}