<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Guess my number</h1>

<p>Guess a number between 1 and 100. You have <?= $tries ?> tries left.</p>

<form method="post">
    <input type="text" name="guess">
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="hidden" name="tries" value="<?= $tries ?>">
    <input type="submit" name="doGuess" value="Make guess">
    <input type="submit" name="init" value="Reset">
    <input type="submit" name="cheat" value="Cheat">
</form>

<?php if ($guess) : ?>
    <p>Your guess is <?= $guess ?> and it is <?= $res ?>.</p>
<?php endif; ?>

<?php if ($cheat) : ?>
    <p>The number is <?= $number ?>.</p>
<?php endif; ?>
