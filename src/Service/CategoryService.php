<?php

namespace App\Service;

use App\Entity\Category;
use App\Model\CategoryModel;
use App\Repository\CategoryRepository;

class CategoryService {
    
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository
    ){
        $this->categoryRepository = $categoryRepository;
    }

    public function list(?int $id = null) {
        return (!$id) ? $this->categoryRepository->findAll(): $this->categoryRepository->find($id);
    }

    public function create(CategoryModel $categoryModel) {
        $category = (new Category())
                    ->setName($categoryModel->getName())
                    ->setDescription($categoryModel->getDescription())
                    ;
        $this->categoryRepository->persist($category);
        $this->categoryRepository->flush($category);
        return $category;
    }

    public function update(Category $category, CategoryModel $categoryModel) {
        $category
            ->setName($categoryModel->getName())
            ->setDescription($categoryModel->getDescription())
        ;
        $this->categoryRepository->flush($category);
        return $category;
    }

    public function delete(Category $category){
        $this->categoryRepository->delete($category);
        $this->categoryRepository->flush();
    }

    public function getCategory(int $id): ?Category
    {
        return $this->categoryRepository->find($id);
    }

}