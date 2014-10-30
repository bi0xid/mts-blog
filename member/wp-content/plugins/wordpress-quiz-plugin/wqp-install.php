<?php
/*
Copyright (c) 2007 Andrew Shell (http://blog.andrewshell.org)
and Netconcepts (http://www.netconcepts.com)
WordPress Quiz Plugin is released under the GNU General Public
License (GPL) http://www.gnu.org/licenses/gpl.txt
*/

function wqp_install()
{
    global $wpdb;

    require_once(WQP_ABSPATH . 'wp-admin/includes/upgrade.php');

    $charset_collate = '';

    if (version_compare(mysql_get_server_info(), '4.1.0', '>=')) {
        if (!empty($wpdb->charset)) {
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        }

        if (!empty($wpdb->collate)) {
            $charset_collate .= " COLLATE $wpdb->collate";
        }
    }

    $wp_queries = "CREATE TABLE IF NOT EXISTS $wpdb->wqp_quizzes (
     quiz_id bigint(20) unsigned NOT NULL auto_increment,
     quiz_type varchar(255) NOT NULL default '',
     quiz_title varchar(255) NOT NULL default '',
     quiz_data longtext NOT NULL default '',
     PRIMARY KEY  (quiz_id)
    ) $charset_collate;";

    $alterations = dbDelta($wp_queries);

    update_option('wqp_installed_version', WQP_VERSION);
}

register_activation_hook(WQP_FOLDER . '/wordpress-quiz-plugin.php', 'wqp_install');