<?php
namespace Heln\DicePlayers;

namespace Heln\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $this->app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //
    //     // Use $this->app to access the framework services.
    // }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function initAction() : object
    {
        // Init the game
        $this->app->session->set("dice", new DicePlayers());

        $dice = $this->app->session->get("dice");
        $dice->resetPlayers();
        $dice->setPlayers();

        return $this->app->response->redirect("dice1/play");
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function playActionGet() : object
    {
        $title = "Tärningsspelet 100";

        if (!$this->app->session->has("dice")) {
            $this->app->session->set("dice", new DicePlayers());
        }

        $dice = $this->app->session->get("dice");
        $numbers = $dice->getLastRoll();
        $sum = $dice->sum();
        $dice->addPoints($sum);
        $total = $dice->sumRound();
        $players = $dice->getPlayers();
        $dice->injectData($dice);
        $data = [
            "sum" => $sum ?? null,
            "init" => $init ?? null,
            "numbers" => $numbers ?? null,
            "total" => $total ?? null,
            "players" => $players ?? null,
        ];
        $serie = $dice->getAsText();
        $histogram = [
            "serie" => $serie ?? null,
        ];


        $this->app->page->add("dice1/play", $data);
        $this->app->page->add("dice1/histogram", $histogram);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function playActionPost() : object
    {
        // Set incoming variables
        $request = new \Anax\Request\Request();
        $title = "Tärningsspelet 100";
        $dice = $this->app->session->get("dice");
        $init = $request->getPost("init", null);
        $doRoll = $request->getPost("doRoll", null);
        $doSave = $request->getPost("doSave", null);
        $sum = $dice->sum();
        $numbers = $dice->getLastRoll();
        $total = $dice->sumRound();
        $data = [
            "sum" => $sum ?? null,
            "init" => $init ?? null,
            "cheat" => $cheat ?? null,
            "numbers" => $numbers ?? null,
            "total" => $total ?? null,
        ];

        if ($init) {
            session_destroy();
            return $this->app->response->redirect("dice1/init");
        } elseif ($doRoll) {
            $dice->roll();
            return $this->app->response->redirect("dice1/play");
        } elseif ($doSave) {
            $dice->setScore("Player");
            $dice->resetPoints();
            $players = $dice->getPlayers();
            if ($players["Player"] >= 100) {
                return $this->app->response->redirect("dice1/win");
            } else {
                return $this->app->response->redirect("dice1/computer");
            }
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function computerActionGet() : object
    {
        $title = "Tärningsspelet 100";

        if (!$this->app->session->has("dice")) {
            $this->app->session->set("dice", new DicePlayers());
        }

        $dice = $this->app->session->get("dice");
        $dice->roll();
        $numbers = $dice->getLastRoll();
        $sum = $dice->sum();
        $dice->addPoints($sum);
        $total = $dice->sumRound();
        $players = $dice->getPlayers();
        $data = [
            "sum" => $sum ?? null,
            "init" => $init ?? null,
            "numbers" => $numbers ?? null,
            "total" => $total ?? null,
            "players" => $players ?? null,
        ];
        $dice->injectData($dice);
        $serie = $dice->getAsText();
        $histogram = [
            "serie" => $serie ?? null,
        ];
        $this->app->page->add("dice1/computer", $data);
        $this->app->page->add("dice1/histogram", $histogram);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function computerActionPost() : object
    {
        // Set incoming variables
        $request = new \Anax\Request\Request();
        $title = "Tärningsspelet 100";
        $dice = $this->app->session->get("dice");
        $nextRound = $request->getPost("nextRound", null);
        $init = $request->getPost("init", null);
        $sum = $dice->sum();
        $numbers = $dice->getLastRoll();
        $total = $dice->sumRound();
        $players = $dice->getPlayers();
        $data = [
            "sum" => $sum ?? null,
            "init" => $init ?? null,
            "numbers" => $numbers ?? null,
            "total" => $total ?? null,
        ];

        if ($init) {
            session_destroy();
            return $this->app->response->redirect("dice1/init");
        } elseif ($nextRound) {
            if (($players["Computer"] + $total) < $players["Player"] && $total != 0) {
                return $this->app->response->redirect("dice1/computer");
            } elseif (($players["Computer"] + $total) >= 100) {
                return $this->app->response->redirect("dice1/game-over");
            } else {
                $dice->setScore("Computer");
                $dice->resetPoints();
                $dice->roll();
                return $this->app->response->redirect("dice1/play");
            }
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function winActionGet() : object
    {
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/win");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function winActionPost() : object
    {
        $request = new \Anax\Request\Request();
        $init = $request->getPost("init", null);

        if ($init) {
            session_destroy();
            return $this->app->response->redirect("dice1/init");
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function gameOverActionGet() : object
    {
        $title = "Tärningsspelet 100";

        $this->app->page->add("dice1/game-over");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function gameOverActionPost() : object
    {
        $request = new \Anax\Request\Request();
        $init = $request->getPost("init", null);

        if ($init) {
            session_destroy();
            return $this->app->response->redirect("dice1/init");
        }
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "Index";
    }

    /**
     * This is the debug method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug dice game";
    }
}
