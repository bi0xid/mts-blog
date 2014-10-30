<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

function wqp_edit_quiz_init()
{
    global $quiz;
    global $quiz_types;

    $quiz_types = WQP_Factory::get_quiz_types();
    if (isset($quiz_types[$_GET['type']])) {
        $quiz_type = $_GET['type'];
    }

    if (!empty($_REQUEST['quiz_id'])) {
        $quiz_id = intval($_REQUEST['quiz_id']);
    }

    if (isset($quiz_type) || isset($quiz_id)) {
        if (empty($quiz_id)) {
            $quiz = WQP_Factory::by_type($quiz_type);
        } else {
            $quiz = WQP_Factory::by_id($quiz_id);

            if (empty($quiz) && !empty($quiz_type)) {
                $quiz = WQP_Factory::by_type($quiz_type);
            }
        }

        if (!empty($_GET['delete'])) {
            check_admin_referer('wordpress-quiz-plugin_deletequiz_' . $quiz->get_quiz_id());
            $quiz->delete();
            $redirect_uri = get_option('siteurl') . '/wp-admin/admin.php?page=wordpress-quiz-plugin';
            wp_redirect($redirect_uri);
            exit;
        } elseif (isset($_POST) && is_array($_POST) && 0 < count($_POST)) {
            $quiz->assign_all($_POST, $_FILES);
            $quiz->process_form();
        }
    } else {
        $quiz = null;
    }
}

function wqp_edit_quiz()
{
    global $quiz;
    global $quiz_types;

    if (isset($quiz)) {
        echo $quiz->fetch_form();
    } else {
        wqp_edit_quiz_select_type($quiz_types);
    }
}

function wqp_edit_quiz_select_type($quiz_types)
{
    if (isset($_GET['type']) && empty($_GET['type'])) {
        echo "<div id=\"message\" class=\"updated fade\"><p><font color=\"red\">Please select a quiz type</font></p></div>\n";
    } elseif (isset($_GET['type']) && !empty($_GET['type'])) {
        echo "<div id=\"message\" class=\"updated fade\"><p><font color=\"red\">You've selected an invalid quiz type</font></p></div>\n";
    }
    ?>
    <div class="wrap">
    <h2>New Quiz</h2>
    <form method="get" action="admin.php">
        <input type="hidden" name="page" value="edit-quiz" />
        <select name="type">
        <option value="">--Select Quiz Type--</option><?php
        foreach ($quiz_types as $qt => $quiz_type) {
            echo "\n        <option value=\"" . wp_specialchars($qt, true) . "\">" . wp_specialchars($quiz_type['typename'], true) . "</option>";
        }
        echo "\n";
        ?>
        </select>
        <p class="submit"><input type="submit" value="Next &raquo;" /></p>
    </form>
    </div>
    <?php
}