<?php

namespace App\Service;

use App\Entity\Product;
use App\Model\ProductModel;
use App\Service\ExchangeService;
use App\Constant\GeneralConstants;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;

class ProductService {
    
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ExchangeService
     */
    private $exchangeService;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        ExchangeService $exchangeService
    ){
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->exchangeService = $exchangeService;
    }

    public function list(?int $id = null) {
        return (!$id) ? $this->productRepository->findAll(): $this->productRepository->findOneBy(['id'=>$id]);
    }

    public function listFeatured($filters=null) {
        $products = $this->productRepository->findFeatured(GeneralConstants::STATUS_ACTIVE);
        if ($filters) {
            $amout = $this->exchangeService->getExchangeCurrency($filters);
            foreach($products as $p){
                if($filters!=$p->getCurrency()){
                    $p->setPrice(\number_format(($p->getPrice()*$amout), 2, '.', ''));
                    $p->setCurrency($filters);
                }
            }
        }
        return $products;
    }

    public function create(ProductModel $productModel){
        $category = $this->categoryRepository->findOneBy(['id'=>$productModel->getCategory()]);
        $product = (new Product())
                    ->setName($productModel->getName())
                    ->setPrice($productModel->getPrice())
                    ->setCurrency($productModel->getCurrency())
                    ->setFeatured($productModel->getFeatured())
                    ->setCategory($category)
                    ;
        $this->productRepository->persist($product);
        $this->productRepository->flush();
        return $product;
    }

    public function update(Product $product, ProductModel $productModel) {
        $product
            ->setName($productModel->getName())
            ->setPrice($productModel->getPrice())
            ->setCurrency($productModel->getCurrency())
            ->setFeatured($productModel->getFeatured())
        ;
        $category = $this->categoryRepository->findOneBy(['id'=>$productModel->getCategory()]);
        if($category)
            $product->setCategory($category);
        $this->productRepository->flush();
        return $product;
    }

    public function delete(Product $product){
        $this->productRepository->delete($product);
        $this->productRepository->flush();
    }

    public function getProduct(int $id): ?Product
    {
        return $this->productRepository->findOneBy(['id'=>$id]);
    }
}