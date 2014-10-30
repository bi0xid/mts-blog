<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

// add to menu
add_action('admin_menu', 'wqp_add_menus');

function wqp_add_menus()
{
    add_menu_page('Quizzes', 'Quizzes', 8, WQP_FOLDER, 'wqp_show_menus');
    add_submenu_page(WQP_FOLDER, 'New Quiz', 'New Quiz', 8, 'edit-quiz', 'wqp_show_menus');

    add_action('load-toplevel_page_wordpress-quiz-plugin', 'wqp_load_wordpress_quiz_plugin');
    add_action('load-quizzes_page_edit-quiz', 'wqp_load_edit_quiz');
}

function wqp_show_menus()
{
    switch ($_GET["page"]) {
        case 'edit-quiz':
            wqp_edit_quiz();
            break;
        case 'wordpress-quiz-plugin':
            wqp_manage_quizzes();
            break;
        default:
            echo $_GET["page"];
    }
}

function wqp_load_wordpress_quiz_plugin()
{
    include_once (dirname(__FILE__) . '/manage-quizzes.php');
    wqp_manage_quizzes_init();
}

function wqp_load_edit_quiz()
{
    include_once (dirname(__FILE__) . '/edit-quiz.php');
    wqp_edit_quiz_init();
}