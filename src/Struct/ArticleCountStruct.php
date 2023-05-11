<?php

namespace NtfxNumberOfItemsInCategory\Struct;

use Shopware\Core\Framework\Struct\Struct;

class ArticleCountStruct extends Struct {

    /**
     * @var int
     */
    private $count;

    public function __construct(int $count) {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getCount(): int {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void {
        $this->count = $count;
    }

}
