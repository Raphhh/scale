<?php
include_once  __DIR__ . '/vendor/autoload.php';

$boardFactory = new \Scale\BoardFactory();
$guitarBoard = $boardFactory->createGuitarBoard();

$notes = $guitarBoard->filterFingerBoards('e', ['T', '2', '3m', '4', '5', '6m', '7m']);

var_dump($notes);
