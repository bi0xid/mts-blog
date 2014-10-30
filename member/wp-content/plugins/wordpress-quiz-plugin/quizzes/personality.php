<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

class WQP_Quiz_Personality extends WQP_Quiz
{
    var $quiz_type = 'personality';

    var $default_num_personality_types = 6;
    var $default_num_questions         = 5;

    var $num_personality_types         = 6;
    var $num_questions                 = 5;

    var $action;

    var $answer;
    var $personality;
    var $question;

    function assign_all($unfiltered = null, $files = null)
    {
        if (!empty($files) && !empty($files['personality']['name']) && is_array($files['personality']['name'])) {
            require_once WQP_ABSPATH . "/wp-admin/includes/file.php";
            foreach (array_keys($files['personality']['name']) as $i) {
                $tmp = array(
                    'name'     => $files['personality']['name'][$i]['image'],
                    'type'     => $files['personality']['type'][$i]['image'],
                    'tmp_name' => $files['personality']['tmp_name'][$i]['image'],
                    'error'    => $files['personality']['error'][$i]['image'],
                    'size'     => $files['personality']['size'][$i]['image'],
                );
                $res = wp_handle_upload($tmp);
                if (!empty($res['url'])) {
                    $unfiltered['personality'][$i]['image'] = $res['url'];
                }
            }
        }

        // Not passing in data will result in assigning default values.
        $unfiltered = wqp_safe_array($unfiltered);

        // How many personality types are we expecting?
        $unfiltered['num_personality_types'] = wqp_safe_value(
            $unfiltered['num_personality_types'],
            $this->default_num_personality_types
        );
        $this->num_personality_types = intval($unfiltered['num_personality_types']);
        if (empty($this->num_personality_types)) {
            $this->num_personality_types = $this->default_num_personality_types;
        }

        // How many questions are we expecting?
        $unfiltered['num_questions'] = wqp_safe_value(
            $unfiltered['num_questions'],
            $this->default_num_questions
        );
        $this->num_questions = intval($unfiltered['num_questions']);
        if (empty($this->num_questions)) {
            $this->num_questions = $this->default_num_questions;
        }

        // Normalize unfiltered action
        $unfiltered['action'] = wqp_safe_value($unfiltered['action']);

        // Normalize unfiltered answer array
        $unfiltered['answer'] = array_values(wqp_safe_array($unfiltered['answer']));

        // Normalize unfiltered personality array
        $unfiltered['personality'] = array_values(wqp_safe_array($unfiltered['personality']));

        // Normalize unfiltered question array
        $unfiltered['question'] = array_values(wqp_safe_array($unfiltered['question']));

        // Normalize unfiltered title
        $unfiltered['title'] = wqp_safe_value($unfiltered['title']);

        // Initialize arrays
        $this->answer      = array();
        $this->personality = array();
        $this->question    = array();

        // Assign questions and answers
        for ($i = 0; $i < $this->num_questions; $i++) {
            $this->answer[$i]   = array();
            $this->question[$i] = wqp_filter_string(wqp_safe_value($unfiltered['question'][$i]));

            $unfiltered['answer'][$i] = array_values(wqp_safe_array($unfiltered['answer'][$i]));

            for ($j = 0; $j < $this->num_personality_types; $j++) {
                $this->answer[$i][$j] = wqp_filter_string(wqp_safe_value($unfiltered['answer'][$i][$j]));
            }
        }

        // Assign personalities
        for ($i = 0; $i < $this->num_personality_types; $i++) {
            $this->personality[$i] = array(
                'title' => wqp_filter_string(wqp_safe_value($unfiltered['personality'][$i]['title'])),
                'desc'  => wqp_filter_string(wqp_safe_value($unfiltered['personality'][$i]['desc'])),
                'image' => wqp_filter_string(wqp_safe_value($unfiltered['personality'][$i]['image'])),
            );
        }

        // Assign action
        $this->action = explode(':', $unfiltered['wqp_action']);
        if (isset($unfiltered['save_and_continue'])) {
            $this->action = array('save_and_continue');
        }
        if (isset($unfiltered['save'])) {
            $this->action = array('save');
        }

        // Assign title
        $this->title = wqp_filter_string($unfiltered['title']);
    }

    function assign_defaults()
    {
        $this->assign_all(array());
    }

    function fetch_form()
    {
        $params = $this->fetch_array();

        return wqp_fetch_template($this->get_quiz_template_dir(), 'personality_form', $params);
    }

    function fetch_answer($unfiltered)
    {
        $score = array();
        for ($i = 0; $i < $this->num_questions; $i++) {
            $answer = intval($unfiltered[$i]);
            if (empty($score[$answer])) {
                $score[$answer] = 1;
            } else {
                $score[$answer]++;
            }
        }

        asort($score);
        $keys = array_keys($score);

        do {
            $personality = array_pop($keys);
            if (is_null($personality)) {
                die("Invalid Quiz Response");
            }
        } while (empty($this->personality[$personality]));

        $params = array(
            'title' => $this->personality[$personality]['title'],
            'desc'  => $this->personality[$personality]['desc'],
            'image' => $this->personality[$personality]['image'],
            'quiz_title' => $this->title,
            'quiz_href'  => get_permalink(),
        );

        return wqp_fetch_template($this->get_quiz_template_dir(), 'personality_answer', $params);
    }

    function fetch_quiz()
    {
        $params = $this->fetch_array();

        return wqp_fetch_template($this->get_quiz_template_dir(), 'personality_quiz', $params);
    }

    function fetch_array()
    {
        $result = array(
            'quiz_id'               => $this->quiz_id,
            'num_personality_types' => $this->num_personality_types,
            'num_questions'         => $this->num_questions,
            'answer'                => $this->answer,
            'personality'           => $this->personality,
            'question'              => $this->question,
            'title'                 => $this->title
        );

        return $result;
    }

    function process_form()
    {
        if (function_exists('check_admin_referer')) {
            check_admin_referer('wqp_personality_form_' . $this->quiz_id);
        }

        switch ($this->action[0]) {
            case 'add_personality_type':
                $this->num_personality_types++;
                break;
            case 'delete_personality_type':
                unset($this->personality[$this->action[1]]);
                $this->personality = array_values($this->personality);

                foreach (array_keys($this->answer) as $q) {
                    unset($this->answer[$q][$this->action[1]]);
                    $this->answer[$q] = array_values($this->answer[$q]);
                }

                $this->num_personality_types--;
                break;
            case 'delete_personality_image':
                unset($this->personality[$this->action[1]]['image']);
                break;
            case 'add_question':
                $this->num_questions++;
                break;
            case 'delete_question':
                unset($this->question[$this->action[1]]);
                $this->question = array_values($this->question);

                unset($this->answer[$this->action[1]]);
                $this->answer = array_values($this->answer);

                $this->num_questions--;
                break;
            case 'save':
                $this->save();
                $redirect_uri = get_option('siteurl') . '/wp-admin/admin.php?page=wordpress-quiz-plugin';
                wp_redirect($redirect_uri);
                exit;
                break;
            case 'save_and_continue':
                $this->save();
                break;
            default:
                // Do Nothing
                return;
        }
    }
}