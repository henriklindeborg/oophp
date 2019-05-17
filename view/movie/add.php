<?php namespace Anax\View;

?>

<form method="post">
    <fieldset>
    <legend>Add</legend>
    <br>
    <label>Title:</label><br>
    <input type="text" name="title"/>
    <br>
    <label>Year:</label><br>
    <input type="number" name="year"/>
    <br>
    <label>Image:</label><br>
    <input type="text" name="image"/>
    <br>
    <p>
        <input class="buttons_input" type="submit" name="doAdd" value="Add">
    </p>

    <p>
        <a href="../movie">Show all</a>
    </p>
    </fieldset>
</form>
