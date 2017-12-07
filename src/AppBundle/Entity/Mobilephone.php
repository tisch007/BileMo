<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
/**
 * Mobilephone
 *
 * @ORM\Table(name="Mobilephone")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MobilephoneRepository")
 *
 * @Serializer\ExclusionPolicy("all")
 *
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_mobilephone_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 *@Hateoas\Relation(
 *      "mobilephone_list",
 *      href = @Hateoas\Route(
 *          "app_mobilephones_list",
 *          absolute = true
 *      )
 * )
 */
class Mobilephone
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=30)
     *
     * @Serializer\Expose
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=50)
     *
     *
     * @Serializer\Expose
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     *
     * @Serializer\Expose
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=30)
     *
     * @Serializer\Expose
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="capacity", type="string", length=30)
     *
     * @Serializer\Expose
     */
    private $capacity;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     *
     * @Serializer\Expose
     */
    private $price;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set brand
     *
     * @param string $brand
     *
     * @return Mobilephone
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Mobilephone
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Mobilephone
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Mobilephone
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set capacity
     *
     * @param string $capacity
     *
     * @return Mobilephone
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }

    /**
     * Get capacity
     *
     * @return string
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Mobilephone
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}
