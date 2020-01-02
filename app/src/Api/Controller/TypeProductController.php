<?php

namespace RecruitingApp\Api\Controller;

use Doctrine\ORM\EntityRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RecruitingApp\Api\Exception\ApiException;
use RecruitingApp\Repository\TypeProductRepository;
use RecruitingApp\Service\AddProductOnTypeService;
use RecruitingApp\Service\CreateTypeProductService;
use RecruitingApp\Service\DeleteTypeProductService;
use RecruitingApp\Service\UpdateTypeProductService;

class TypeProductController
{
    /**
     * @var CreateTypeProductService
     */
    private $createService;

    /**
     * @var DeleteTypeProductService
     */
    private $deleteService;

    /**
     * @var UpdateTypeProductService
     */
    private $updateService;

    /**
     * @var AddProductOnTypeService
     */
    private $addProductService;

    /**
     * @var EntityRepository
     */
    private $repository;

    /**
     * TypeProductController constructor.
     * @param CreateTypeProductService $createService
     * @param DeleteTypeProductService $deleteService
     * @param UpdateTypeProductService $updateService
     * @param AddProductOnTypeService $addProductService
     * @param TypeProductRepository $entityRepository
     */
    public function __construct(
        CreateTypeProductService $createService,
        DeleteTypeProductService $deleteService,
        UpdateTypeProductService $updateService,
        AddProductOnTypeService $addProductService,
        TypeProductRepository $entityRepository
    ) {
        $this->createService = $createService;
        $this->deleteService = $deleteService;
        $this->updateService = $updateService;
        $this->repository = $entityRepository;
        $this->addProductService = $addProductService;
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

    public function get(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        $products = array_key_exists('id', $args)
            ? $this->repository->find($args['id'])
            : $this->repository->findAll();

        if (empty($products)) {
            return $response->withStatus(404);
        }

        $content = json_encode($products);

        $response = $response->withHeader('Access-Control-Allow-Origin', '*');

        $response->getBody()->write($content);

        return $response;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param $args
     *
     * @return ResponseInterface
     *
     * @see https://github.com/nikic/FastRoute/issues/65
     * nesta rota, enviar apenas em content-type: application/json
     */
    public function put(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {

            $parsedBody = json_decode($request->getBody()->getContents(), true);

            $this->updateService->update($args['id'], $parsedBody);

            return $response->withStatus(204);

        } catch (ApiException $exception) {
            $response = $response->withStatus(404);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }

    public function addProduct(ServerRequestInterface $request, ResponseInterface $response, $args)
    {
        try {

            $idType = $args['id-type'];
            $idProduct = $args['id-product'];

            $this->addProductService->add($idType, $idProduct);

            return $response->withStatus(204);

        } catch (ApiException $exception) {
            $response = $response->withStatus(404);
            $response->getBody()->write($exception->getMessage());

            return $response;
        }
    }
}