<?php
namespace Heln\MyTextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class MyTextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;
    /**
     * @var string $db a sample member variable that gets initialised
     */
    //private $db = "not active";
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
     * @return string as page
     */
    public function indexAction() : object
    {
        $title = "Text filter | oophp";
        $this->app->page->add("my_text_filter/index");
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
     * @return string as page
     */
    public function bbcodeAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/bbcode.txt");
        $output = $filter->parse($text, ["bbcode"]);
        return $output;
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string as page
     */
    public function clickableAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/clickable.txt");
        $output = $filter->parse($text, ["makeClickable"]);
        return $output;
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string as page
     */
    public function markdownAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/sample.md");
        $output = $filter->parse($text, ["markdown"]);
        return $output;
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string as page
     */
    public function nl2brAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/nl2br.txt");
        $text = str_replace('\n', "\n", $text);
        $output = $filter->parse($text, ["nl2br"]);
        return $output;
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string as page
     */
    public function stripAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/clickable.txt");
        $output = $filter->parse($text, ["strip"]);
        return $output;
    }
    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string as page
     */
    public function escAction() : string
    {
        $filter = new MyTextFilter();
        $text = file_get_contents(__DIR__ . "/../../text/esc.txt");
        $output = $filter->parse($text, ["esc"]);
        return $output;
    }
}
