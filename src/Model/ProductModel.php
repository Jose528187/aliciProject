<?php 

namespace App\Model;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProductModel {

    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string
     * @Groups({"create"})
     * @Assert\NotBlank
     */
    private string $name;

    /**
     * @var float
     * @Groups({"create"})
     * @Assert\NotBlank
     */
    private float $price;

    /**
     * @var string
     * @Groups({"create"})
     * @Assert\Type("string")
     * @Assert\NotBlank
     * @Assert\Length(min=3)
     * @Assert\Choice(choices = {"USD", "EUR"}, message = "Choice Value Valid 'USD or EUR'")
     */
    private string $currency;

    /**
     * @var bool
     * @Groups({"create"})
     * @Assert\NotBlank
     */
    private bool $featured = false;

    /**
     * @var int|null
     * @Groups({"create"})
     */
    private ?int $category = null;

    /**
     * Get the value of id
     *
     * @return  int|null
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int|null  $id
     *
     * @return  self
     */ 
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     *
     * @return  self
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get the value of currency
     *
     * @return  string
     */ 
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of currency
     *
     * @param  string  $currency
     *
     * @return  self
     */ 
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of featured
     *
     * @return  bool
     */ 
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set the value of featured
     *
     * @param  bool  $featured
     *
     * @return  self
     */ 
    public function setFeatured(bool $featured)
    {
        $this->featured = $featured;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return  int|null
     */ 
    public function getCategory() : ?int
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param  int|null  $category
     *
     * @return  self
     */ 
    public function setCategory(?int $category)
    {
        $this->category = $category;

        return $this;
    }
}