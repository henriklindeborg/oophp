<?php
namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<article>

<?php foreach ($resultset as $row) : ?>
<a href="<?= url("content/blog/" . htmlentities($row->slug)) ?>">
    <section>
        <header>
            <h1><?= htmlentities($row->title) ?></h1>
            <p><i>Published: <time datetime="<?= htmlentities($row->published_iso8601) ?>" pubdate><?= htmlentities($row->published) ?></time></i></p>
        </header>
        <?= $row->data ?>
    </section>
</a>
<?php endforeach; ?>

</article>
