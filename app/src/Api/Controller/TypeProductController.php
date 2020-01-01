<?php

namespace RecruitingApp\Api\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Service\CreateTypeProductService;
use RecruitingApp\Service\DeleteTypeProductService;

class TypeProductController
{
    /**
     * @var CreateTypeProductService $createService
     */
    private $createService;

    /**
     * @var DeleteTypeProductService
     */
    private $deleteService;

    /**
     * TypeProductController constructor.
     * @param CreateTypeProductService $createService
     * @param DeleteTypeProductService $deleteService
     */
    public function __construct(CreateTypeProductService $createService, DeleteTypeProductService $deleteService)
    {
        $this->createService = $createService;
        $this->deleteService = $deleteService;
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

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {

            $id = $args['id'];

            $this->deleteService->delete($id);

            return $response->withStatus(204);

        } catch (\Exception $exception) {
            $response = $response->withStatus(500);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }
}