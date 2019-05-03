<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Initialize the game.
 */
$app->router->get("dice/init", function () use ($app) {
    $_SESSION["dice"] = new Heln\Dice\DicePlayers();

    $dice = $_SESSION["dice"];
    $dice->resetPlayers();
    $dice->setPlayers();
    // $number = $dice->number();
    //
    // if ($number === null) {
    //     $dice->random();
    // }
    // echo "Some debugging information";
    return $app->response->redirect("dice/play");
});

/**
* Play the game and show the status.
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Tärningsspelet 100";

    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Heln\Dice\DicePlayers();
    }

    $dice = $_SESSION["dice"];
    $numbers = $dice->getLastRoll();
    $sum = $dice->sum();
    $dice->addPoints($sum);
    $total = $dice->sumRound();


    $players = $dice->getPlayers();


    // if ($number === null) {
    //     $dice->random();
    // }

    // $tries = $dice->tries();

    $data = [
        "sum" => $sum ?? null,
        "init" => $init ?? null,
        "numbers" => $numbers ?? null,
        "res" => $res ?? null,
        "total" => $total ?? null,
        "players" => $players ?? null,
    ];

    $app->page->add("dice/play", $data);
    // $app->page->add("dice/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play the game, handle guesses.
 */
$app->router->post("dice/play", function () use ($app) {
    $title = "Tärningsspelet 100";

    // Set incoming variables
    $dice = $_SESSION["dice"];
    $init = $_POST["init"] ?? null;
    $doRoll = $_POST["doRoll"] ?? null;
    $doSave = $_POST["doSave"] ?? null;
    // $res = $dice->makeGuess($guess);
    // $tries = $dice->tries();
    $sum = $dice->sum();
    $numbers = $dice->getLastRoll();
    $total = $dice->sumRound();
    $data = [
        "sum" => $sum ?? null,
        "init" => $init ?? null,
        "cheat" => $cheat ?? null,
        "numbers" => $numbers ?? null,
        "res" => $res ?? null,
        "total" => $total ?? null,
    ];

    if ($init) {
        session_destroy();
        return $app->response->redirect("dice/init");
    } elseif ($doRoll) {
        $dice->roll();
        return $app->response->redirect("dice/play");
        // $app->page->add("dice/play", $data);
    } elseif ($doSave) {
        $dice->setScore("Player");
        $dice->resetPoints();
        $players = $dice->getPlayers();
        if ($players["Player"] >= 100) {
            return $app->response->redirect("dice/win");
        } else {
            return $app->response->redirect("dice/computer");
        }
    }
});


/**
* Play the game and show the status.
 */
$app->router->get("dice/computer", function () use ($app) {
    $title = "Tärningsspelet 100";

    if (!isset($_SESSION["dice"])) {
        $_SESSION["dice"] = new Heln\Dice\DicePlayers();
    }

    $dice = $_SESSION["dice"];
    $dice->roll();
    $numbers = $dice->getLastRoll();
    $sum = $dice->sum();
    $dice->addPoints($sum);
    $total = $dice->sumRound();


    $players = $dice->getPlayers();


    // if ($number === null) {
    //     $dice->random();
    // }

    // $tries = $dice->tries();

    $data = [
        "sum" => $sum ?? null,
        "init" => $init ?? null,
        "numbers" => $numbers ?? null,
        "res" => $res ?? null,
        "total" => $total ?? null,
        "players" => $players ?? null,
    ];

    $app->page->add("dice/computer", $data);
    // $app->page->add("dice/debug", $data);

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
* Play the game, handle guesses.
 */
$app->router->post("dice/computer", function () use ($app) {
    $title = "Tärningsspelet 100";

    // Set incoming variables
    $dice = $_SESSION["dice"];
    $nextRound = $_POST["nextRound"] ?? null;
    $init = $_POST["init"] ?? null;
    // $res = $dice->makeGuess($guess);
    // $tries = $dice->tries();
    $sum = $dice->sum();
    $numbers = $dice->getLastRoll();
    $total = $dice->sumRound();
    $data = [
        "sum" => $sum ?? null,
        "init" => $init ?? null,
        "numbers" => $numbers ?? null,
        "res" => $res ?? null,
        "total" => $total ?? null,
    ];

    if ($init) {
        session_destroy();
        return $app->response->redirect("dice/init");
    } elseif ($nextRound) {
        $dice->setScore("Computer");
        $dice->resetPoints();
        $dice->roll();
        if ($players["Computer"] >= 100) {
            return $app->response->redirect("dice/game-over");
        } else {
            return $app->response->redirect("dice/play");
        }
    }
});


/**
* Show who won.
 */
$app->router->get("dice/win", function () use ($app) {
    $title = "Tärningsspelet 100";

    $app->page->add("dice/win");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play again.
 */
$app->router->post("dice/win", function () use ($app) {
    $init = $_POST["init"] ?? null;

    if ($init) {
        session_destroy();
        return $app->response->redirect("dice/init");
    }
});

/**
* Show who won (computer).
 */
$app->router->get("dice/game-over", function () use ($app) {
    $title = "Tärningsspelet 100";

    $app->page->add("dice/game-over");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
* Play again.
 */
$app->router->post("dice/game-over", function () use ($app) {
    $init = $_POST["init"] ?? null;

    if ($init) {
        session_destroy();
        return $app->response->redirect("dice/init");
    }
});
