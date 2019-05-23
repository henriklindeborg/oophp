<?php
namespace Heln\Content;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class ContentController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * @var string $db a sample member variable that gets initialised
     */
    private $content;

    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
    public function initialize() : void
    {
        $this->content = new Content($this->app->db);
    }

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return object as page
     */
    public function indexAction() : object
    {
        $title = "Content database | oophp";
        $resultset = $this->content->getAllContent();
        $this->app->page->add("content/header");
        $this->app->page->add("content/show-all", [
            "resultset" => $resultset,
        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Create get
     *
     * @return object as page
     */
    public function createActionGet() : object
    {
        $title = "Create content | oophp";
        $this->app->page->add("content/header");
        $this->app->page->add("content/create");
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Create post
     *
     *
     * @return object AS page
     */
    public function createActionPost() : object
    {
        $title = $this->app->request->getPost("contentTitle");
        $id = $this->content->create($title);
        return $this->app->response->redirect("content/edit/" . $id);
    }

    /**
     * Edit get
     *
     *
     * @return object As page
     */
    public function editActionGet($id) : object
    {
        $title = "Edit | oophp";
        $content = $this->content->getContent($id);
        $this->app->page->add("content/header");
        $this->app->page->add("content/edit", [
            "content" => $content,
        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Edit post
     *
     *
     * @return object AS page
     */
    public function editActionPost($id) : object
    {
        $doDelete = $this->app->request->getPost("doDelete");
        $doSave = $this->app->request->getPost("doSave");
        if (isset($doDelete)) {
            return $this->app->response->redirect("content/delete/" . $id);
        } elseif (isset($doSave)) {
            $title = $this->app->request->getPost("contentTitle");
            $path = $this->app->request->getPost("contentPath");
            $slug = $this->app->request->getPost("contentSlug");
            $data = $this->app->request->getPost("contentData");
            $type = $this->app->request->getPost("contentType");
            $filter = $this->app->request->getPost("contentFilter");
            $publish = $this->app->request->getPost("contentPublish");
            $id = $this->app->request->getPost("contentId");
            if (!$slug) {
                $slug = $this->content->slugify($title);
            }
            $slugCount = $this->content->handleExistingSlug($slug);
            if ($slugCount > 0) {
                $slug = $slug . "-" . $slugCount;
            }
            if (!$path) {
                $path = $slug;
            }
            $pathCount = $this->content->handleExistingPath($path);
            if ($pathCount > 0) {
                $path = $path . "-" . $pathCount;
            }
            $params = [$title, $path, $slug, $data, $type, $filter, $publish, $id];
            try {
                $this->content->updateContent($params);
            } catch (\Exception $e) {
                $this->app->page->add("content/header");
                $this->app->page->add("content/error", [
                    "message" => "Path/slug already exists."
                ]);
                return $this->app->page->render();
            }
        }
        return $this->app->response->redirect("content/admin");
    }

    /**
     * delete get
     *
     *
     * @return object As page
     */
    public function deleteActionGet($id) : object
    {
        $title = "Delete | oophp";
        if (!is_numeric($id)) {
            $this->app->page->add("content/header");
            $this->app->page->add("content/error", [
                "message" => "Not a valid id."
            ]);
            return $this->app->page->render();
        }
        $content = $this->content->getContent($id);
        $this->app->page->add("content/header");
        $this->app->page->add("content/delete", [
            "content" => $content,
        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * Delete post
     *
     *
     * @return object AS page
     */
    public function deleteActionPost($id) : object
    {
        $doDelete = $this->app->request->getPost("doDelete");
        if (isset($doDelete)) {
            $this->content->deleteContent($id);
        }
        return $this->app->response->redirect("content/admin");
    }

    /**
     * Admin get
     *
     *
     * @return object As page
     */
    public function adminActionGet() : object
    {
        $title = "Admin | oophp";
        $content = $this->content->adminContent();
        $this->app->page->add("content/header");
        $this->app->page->add("content/admin", [
            "resultset" => $content,
        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * View pages
     *
     *
     * @return object As page
     */
    public function pagesActionGet($path = null) : object
    {
        $title = "View pages | oophp";
        $this->app->page->add("content/header");
        if ($path) {
            $content = $this->content->pageGetContent($path);
            if (!$content) {
                $title = "404";
                $this->app->page->add("content/404");
            } else {
                $title = $content->title;
                $this->app->page->add("content/page", [
                    "content" => $content,
                ]);
            }
        } else {
            $content = $this->content->pagesContent();
            $this->app->page->add("content/pages", [
                "resultset" => $content,
            ]);
        }
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    /**
     * View blog
     *
     *
     * @return object As page
     */
    public function blogActionGet($path = null) : object
    {
        $title = "View blog | oophp";
        $this->app->page->add("content/header");
        if ($path) {
            $content = $this->content->blogpostGetContent($path);
            if (!$content) {
                $title = "404";
                $this->app->page->add("content/404");
            } else {
                $title = $content->title;
                $this->app->page->add("content/blogpost", [
                    "content" => $content,
                ]);
            }
        } else {
            $content = $this->content->blogContent();
            $this->app->page->add("content/blog", [
                "resultset" => $content,
            ]);
        }
        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
