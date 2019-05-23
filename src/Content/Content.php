<?php
namespace Heln\Content;

/**
 * Content class
 */
class Content
{
    /**
     * @var string  $table   The table to work on.
     * @var object  $db   The database object.
     * @var object  $filter   The database object.
     */
    private $table;
    private $db;
    private $filter;

    /**
     * Constructor to initiate the object.
     *
     * @param string $table The table to work on with default.
     * @var object  $db   The database object.
     * @var object  $filter   The database object.
     *
     */
    public function __construct(object $db, string $table = "content")
    {
        $this->table = $table;
        $this->db = $db;
        $this->filter = new \Heln\MyTextFilter\MyTextFilter();
    }

    /**
     * Gets all post from the table.
     *
     * @return int
     */
    public function getAllContent()
    {
        $this->db->connect();
        $sql = "SELECT * FROM $this->table;";
        $resultset = $this->db->executeFetchAll($sql);
        return $resultset;
    }

    /**
     * Create a slug of a string, to be used as url.
     *
     * @param string $str the string to format as slug.
     *
     * @return str the formatted slug.
     */
    protected function slugify($str)
    {
        $str = mb_strtolower(trim($str));
        $str = str_replace(['å','ä'], 'a', $str);
        $str = str_replace('ö', 'o', $str);
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = trim(preg_replace('/-+/', '-', $str), '-');
        return $str;
    }

    /**
     * Gets all post from the table.
     *
     * @return int
     */
    public function create($title)
    {
        $this->db->connect();
        $sql = "INSERT INTO $this->table (title) VALUES (?);";
        $this->db->execute($sql, [$title]);
        $id = $this->db->lastInsertId();
        return $id;
    }

    /**
     * Gets all post from the table.
     *
     * @return array
     * @param $id Content id
     */
    public function getContent($id)
    {
        $this->db->connect();
        $sql = "SELECT * FROM $this->table WHERE id = ?;";
        $content = $this->db->executeFetch($sql, [$id]);
        return $content;
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function updateContent($params)
    {
        $this->db->connect();
        $sql = "UPDATE $this->table SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
        $this->db->execute($sql, $params);
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function deleteContent($id)
    {
        $this->db->connect();
        $sql = "UPDATE $this->table SET deleted=NOW() WHERE id = ?;";
        $this->db->execute($sql, [$id]);
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function adminContent()
    {
        $this->db->connect();
        $sql = "SELECT * FROM $this->table;";
        $resultset = $this->db->executeFetchAll($sql);
        return $resultset;
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function pagesContent()
    {
        $this->db->connect();
        $sql = <<<EOD
SELECT
    *,
    CASE
        WHEN (deleted <= NOW()) THEN "isDeleted"
        WHEN (published <= NOW()) THEN "isPublished"
        ELSE "notPublished"
    END AS status
FROM $this->table
WHERE type=?
;
EOD;
        $resultset = $this->db->executeFetchAll($sql, ["page"]);
        return $resultset;
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function pageGetContent($path)
    {
        $this->db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM $this->table
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $resultset = $this->db->executeFetch($sql, [$path, "page"]);
        $resultset->data = $this->filter->parse($resultset->data, explode(',', $resultset->filter));
        return $resultset;
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function blogContent()
    {
        $this->db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM $this->table
WHERE type=?
ORDER BY published DESC
;
EOD;
        $resultset = $this->db->executeFetchAll($sql, ["post"]);
        return $resultset;
    }

    /**
     * Gets all post from the table.
     *
     * @param $params Content information to update
     */
    public function blogpostGetContent($path)
    {
        $this->db->connect();
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
FROM $this->table
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
ORDER BY published DESC
;
EOD;
        $resultset = $this->db->executeFetch($sql, [$path, "post"]);
        $resultset->data = $this->filter->parse($resultset->data, explode(',', $resultset->filter));
        return $resultset;
    }

    /**
     * Gets all post from the table.
     *
     * @param $slug Content information to update
     */
    public function handleExistingSlug($slug)
    {
        $this->db->connect();
        $sql = "SELECT COUNT(slug) AS count FROM $this->table WHERE slug = ?;";
        $resultset = $this->db->executeFetch($sql, [$slug]);
        return $resultset->count;
    }

    /**
     * Gets all post from the table.
     *
     * @param $slug Content information to update
     */
    public function handleExistingPath($path)
    {
        $this->db->connect();
        $sql = "SELECT COUNT(path) AS count FROM $this->table WHERE path = ?;";
        $resultset = $this->db->executeFetch($sql, [$path]);
        return $resultset->count;
    }
}
