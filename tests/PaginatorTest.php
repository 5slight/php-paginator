<?php

use PHPUnit\Framework\TestCase;

use Lightscale\Paginator;

final class PaginatorTest extends TestCase {

    public function testInitaliation() {
        $p = new Paginator(4, 10, 10);
        $this->assertInstanceOf(Paginator::class, $p);

        $p = Paginator::fromResultCount(2, 10, 10, 100);
        $this->assertInstanceOf(Paginator::class, $p);
    }

    public function testGetPageCount() {
        $p = new Paginator(1, 10, 10);
        $pc = $p->getPageCount();
        $this->assertIsInt($pc);
        $this->assertEquals(10, $pc);

        $p = Paginator::fromResultCount(1, 10, 10, 100);
        $pc = $p->getPageCount();
        $this->assertIsInt($pc);
        $this->assertEquals(10, $pc);

        $p = Paginator::fromResultCount(1, 10, 10, 101);
        $pc = $p->getPageCount();
        $this->assertIsInt($pc);
        $this->assertEquals(11, $pc);
    }

    public function testShowNext() {
        $p = new Paginator(4, 10, 10);
        $this->assertTrue($p->showNext());

        $p = new Paginator(0, 10, 10);
        $this->assertTrue($p->showNext());

        $p = new Paginator(10, 10, 10);
        $this->assertFalse($p->showNext());

        $p = new Paginator(11, 10, 10);
        $this->assertFalse($p->showNext());

        $p = new Paginator(9, 10, 10);
        $this->assertTrue($p->showNext());
    }

    public function testShowPrev() {
        $p = new Paginator(4, 10, 10);
        $this->assertTrue($p->showPrev());

        $p = new Paginator(0, 10, 10);
        $this->assertFalse($p->showPrev());

        $p = new Paginator(1, 10, 10);
        $this->assertFalse($p->showPrev());

        $p = new Paginator(10, 10, 10);
        $this->assertTrue($p->showPrev());
    }

    public function testShowPagination() {
        $p = new Paginator(1, 10, 1);
        $this->assertFalse($p->showPagination());

        $p = new Paginator(1, 10, 0);
        $this->assertFalse($p->showPagination());


        $p = new Paginator(1, 10, 2);
        $this->assertTrue($p->showPagination());
    }

    public function testGettingPages() {
        $p = new Paginator(1, 10, 0);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEmpty($pages);

        $p = new Paginator(1, 10, 1);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals([1], $pages);

        $p = new Paginator(1, 10, 9);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals(range(1, 9), $pages);

        $p = new Paginator(1, 10, 10);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals(range(1, 10), $pages);

        $p = new Paginator(7, 10, 15);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals([1, 3, 4, 5, 6, 7, 8, 9, 10, 15], $pages);

        $p = new Paginator(8, 10, 11);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals([1, 3, 4, 5, 6, 7, 8, 9, 10, 11], $pages);

        $p = new Paginator(3, 10, 11);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9, 11], $pages);

        $p = new Paginator(25, 15, 60);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals(
            [1, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 60],
            $pages
        );

        $p = new Paginator(55, 15, 60);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals(
            [1, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60],
            $pages
        );

        $p = new Paginator(5, 15, 60);
        $pages = $p->getPages();
        $this->assertIsArray($pages);
        $this->assertEquals(
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 60],
            $pages
        );
    }

}
