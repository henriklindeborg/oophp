<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Tärningsspelet 100</h1>

<p>Datorns tärningar: <?= implode(", ", $numbers) ?>.</p>
<p>Poäng: <?= $sum ?>.</p>
<p>Totalt denna runda: <?= $total ?>.</p>

<form method="post">
    <input type="submit" name="nextRound" value="Nästa runda">
    <input type="submit" name="init" value="Reset">
</form>

<h4>Totalt</h4>
<p>Spelare: <?= $players["Player"] ?></p>
<p>Dator: <?= $players["Computer"] ?></p>
