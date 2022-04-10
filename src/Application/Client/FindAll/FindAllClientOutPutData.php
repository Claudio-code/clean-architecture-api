<?php

namespace App\Application\Client\FindAll;

use Knp\Component\Pager\Pagination\PaginationInterface;

class FindAllClientOutPutData implements \JsonSerializable
{
    private int $page;
    private int $size;
    private iterable $items;

    public function __construct(PaginationInterface $pagination)
    {
        $this->items = $pagination->getItems();
        $this->page = $pagination->getCurrentPageNumber();
        $this->size = $pagination->getItemNumberPerPage();
    }

    public function jsonSerialize(): mixed
    {
        return [
            'page' => $this->page,
            'size' => $this->size,
            'items' => $this->items,
        ];
    }
}
