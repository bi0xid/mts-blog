<form name="post" action="<?php echo get_permalink(); ?>" method="post" id="post" style="text-align: left;">

<ol>
<?php
for ($i = 0; $i < $num_questions; $i++) {
    echo "<p><li>" . wqp_escape_string($question[$i]) . "</li>\n";
    $order_answers = array_keys($answer[$i]);
    shuffle($order_answers);
    while (!is_null($j = array_pop($order_answers))) {
        echo "    <input type=\"radio\" name=\"answer[{$i}]\" id=\"answer-{$i}-{$j}\" value=\"{$j}\" /> <label for=\"answer-{$i}-{$j}\">" . wqp_escape_string($answer[$i][$j]) . "</label><br />\n";
    }
    echo "</p>\n";
}
?>
</ol>

<p class="submit">
<input type="submit" name="submit" style="font-weight: bold;" value="Submit" />
</p>

<input type="hidden" name="quiz_id" id="quiz_id" value="<?php echo wqp_safe_value($quiz_id); ?>" />

</form>