<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Trip
 * @ORM\Table(name="catalog", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="App\Repository\CatalogRepository")
 */
class Catalog implements \JsonSerializable
{
    use BaseTrait;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @var float
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private $price;

    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'price' => $this->getPrice()
        ];
    }

}