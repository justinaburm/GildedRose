<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }


    function update_quality() {
        /** Specific increments or decrements in value */
        $valAgedBrie = +1;
        $valNormal = -1;
        $valConjured = $valNormal * 2;      // "Conjured" items degrade in Quality twice as fast as normal items
        $valPasses = array (                // Array of "Backstage Passes"
            ['day'=>0, 'value'=>0],         // The first array's value is a bit different than others. Because the item's value does not decrease by the value specified, but becomes equal
            ['day'=>5, 'value'=>3],
            ['day'=>10, 'value'=>2]         // If you add more 'rules', please add more rules to the code below as well.
            );

        /** Array of Legendary items to add more specific items if needed */
        $legendaryItems = array (
            'Sulfuras, Hand of Ragnaros'
        );


        //Going through all items in the store at the end od the day
        foreach ( $this->items as $item ) {
            $itemName = $item->name;
            if ( in_array( $itemName, $legendaryItems ) ) {
                // Leave as it is. It's a legendary item.
            }
            else {
                $itemName = ucwords($item->name); // Converts the first character of each word in a string to uppercase to avoid mistakes in not legendary titles
                $this->end_the_day( $item ); // Days make impact to all other items (except legendary ones)

                if ( $itemName == 'Aged Brie' ) {                          // Aged Brie
                    $this->change_quality($item, $valAgedBrie);
                }

                else {
                    $arrItemName = explode(' ', $itemName, 3); // Getting the first two words of itemTitle in array

                    if ($arrItemName[0] == 'Conjured') {                      // Conjured Items
                        $this->change_quality($item, $valConjured);
                    }

                    else if ($arrItemName[0] == 'Backstage' && $arrItemName[1] == 'Passes') {       // Backstage Passes to Concerts
                            if              ( $item->sell_in <  $valPasses[ 0 ]['day'] ) { $item->quality =             $valPasses[ 0 ]['value']; }
                            else if         ( $item->sell_in <= $valPasses[ 1 ]['day'] ) { $this->change_quality($item, $valPasses[ 1 ]['value']); }
                                 else if    ( $item->sell_in <= $valPasses[ 2 ]['day'] ) { $this->change_quality($item, $valPasses[ 2 ]['value']); }
                                      else  { $this->change_quality($item, +1); }

                    } else { $this->change_quality($item, $valNormal); }        // All other Normal Items
                }
            }
        }
    }

    /** Function to decrease the amount of days left to sell for particular item */
    function end_the_day($item){
        $item->sell_in -= 1;
    }

    /** Function to change the quality of an item by the amount given */
    function change_quality($item, $change) {
        if ($change < 0 && $item->sell_in < 0 ) { $change *= 2; }   // Once the sell by date has passed, Quality degrades twice as fast
        $item->quality += $change;

        $temporaryQuality = $item->quality;                         // The Quality of an item is never more than 50
        if ($temporaryQuality < 0) {
            $item->quality = 0;
        } else if ($temporaryQuality > 50) {
            $item->quality = 50;
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

