<?php

namespace App\Services;

class Paginator
{
    /**
     * The total number of items before slicing.
     *
     * @var int
     */
    private $total;

    /**
     * The number of items to be shown per page.
     *
     * @var int
     */
    private $perPage;

    /**
     * The current page being "viewed".
     *
     * @var int
     */
    private $currentPage;

    /**
     * The last available page.
     *
     * @var int
     */
    private $lastPage;

    /**
     * @var array
     */
    private $elements = [];

    /**
     * All of the items being paginated.
     * @var array
     */
    private $items = [];

    /**
     * Paginator constructor.
     *
     * @param array $items
     * @param int $total
     * @param int $currentPage
     * @param int $perPage
     */
    public function __construct(array $items, $total, $currentPage, $perPage)
    {
        $this->items = $items;
        $this->total = $total;
        $this->currentPage = empty($currentPage) ?  1 : $currentPage;
        $this->perPage = $perPage;
        $this->lastPage = max((int) ceil($total / $perPage), 1);
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @return int|mixed
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * @return bool
     */
    public function onFirstPage()
    {
        return $this->getCurrentPage() <= 1;
    }

    /**
     * @return bool
     */
    public function hasMorePages()
    {
        return $this->getCurrentPage() <$this->lastPage();
    }

    /**
     * List of pages nearby begin and end
     *
     * @return array
     */
    public function getElements()
    {
        $max_elements = 10;
        $max = 5;
        $min = 2;
        if ($this->getLastPage() <= $max_elements) {
            for ($i = 1; $i <= $this->getLastPage(); $i++) {
                $this->elements[] = $i;
            }
        } else {

            if ($this->getCurrentPage() <= $max) {
                for ($i = 1; $i <= $max; $i++) {
                    $this->elements[] = $i;
                }
            } else {
                for ($i = 1; $i <= $min; $i++) {
                    $this->elements[] = $i;
                }
            }
            $this->elements[] = '...';

            if ($this->getCurrentPage() > $max && ($this->getCurrentPage() + $max) < $this->getLastPage()) {
                $this->elements[] = $this->getCurrentPage() - 1;
                $this->elements[] = $this->getCurrentPage();
                $this->elements[] = $this->getCurrentPage() + 1;
                $this->elements[] = '...';
            }

            if (($this->getCurrentPage() + $max) < $this->getLastPage()) {
                for ($i = $this->getLastPage() - $min; $i <= $this->getLastPage(); $i++) {
                    $this->elements[] = $i;
                }
            } else {
                for ($i = $this->getLastPage() - $max; $i <= $this->getLastPage(); $i++) {
                    $this->elements[] = $i;
                }
            }
        }
        return $this->elements;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'paginator' => [
                'total' => $this->getTotal(),
                'perPage' => $this->getPerPage(),
                'currentPage' => $this->getCurrentPage(),
                'lastPage' => $this->getLastPage(),
                'elements' => $this->getElements(),
            ],
            'data' => $this->getArrayableData()
        ];
    }

    /**
     * @return array
     */
    protected function getArrayableData()
    {
        $data = [];
        foreach ($this->items as $item) {
            $data[] = $item->toArray();
        }
        return $data;
    }
}
