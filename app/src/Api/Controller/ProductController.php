<?php

namespace RecruitingApp\Api\Controller;

use Doctrine\ORM\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Service\CreateProductService;
use RecruitingApp\Service\DeleteProductService;

class ProductController
{
    /**
     * @var CreateProductService $createService
     */
    private $createService;

    /**
     * @var DeleteProductService
     */
    private $deleteService;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * ProductController constructor.
     * @param CreateProductService $createService
     * @param DeleteProductService $deleteService
     * @param EntityRepository $entityRepository
     */
    public function __construct(
        CreateProductService $createService,
        DeleteProductService $deleteService,
        EntityRepository $entityRepository
    ) {
        $this->createService = $createService;
        $this->deleteService = $deleteService;
        $this->repository = $entityRepository;
    }

    public function post(ServerRequestInterface $request, ResponseInterface $response)
    {
        try {

            $product = $this->createService->create($request->getParsedBody());

            $response = $response->withStatus(201);
            $response = $response->withHeader('location', "/api/product/{$product->getId()}");

            return $response;

        } catch (\Exception $exception) {
            $response = $response->withStatus(500);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }

    public function delete(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $id = $args['id'];

        $this->deleteService->delete($id);

        return $response->withStatus(204);
    }

    public function get(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        if (array_key_exists('id', $args)) {
            $product = $this->repository->find($args['id']);

            $content = json_encode($product);
        } else {
            $products = $this->repository->findAll();

            $content = json_encode($products);
        }

        $response->getBody()->write($content);

        return $response;
    }
}