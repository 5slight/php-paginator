<?php

namespace Lightscale;

class Paginator {

    private $current = 0;
    private $pageCount = 0;
    private $pages = 0;

    public function __construct($current, $pages, $pageCount) {
        $this->current = $current;
        $this->pageCount = $pageCount;
        $this->pages = $pages;
    }

    public static function fromResultCount($current, $pages, $pageSize, $resultCount) {
        return new Paginator($current, $pages,
                             intval(ceil($resultCount / $pageSize)));
    }

    public function getPageCount() {
        return $this->pageCount;
    }

    public function showPagination() {
        return $this->pageCount > 1;
    }

    public function showNext() {
        return $this->current < $this->pageCount;
    }

    public function showPrev() {
        return $this->current > 1;
    }

    public function getPages() {
        $pages = $this->pages;
        $pc = $this->pageCount;
        $cur = $this->current;

        if($pc < 1) return [];

        if($pc <= $pages) return range(1, $pc);

        $space = $pages - 3;
        $before = intval(ceil($space / 2));
        $after = intval(floor($space / 2));

        $min = max(2, $cur - $before);

        $diff = $cur - $min;
        $after += $before - $diff;
        $before = $diff;

        $max = min($pc - 1, $cur + $after);
        $min -= $after - ($max - $cur);

        $result = [1];
        $result = array_merge($result, range($min, $max));
        $result[] = $pc;

        return $result;
    }

}
