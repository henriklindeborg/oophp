<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Initialize the game.
 */
$app->router->get("guess/init", function () use ($app) {
    $_SESSION["game"] = new Heln\Guess\Guess();
    $game = $_SESSION["game"];
    $number = $game->number();

    if ($number === null) {
        $game->random();
    }
    // echo "Some debugging information";
    return $app->response->redirect("guess/play");
});

/**
* Play the game and show the status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Guess number";

    if (!isset($_SESSION["game"])) {
        $_SESSION["game"] = new Heln\Guess\Guess();
    }

    $game = $_SESSION["game"];
    $number = $game->number();

    if ($number === null) {
        $game->random();
    }

    $tries = $game->tries();

    $data = [
        "guess" => $guess ?? null,
        "init" => $init ?? null,
        "tries" => $tries,
        "cheat" => $cheat ?? null,
        "number" => $number ?? null,
        "res" => $res ?? null,
    ];

    $app->page->add("guess/play", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game, handle guesses.
 */
$app->router->post("guess/play", function () use ($app) {
    $title = "Guess number";

    // Set incoming variables
    $game = $_SESSION["game"];
    $guess = $_POST["guess"] ?? null;
    $init = $_POST["init"] ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $cheat = $_POST["cheat"] ?? null;
    $res = $game->makeGuess($guess);
    $tries = $game->tries();
    $number = $game->number();
    $data = [
        "guess" => $guess ?? null,
        "init" => $init ?? null,
        "tries" => $tries,
        "cheat" => $cheat ?? null,
        "number" => $number ?? null,
        "res" => $res ?? null,
    ];

    if ($init) {
        session_destroy();
        return $app->response->redirect("guess/init");
    } elseif ($guess == $number && $number != null) {
        $app->page->add("guess/win");
    } elseif ($game->tries() > 0) {
        $app->page->add("guess/play", $data);
    } else {
        $app->page->add("guess/game-over");
    }

    return $app->page->render([
        "title" => $title,
    ]);
});
