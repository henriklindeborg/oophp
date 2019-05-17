<?php
namespace Heln\Movie;

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
class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
    // private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object
     */
    public function indexAction() : object
    {
        $title = "Movie database | oophp";

        // $title = "Show all movies";
        // $view[] = "view/show-all.php";
        // $sql = "SELECT * FROM movie;";
        // $resultset = $db->executeFetchAll($sql);

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/header");
        $this->app->page->add("movie/index", [
            "resultset" => $res,
        ]);

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
    public function searchTitleActionGet() : object
    {
        $title = "Search movies | oophp";
        $searchTitle = $this->app->session->get("searchTitle");
        $resultset = $this->app->session->get("resultset");
        $this->app->session->set("resultset", null);
        $this->app->page->add("movie/search-title", [
            "resultset" => $resultset,
            "searchTitle" => $searchTitle,
        ]);
        $this->app->page->add("movie/search-result", [
            "resultset" => $resultset,
        ]);
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
    public function searchTitleActionPost() : object
    {
        $this->app->db->connect();
        $searchTitle = $this->app->request->getPost("searchTitle");
        $sql = "SELECT * FROM movie WHERE title LIKE ?;";
        $resultset = $this->app->db->executeFetchAll($sql, ["%" . $searchTitle . "%"]);
        $this->app->session->set("resultset", $resultset);
        return $this->app->response->redirect("movie/search-title");
    }

    /**
    * This is the index method action, it handles:
    * ANY METHOD mountpoint
    * ANY METHOD mountpoint/
    * ANY METHOD mountpoint/index
    *
    * @return object
    */
    public function searchYearActionGet() : object
    {
        $title = "Search movies | oophp";
        $resultset = $this->app->session->get("resultset");
        $this->app->session->set("resultset", null);
        $this->app->page->add("movie/search-year", [
            "resultset" => $resultset,
        ]);
        $this->app->page->add("movie/search-result", [
            "resultset" => $resultset,
        ]);
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
    public function searchYearActionPost() : object
    {
        $this->app->db->connect();
        $year1 = $this->app->request->getPost("year1");
        $year2 = $this->app->request->getPost("year2");
        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year2]);
        }
        $this->app->session->set("resultset", $resultset);
        return $this->app->response->redirect("movie/search-year");
    }

    /**
    * This is the index method action, it handles:
    * ANY METHOD mountpoint
    * ANY METHOD mountpoint/
    * ANY METHOD mountpoint/index
    *
    * @return object
    */
    public function editActionGet() : object
    {
        $title = "Search movies | oophp";
        $id = $this->app->request->getGet("id");
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $this->app->db->connect();
        $resultset = $this->app->db->executeFetch($sql, [$id]);
        $this->app->page->add("movie/movie-edit", [
            "movie" => $resultset,
        ]);
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
    public function editActionPost() : object
    {
        $this->app->db->connect();
        $id = $this->app->request->getPost("movieId");
        $image = $this->app->request->getPost("movieImage");
        $title = $this->app->request->getPost("movieTitle");
        $year = $this->app->request->getPost("movieYear");
        $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
        $this->app->db->execute($sql, [$title, $year, $image, $id]);

        return $this->app->response->redirect("movie");
    }

    /**
    * This is the index method action, it handles:
    * ANY METHOD mountpoint
    * ANY METHOD mountpoint/
    * ANY METHOD mountpoint/index
    *
    * @return object
    */
    public function deleteActionGet() : object
    {
        $title = "Delete movies | oophp";
        $id = $this->app->request->getGet("id");
        $sql = "SELECT * FROM movie WHERE id = ?;";
        $this->app->db->connect();
        $resultset = $this->app->db->executeFetch($sql, [$id]);
        $this->app->page->add("movie/movie-delete", [
            "movie" => $resultset,
        ]);
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
    public function deleteActionPost() : object
    {
        $this->app->db->connect();
        $id = $this->app->request->getPost("movieId");
        $sql = "DELETE FROM movie WHERE id = ?;";
        $this->app->db->execute($sql, [$id]);

        return $this->app->response->redirect("movie");
    }

    /**
    * This is the index method action, it handles:
    * ANY METHOD mountpoint
    * ANY METHOD mountpoint/
    * ANY METHOD mountpoint/index
    *
    * @return object
    */
    public function addActionGet() : object
    {
        $title = "Add movies | oophp";
        $this->app->page->add("movie/add");
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
    public function addActionPost() : object
    {
        $this->app->db->connect();
        $image = $this->app->request->getPost("image");
        $title = $this->app->request->getPost("title");
        $year = $this->app->request->getPost("year");
        $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
        $this->app->db->execute($sql, [$title, $year, $image]);

        return $this->app->response->redirect("movie");
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
