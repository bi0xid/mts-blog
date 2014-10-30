<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

class WQP_Factory
{
    function add_quiz_type($type, $typename, $classname, $classpath)
    {
        if (!isset($GLOBALS['WQP_Factory']['QUIZ_TYPES']) || !is_array($GLOBALS['WQP_Factory']['QUIZ_TYPES'])) {
            $GLOBALS['WQP_Factory']['QUIZ_TYPES'] = array();
        }

        $GLOBALS['WQP_Factory']['QUIZ_TYPES'][$type] = array(
            'type'      => $type,
            'typename'  => $typename,
            'classname' => $classname,
            'classpath' => $classpath
        );
    }

    function get_quiz_types()
    {
        if (!isset($GLOBALS['WQP_Factory']['QUIZ_TYPES']) || !is_array($GLOBALS['WQP_Factory']['QUIZ_TYPES'])) {
            $GLOBALS['WQP_Factory']['QUIZ_TYPES'] = array();
        }

        return $GLOBALS['WQP_Factory']['QUIZ_TYPES'];
    }

    function by_id($quiz_id)
    {
        require_once dirname(__FILE__) . "/wqp-quiz.php";

        global $wpdb;

        $quiz_id = intval($quiz_id);

        $sql = "SELECT
                    *
                FROM
                    " . $wpdb->wqp_quizzes . "
                WHERE
                    quiz_id = {$quiz_id}
                LIMIT 1";

        $row = $wpdb->get_row($sql);

        $quiz_type = strtolower($row->quiz_type);

        $quiz_types = WQP_Factory::get_quiz_types();
        if (empty($quiz_type)) {
            return null;
        } elseif (!isset($quiz_types[$quiz_type])) {
            die("Invalid Quiz Type: {$quiz_type}");
        }

        $quiz_class = $quiz_types[$quiz_type]['classname'];
        $quiz_file  = $quiz_types[$quiz_type]['classpath'];
        require_once $quiz_file;
        $quiz = new $quiz_class($row->quiz_id);

        $data = unserialize($row->quiz_data);
        $quiz->assign_all($data);

        return $quiz;
    }

    function by_type($quiz_type)
    {
        require_once dirname(__FILE__) . "/wqp-quiz.php";

        $quiz_type = strtolower($quiz_type);

        $quiz_types = WQP_Factory::get_quiz_types();
        if (!isset($quiz_types[$quiz_type])) {
            die("Invalid Quiz Type: {$quiz_type}");
        }

        $quiz_class = $quiz_types[$quiz_type]['classname'];
        $quiz_file  = $quiz_types[$quiz_type]['classpath'];
        require_once $quiz_file;
        $quiz = new $quiz_class();

        $quiz->assign_defaults();

        return $quiz;
    }
}

if (!function_exists('scandir')) {
    function scandir($directory, $sorting_order = 0)
    {
        if (!is_string($directory)) {
            user_error('scandir() expects parameter 1 to be string, ' .
                gettype($directory) . ' given', E_USER_WARNING);
            return;
        }

        if (!is_int($sorting_order) && !is_bool($sorting_order)) {
            user_error('scandir() expects parameter 2 to be long, ' .
                gettype($sorting_order) . ' given', E_USER_WARNING);
            return;
        }

        if (!is_dir($directory) || (false === $fh = @opendir($directory))) {
            user_error('scandir() failed to open dir: Invalid argument', E_USER_WARNING);
            return false;
        }

        $files = array ();
        while (false !== ($filename = readdir($fh))) {
            $files[] = $filename;
        }

        closedir($fh);

        if ($sorting_order == 1) {
            rsort($files);
        } else {
            sort($files);
        }

        return $files;
    }
}

// Escape output string
function wqp_escape_string($value)
{
    $escaped = $value;
    $escaped = wp_specialchars($escaped, true);

    return $escaped;
}

// Filter input string
function wqp_filter_string($value)
{
    $filtered = $value;
    $filtered = strip_tags($filtered);
    $filtered = stripslashes($filtered);

    return $filtered;
}

function wqp_safe_array(&$value, $default_value = array())
{
    if (!isset($default_value) || !is_array($default_value)) {
        $default_value = array();
    }

    return (isset($value) && is_array($value) ? $value : $default_value);
}

function wqp_safe_value(&$value, $default_value = '')
{
    return (isset($value) ? $value : $default_value);
}

function wqp_the_content($content)
{
    preg_match_all(
        '!\[quiz=([0-9]+)\]!isU',
        $content,
        $matches
    );

    foreach (array_keys($matches[0]) as $i) {
        $quiz = WQP_Factory::by_id($matches[1][$i]);
        if (!empty($quiz) && is_object($quiz)) {
            if (isset($_POST['answer']) && is_array($_POST['answer'])) {
                $content = str_replace($matches[0][$i], $quiz->fetch_answer($_POST['answer']), $content);
            } else {
                $content = str_replace($matches[0][$i], $quiz->fetch_quiz(), $content);
            }
        }
    }

    return $content;
}

function wqp_the_title($title)
{
    preg_match_all(
        '!\[quiz=([0-9]+)\]!isU',
        $title,
        $matches
    );

    foreach (array_keys($matches[0]) as $i) {
        $quiz = WQP_Factory::by_id($matches[1][$i]);
        if (!empty($quiz) && is_object($quiz)) {
            $title = str_replace($matches[0][$i], $quiz->get_title(), $title);
        }
    }

    return $title;
}

function wqp_get_query_template($template_dir, $type)
{
    $template = '';

    if (file_exists(TEMPLATEPATH . "/{$type}.php")) {
        $template = TEMPLATEPATH . "/{$type}.php";
    } elseif (file_exists($template_dir . "/{$type}.php")) {
        $template = $template_dir . "/{$type}.php";
    }

    return apply_filters("wqp_{$type}_template", $template);
}

function wqp_fetch_template($template_dir, $type, $params = null)
{
    if (!empty($params) && is_array($params)) {
        extract($params);
    }

    $template = wqp_get_query_template($template_dir, $type);

    if (file_exists($template)) {
        ob_start();
        include($template);
        $contents = ob_get_contents();
        ob_end_clean();
    } else {
        $contents = '';
    }

    return $contents;
}

function wqp_plugins_loaded()
{
    WQP_Factory::add_quiz_type('personality', 'Personality', 'WQP_Quiz_Personality', dirname(__FILE__) . '/quizzes/personality.php');
    do_action('wqp_register_quiz_types');
}