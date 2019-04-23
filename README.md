# Scale

Give all the notes of a specific scale and their position for the board of an instrument.

## GuitarBoard

### Usage

```php
<?php
$boardFactory = new \Scale\BoardFactory();
$guitarBoard = $boardFactory->createGuitarBoard();

$notes = $guitarBoard->filterFingerBoards('e', ['T', '2', '3m', '4', '5', '6m', '7m']);

var_dump($notes); 
/*
[
    //first string (e)
    0 => [
        [
            'position' => 0,
            'interval' => 'T',
            'note' => 'e',
        ],
        [
            'position' => 2,
            'interval' => '2',
            'note' => 'f♯',
        ],
        [
            'position' => 3,
            'interval' => '3m',
            'note' => 'g',
        ],
        ...
    ],
 
    // second string (b)
    1 => [
        [
            'position' => 0,
            'interval' => '5',
            'note' => 'b',
        ],
        [
            'position' => 1,
            'interval' => '6m',
            'note' => 'c',
        ],
        [
            'position' => 3,
            'interval' => '7m',
            'note' => 'd',
        ],
        [
            'position' => 5,
            'interval' => 'T',
            'note' => 'e',
        ],
        ...
    ],
    ...
*/

```