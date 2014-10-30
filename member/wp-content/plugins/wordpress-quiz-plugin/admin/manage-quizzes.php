<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

function wqp_manage_quizzes_init()
{
    wp_enqueue_script('listman');
}

function wqp_manage_quizzes()
{
    global $wpdb;

    $options = array();
    $options['search'] = wqp_safe_value($_GET['search']);
    $options['type']   = wqp_safe_value($_GET['type']);

    // Only allow valid quiz types
    $quiz_types = WQP_Factory::get_quiz_types();
    if (empty($quiz_types[$options['type']])) {
        $options['type'] = '';
    }

    $where = array();

    if (!empty($options['search'])) {
        $where[] = "quiz_title LIKE '" . $wpdb->escape('%' . $options['search'] . '%') . "'";
    }

    if (!empty($options['type'])) {
        $where[] = "quiz_type = '" . $wpdb->escape($options['type']) . "'";
    }

    $sql = "SELECT
                *
            FROM
                " . $wpdb->wqp_quizzes . "
            " . (0 < count($where) ? 'WHERE ' . implode(' AND ', $where) : '') . "
            ORDER BY
                quiz_title";

    $quizzes = $wpdb->get_results($sql);

    wqp_display_quizzes($quizzes, $options);
}

function wqp_display_quizzes($quizzes, $options = null)
{
    $options = wqp_safe_array($options);
    $options['search']     = wqp_safe_value($options['search']);
    $options['type']       = strtolower(wqp_safe_value($options['type']));
    $options['head_title'] = wqp_safe_value($options['head_title']);

    $quiz_types = WQP_Factory::get_quiz_types();

    if (empty($options['head_title'])) {
        if (isset($quiz_types[$options['type']])) {
            $options['head_title'] = $quiz_types[$options['type']]['typename'] . ' Quizzes';
        } else {
            $options['head_title'] = 'Quizzes';
        }

        if (!empty($options['search'])) {
            $options['head_title'] .= " matching &quot;" . wqp_escape_string($options['search']) . "&quot;";
        }
    }
    ?>
    <div class="wrap">

    <h2><?php echo $options['head_title']; ?></h2>

    <p>To post a quiz copy the ID (ex: [quiz=1]) and paste it into the title and body of a post or page.<br />
    The ID will get replaced by the quiz title in the post/page title and the quiz itself in the body.</p>

    <form name="searchform" id="searchform" action="admin.php" method="get">
        <input type="hidden" name="page" value="wordpress-quiz-plugin" />
        <fieldset><legend>Search terms&hellip;</legend>
        <input type="text" name="search" id="search" value="<?php echo wqp_escape_string($options['search']); ?>" size="17" />
        </fieldset>

        <fieldset><legend>Type&hellip;</legend>
        <select name='type' id='type' class='postform'>
        <option value='0'>All</option><?php
        foreach ($quiz_types as $qt => $quiz_type) {
            echo "\n        <option value=\"" . wp_specialchars($qt, true) . "\"" . (0 == strcmp($qt, $options['type']) ? ' selected="selected"' : '') . ">" . wp_specialchars($quiz_type['typename'], true) . "</option>";
        }
        echo "\n";
        ?>
        </select>
        </fieldset>
        <input type="submit" id="post-query-submit" value="Filter &#187;" class="button" />
    </form>

    <br style="clear:both;" />

    <table class="widefat">
        <thead>
        <tr>

        <th scope="col"><div style="text-align: center">ID</div></th>
        <th scope="col">Title</th>
        <th scope="col">Type</th>
        <th scope="col"></th>
        <th scope="col"></th>

        </tr>
        </thead>
        <tbody id="the-list">
        <?php
        $alt = true;
        foreach ($quizzes as $quiz) {
            $link      = "admin.php?page=edit-quiz&quiz_id=" . $quiz->quiz_id . "&delete=1";
            $nonce_key = "wordpress-quiz-plugin_deletequiz_";
            $link      = (function_exists('wp_nonce_url') ? wp_nonce_url($link, $nonce_key . $quiz->quiz_id) : $link);

            echo "<tr id=\"quiz-" . $quiz->quiz_id . "\"" . ($alt ? ' class="alternate"' : '') . ">\n";
            echo "<th scope=\"row\" style=\"text-align: center\" width=\"100\">[quiz=" . $quiz->quiz_id . "]</th>\n";
            echo "<td>" . wp_specialchars($quiz->quiz_title) . "</td>\n";
            echo "<td width=\"200\">" . wp_specialchars(ucwords($quiz->quiz_type)) . "</td>\n";
            echo "<td width=\"100\"><a href=\"admin.php?page=edit-quiz&quiz_id=" . $quiz->quiz_id . "\" class=\"edit\">Edit</a></td>\n"; //function deleteSomething( what, id, message, obj ) {
            echo "<td width=\"100\"><a href=\"" . $link . "\" class=\"delete\" onclick=\"return deleteSomething( 'quiz', " . $quiz->quiz_id . ", 'You are about to delete this quiz \'" . wp_specialchars($quiz->quiz_title) . "\'.\\n\'OK\' to delete, \'Cancel\' to stop.' );\">Delete</a></td>\n";
            echo "</tr>\n";

            $alt = !$alt;
        }
        ?>
        </tbody>
    </table>

    </div>
    <?php
}