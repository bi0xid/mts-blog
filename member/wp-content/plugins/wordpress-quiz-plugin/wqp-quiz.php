<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

class WQP_Quiz
{
    var $quiz_id;
    var $quiz_type = 'unknown';

    var $title;

    function assign_all($unfiltered = null, $files = null) { die('assign_all must be overloaded'); }
    function assign_defaults() { die('assign_defaults must be overloaded'); }
    function fetch_answer($unfiltered) { die('fetch_answer must be overloaded'); }
    function fetch_array() { die('fetch_array must be overloaded'); }
    function fetch_form() { die('fetch_form must be overloaded'); }
    function fetch_quiz() { die('fetch_quiz must be overloaded'); }
    function process_form() { die('process_form must be overloaded'); }

    function __construct($quiz_id = null)
    {
        if (!empty($quiz_id)) {
            $this->quiz_id = intval($quiz_id);
        }
    }

    function WQP_Quiz($quiz_id = null)
    {
        $this->__construct($quiz_id);
    }

    function get_title()
    {
        return $this->title;
    }

    function get_quiz_id()
    {
        return $this->quiz_id;
    }

    function get_quiz_template_dir()
    {
        return str_replace('\\', '/', dirname(__FILE__)) . '/quizzes/' . $this->quiz_type;
    }

    function delete()
    {
        global $wpdb;

        if (!empty($this->quiz_id)) {
            $sql = "DELETE FROM
                        " . $wpdb->wqp_quizzes . "
                    WHERE
                        `quiz_id` = {$this->quiz_id}";

            $wpdb->query($sql);
        }
    }

    function save()
    {
        global $wpdb;

        $data = $this->fetch_array();

        $title = wqp_safe_value($data['title']);
        $data  = serialize($data);

        if (empty($this->quiz_id)) {
            $sql = "INSERT INTO " . $wpdb->wqp_quizzes . " SET
                        `quiz_type` = '" . $wpdb->escape($this->quiz_type) . "',
                        `quiz_title` = '" . $wpdb->escape($title) . "',
                        `quiz_data` = '" . $wpdb->escape($data) . "'";

            $wpdb->query($sql);

            $this->quiz_id = $wpdb->insert_id;
        } else {
            $sql = "UPDATE " . $wpdb->wqp_quizzes . " SET
                        `quiz_type` = '" . $wpdb->escape($this->quiz_type) . "',
                        `quiz_title` = '" . $wpdb->escape($title) . "',
                        `quiz_data` = '" . $wpdb->escape($data) . "'
                    WHERE
                        `quiz_id` = {$this->quiz_id}";

            $wpdb->query($sql);
        }
    }
}