<form method="post">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-year">
    <p>
        <label>Created between:
        <input type="number" name="year1" min="1900" max="2100"/>
        -
        <input type="number" name="year2" min="1900" max="2100"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="../movie">Show all</a></p>
    </fieldset>
</form>
