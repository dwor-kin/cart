<?php
namespace App\Builder;

use App\Entity\Catalog;

class CatalogBuilder
{
    public function build(string $title, float $price): Catalog
    {
        $catalog = new Catalog();
        $catalog->setPrice($price);
        $catalog->setTitle($title);

        return $catalog;
    }
}