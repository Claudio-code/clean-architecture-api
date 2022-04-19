<?php

namespace App\Application\Common;

class FindAllPageableInputData
{
    private int $page = 1;
    private int $size = 5;

    public function __construct(?int $page, ?int $size)
    {
        $this->setPage($page);
        $this->setSize($size);
    }

    private function setPage(?int $page): void
    {
        if ($page == null || $page <= 0) {
            return;
        }
        $this->page = $page;
    }

    private function setSize(?int $size): void
    {
        if ($size == null || $size <= 0) {
            return;
        }
        $this->size = $size;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
