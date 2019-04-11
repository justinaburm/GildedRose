<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    /** Function to decrease the amount of days left to sell for particular item */
    function end_the_day($item){
//        if ($item->sell_in == 0) return;
        $item->sell_in -= 1;
    }

    /** Function to change the quality of an item by the amount given */
    function change_quality($item, $change) {
        $item->quality += $change;
    }

    function update_quality() {

        foreach ($this->items as $item) {
            if ($item->name == 'Sulfuras, Hand of Ragnaros') {
                // Leave as it is. It's a legendary item.
            }
            else {
                $this->end_the_day($item); // Days make impact to all other items (except legendary ones)

                if ($item->name == 'Aged Brie') {
                    $this->change_quality($item, +1);
                }

                else if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if              ( $item->sell_in < 0 ) { $item->quality = 0; }
                    else if         ( $item->sell_in <= 5 ) { $this->change_quality($item, +3); }
                         else if    ( $item->sell_in <= 10 ) { $this->change_quality($item, +2); }
                              else  { $this->change_quality($item, +1); }
                }

                else if ($item->name == 'Conjured Mana Cake') {
                    $this->change_quality($item, -2);
                }

                else {
                    $this->change_quality($item, -1);
                }
            }

        }
    }
}

// Do not change anything here because of Goblin !!
class Item {

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality) {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString() {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}

