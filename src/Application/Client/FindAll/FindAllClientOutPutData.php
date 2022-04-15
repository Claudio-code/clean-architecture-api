<?php

namespace App\Application\Client\FindAll;

use Knp\Component\Pager\Pagination\PaginationInterface;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema]
class FindAllClientOutPutData implements \JsonSerializable
{
    #[Property(default: 1)]
    private int $page;

    #[Property( default: 12)]
    private int $size;

    #[Property(type: "array", items: new Items(ref: "#/components/schemas/Client"))]
    private array $items;

    public function __construct(PaginationInterface $pagination)
    {
        $this->items = [...$pagination->getItems()];
        $this->page = $pagination->getCurrentPageNumber();
        $this->size = $pagination->getItemNumberPerPage();
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function jsonSerialize(): array
    {
        return [
            'page' => $this->page,
            'size' => $this->size,
            'items' => $this->items,
        ];
    }
}
