<?php

namespace App\Controller;

use App\Model\ProductModel;
use App\Service\ProductService;
use App\Service\ValidationService;
use App\Service\SerializationService;
use App\Controller\ApiControllerTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    use ApiControllerTrait;

    /**
     * @Route("", methods="GET")
     */
    public function list(
        ProductService $productService
    ): JsonResponse
    {
        $products =  $productService->list();
        return $this->getOkResponse($products, ['product']);
    }

    /**
     * @Route("/featured", methods="GET")
     */
    public function featured(
        ProductService $productService,
        Request $request
    ): JsonResponse
    {   
        $filters = $request->query->get('currency', null);
        $product =  $productService->listFeatured($filters);
        return $this->getOkResponse($product, ['product']);
    }

    /**
     * @Route("/{id}", methods="GET")
     */
    public function detail(
        $id,
        ProductService $productService
    ): JsonResponse
    {   
        $product =  $productService->list($id);
        return $this->getOkResponse($product, ['product']);
    }

    /**
     * @Route("", methods="POST")
     */
    public function create(
        SerializationService $serializationService,
        ValidationService $validationService,
        ProductService $productService
    ): JsonResponse
    {
        $productModel = $serializationService->deserializeRequestBody(ProductModel::class, ['create']);
        $validationService->validateAndThrowExcetion($productModel);
        $product = $productService->create($productModel);
        return $this->getCreatedResponse($product, ['create']);
    }

    

    /**
     * @Route("/{id}", methods="PUT")
     */
    public function update(
        $id,
        SerializationService $serializationService,
        ValidationService $validationService,
        ProductService $productService
    ): JsonResponse
    {
        $product = $productService->getProduct($id);
        $productModel = $serializationService->deserializeRequestBody(ProductModel::class, ['create']);
        $validationService->validateAndThrowExcetion($productModel);
        $product = $productService->update($product, $productModel);
        return $this->getOkResponse($product, ['product']);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function delete(
        $id, 
        SerializationService $serializationService,
        ProductService $productService
    ): JsonResponse
    {
        $product = $productService->getProduct($id);
        $productService->delete($product);
        return $this->getOkResponse(null);
    }

    
}
