<?php

namespace RecruitingApp\Api\Controller;

use Doctrine\ORM\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Repository\ProductRepository;
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
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductController constructor.
     * @param CreateProductService $createService
     * @param DeleteProductService $deleteService
     * @param ProductRepository $entityRepository
     */
    public function __construct(
        CreateProductService $createService,
        DeleteProductService $deleteService,
        ProductRepository $entityRepository
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
        try {
            if (array_key_exists('idOrName', $args)) {

                $idOrName = $args['idOrName'];

                $product = is_numeric($idOrName)
                    ? $this->repository->find($idOrName)
                    : $this->repository->findByNameLike($idOrName);

            } else {
                $product = $this->repository->findAll();
            }

            if (empty($product)) {
                throw new ApiException('Produto não encontrado.');
            }

            $content = json_encode($product);
            $response->getBody()->write($content);

            return $response;

        } catch (ApiException $exception) {
            $response = $response->withStatus(500);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }
}