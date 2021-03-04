<?php

namespace App\Controller;

use App\Entity\Category;
use App\Model\CategoryModel;
use App\Service\CategoryService;
use App\Service\ValidationService;
use App\Service\SerializationService;
use App\Controller\ApiControllerTrait;
use App\Exception\RegisterNotFoundException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    use ApiControllerTrait;

    /**
     * @Route("", methods="GET")
     */
    public function list(
        CategoryService $categoryService
    ): JsonResponse
    {   
        $categories =  $categoryService->list();
        return $this->getOkResponse($categories, ['show']);
    }

    /**
     * @Route("/{id}", methods="GET")
     */
    public function detail(
        $id,
        CategoryService $categoryService
    ): JsonResponse
    {   
        $category =  $categoryService->list($id);
        return $this->getOkResponse($category, ['show']);
    }

     /**
     * @Route("", methods="POST")
     */
    public function create(
        SerializationService $serializationService,
        ValidationService $validationService,
        CategoryService $categoryService
    ): JsonResponse
    {
        $categoryModel = $serializationService->deserializeRequestBody(CategoryModel::class, ['create']);
        $validationService->validateAndThrowExcetion($categoryModel);
        $category = $categoryService->create($categoryModel);
        return $this->getCreatedResponse($category, ['create']);
    }

     /**
     * @Route("/{id}", methods="PUT")
     */
    public function update(
        $id,
        SerializationService $serializationService,
        ValidationService $validationService,
        CategoryService $categoryService
    ): JsonResponse
    {
        $category = $categoryService->getCategory($id);
            
        $categoryModel = $serializationService->deserializeRequestBody(CategoryModel::class, ['create']);
        $validationService->validateAndThrowExcetion($categoryModel);
        $category = $categoryService->update($category, $categoryModel);
        return $this->getOkResponse($category, ['create']);
    }

    /**
     * @Route("/{id}", methods="DELETE")
     */
    public function delete(
        $id, 
        SerializationService $serializationService,
        CategoryService $categoryService
    ): JsonResponse
    {
        $category = $categoryService->getCategory($id);
        $categoryService->delete($category);
        return $this->getNoContentResponse();
    }
}
