<?php

// require files
require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";
require __DIR__ . "/view/header.php";



// Set incoming variables
// $number = $_POST["number"] ?? null;
// $tries = $_POST["tries"] ?? null;
$guess = $_POST["guess"] ?? null;
$init = $_POST["init"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;
$cheat = $_POST["cheat"] ?? null;


if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

$game = $_SESSION["game"];

$number = $game->number();
$tries = $game->tries();

if ($number === null) {
    $game->random();
} elseif ($init) {
    session_destroy();
}

if ($guess == $number && $number != null) {
    require __DIR__ . "/view/win.php";
} elseif ($game->tries() > 0) {
    require __DIR__ . "/view/guess.php";
} else {
    require __DIR__ . "/view/game_over.php";
}
