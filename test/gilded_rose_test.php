<?php

require_once  __DIR__.'/../src/gilded_rose.php';

use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase {

        /** Normal Item */
        function testNormalItem() {
            $items = array(new Item('Simple Item', 10, 20));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Simple Item', 9, 19);
            $this->assertEquals($expectedItem, $items[0], 'Simple item "sell_in" and "quality" should decrease by one.');
        }

        /** Aged Brie Item */
        function testBrieItem() {
            $items = array(new Item('Aged Brie', 2, 0));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Aged Brie', 1, 1);
            $this->assertEquals($expectedItem, $items[0], 'Aged Brie "sell_in" should decrease by one and "quality" increase by one.');
        }

        /** Backstage Passes */
        function testBackstagePasses1() {
            $items = array(new Item('Backstage passes to a TAFKAL80ETC concert', 15, 20));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Backstage passes to a TAFKAL80ETC concert', 14, 21);
            $this->assertEquals($expectedItem, $items[0], 'Backstage passes quality should increase by 1, when it\'s more than 10 days.');
        }
        function testBackstagePasses2() {
            $items = array(new Item('Backstage passes to a TAFKAL80ETC concert', 10, 49));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Backstage passes to a TAFKAL80ETC concert', 9, 51);
            $this->assertEquals($expectedItem, $items[0], 'Backstage passes quality should increase by 2, when it\'s less than 10 && more than 5 days left.');
        }
        function testBackstagePasses3() {
            $items = array(new Item('Backstage passes to a TAFKAL80ETC concert', 5, 49));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Backstage passes to a TAFKAL80ETC concert', 4, 52);
            $this->assertEquals($expectedItem, $items[0], 'Backstage passes quality should increase by 3, when it\'s less than 5 days left.');
        }
        function testBackstagePasses0() {
            $items = array(new Item('Backstage passes to a TAFKAL80ETC concert', 0, 49));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Backstage passes to a TAFKAL80ETC concert', -1, 0);
            $this->assertEquals($expectedItem, $items[0], 'Backstage passes quality should drop to 0 after the concert');
        }

        /** Sulfuras Item */
        function testSulfurasItem() {
            $items = array(new Item('Sulfuras, Hand of Ragnaros', 0, 80));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Sulfuras, Hand of Ragnaros', 0, 80);
            $this->assertEquals($expectedItem, $items[0], '"Sulfuras" item never has to be sold or decreases in Quality');
        }
        function testSulfurasItem2() {
            $items = array(new Item('Sulfuras, Hand of Ragnaros', -1, 80));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Sulfuras, Hand of Ragnaros', -1, 80);
            $this->assertEquals($expectedItem, $items[0], '"Sulfuras" item never has to be sold or decreases in Quality');
        }

        /** Conjured Item */
        function testConjuredItem() {
            $items = array(new Item('Conjured Mana Cake', 3, 6));
            $gildedRose = new GildedRose($items);
            $gildedRose->update_quality();
            $expectedItem = new Item('Conjured Mana Cake', 2, 4);
            $this->assertEquals($expectedItem, $items[0], '"Conjured" items degrade in Quality twice as fast as normal items');
        }

        /** Yet to add:
         *  Once the sell by date has passed, Quality degrades twice as fast
         *  The Quality of an item is never negative
         *  The Quality of an item is never more than 50
         */
}

