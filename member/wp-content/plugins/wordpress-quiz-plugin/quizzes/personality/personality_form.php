<form name="post" action="admin.php?page=edit-quiz&type=personality" method="post" id="post" enctype="multipart/form-data">

<?php
if ( function_exists('wp_nonce_field') ) {
    wp_nonce_field('wqp_personality_form_' . $quiz_id);
}
?>

<div class="wrap">
<?php if (empty($quiz_id)): ?>
<h2>New Quiz</h2>
<?php else: ?>
<h2>Quiz: <?php echo $quiz_id; ?></h2>
<?php endif; ?>

<h3>Title</h3>
<p><input type="text" name="title" id="title" maxsize="255" style="width: 650px;" value="<?php echo wqp_escape_string($title); ?>" /></p>

<h3>Personality Types</h3>
<ol>
<?php
for ($i = 0; $i < $num_personality_types; $i++) {
    echo "<li><input type=\"text\" name=\"personality[{$i}][title]\" id=\"personality[{$i}][title]\" maxsize=\"255\" style=\"width: 450px;\" value=\"" . wqp_escape_string($personality[$i]['title']) . "\" /> <a href=\"#\" onclick=\"wqp_delete_personality_type({$i}); return false;\">Delete Personality Type</a><br />\n";
    if (!empty($personality[$i]['image'])) {
        echo "<p><img src=\"" . $personality[$i]['image'] . "\" /><br />\n";
        echo "<a href=\"#\" onclick=\"wqp_delete_personality_image({$i}); return false;\">Delete Image</a></p>\n";
        echo "<input type=\"hidden\" name=\"personality[" . ($i) . "][image]\" value=\"" . wqp_escape_string($personality[$i]['image']) . "\" />\n";
    } else {
        echo "<input type=\"file\" name=\"personality[{$i}][image]\" id=\"personality[{$i}][image]\" size=\"58\" /><br />\n";
    }
    echo "<textarea name=\"personality[" . ($i) . "][desc]\" rows=\"5\" cols=\"58\" style=\"width: 450px;\">" . wqp_escape_string($personality[$i]['desc']) . "</textarea></li>\n";
}
?>
<li><a href="#" onclick="wqp_add_personality_type(); return false;">Add Personality Type</a></li>
</ol>

<h3>Questions</h3>
<ol>
<?php
for ($i = 0; $i < $num_questions; $i++) {
    echo "<dl>\n";
    echo "<dt><li><input type=\"text\" name=\"question[" . ($i) . "]\" maxsize=\"255\" style=\"width: 450px;\" value=\"" . wqp_escape_string($question[$i]) . "\" /> <a href=\"#\" onclick=\"wqp_delete_question({$i}); return false;\">Delete Question</a></li></dt>\n";
    echo "<dd>\n<ol>\n";
    for ($j = 0; $j < $num_personality_types; $j++) {
        echo "    <li><input type=\"text\" name=\"answer[" . ($i) . "][" . ($j) . "]\" maxsize=\"255\" style=\"width: 300px;\" value=\"" . wqp_escape_string($answer[$i][$j]) . "\" /></li>\n";
    }
    echo "</ol>\n</dd>\n";
    echo "</dl>\n";
}
?>
<li><a href="#" onclick="wqp_add_question(); return false;">Add Question</a></li>
</ol>

<p class="submit">
<input type="submit" name="save_and_continue" value="Save and Continue Editing" />
<input type="submit" name="save" style="font-weight: bold;" value="Save" />
</p>

</div>

<input type="hidden" name="num_personality_types" id="num_personality_types" value="<?php echo $num_personality_types; ?>" />
<input type="hidden" name="num_questions" id="num_questions" value="<?php echo $num_questions; ?>" />
<input type="hidden" name="wqp_action" id="wqp_action" value="" />
<input type="hidden" name="quiz_id" id="quiz_id" value="<?php echo wqp_safe_value($quiz_id); ?>" />
<input type="hidden" name="action" value="wp_handle_upload" />

</form>
<script type="text/javascript">
function wqp_add_personality_type()
{
    document.getElementById('wqp_action').value = 'add_personality_type';
    document.getElementById('post').submit();
}

function wqp_delete_personality_type(row)
{
    document.getElementById('wqp_action').value = 'delete_personality_type:' + row;
    document.getElementById('post').submit();
}

function wqp_delete_personality_image(row)
{
    document.getElementById('wqp_action').value = 'delete_personality_image:' + row;
    document.getElementById('post').submit();
}

function wqp_add_question()
{
    document.getElementById('wqp_action').value = 'add_question';
    document.getElementById('post').submit();
}

function wqp_delete_question(row)
{
    document.getElementById('wqp_action').value = 'delete_question:' + row;
    document.getElementById('post').submit();
}
</script>