<?php

/*
 * Plugin Name: WP-FrontlineSMS
 * Plugin URI: pr4ka5a.wordpress.com
 * Description: Plugin for fetch messages from Frontline SMS
 * Author: Kaka E. Prakasa
 * Version: 0.1
 * Author URI: https://github.com/pr4ka5a/wp-frontlinesms/
 */
?>
<?
function frontlinesms_install()
{
    global $wpdb;
    $table = $wpdb->prefix."frontlinesms";
    $structure = "CREATE TABLE $table (
        id INT(9) NOT NULL AUTO_INCREMENT,
        FRONTLINE_key VARCHAR(8),
        sender_number INT(15) NOT NULL,
        message_content VARCHAR(800),
        dt datetime NOT NULL default '0000-00-00',
        UNIQUE KEY id (id)
    );";
    $wpdb->query($structure);
}
register_activation_hook(__FILE__,'frontlinesms_install');

function frontlinesms()
{
    include('frontlinesms_admin.php');
}

function frontlinesms_admin_menu()
{
    add_options_page('frontlineSMS','frontlineSMS',1,'frontlineSMS','frontlineSMS');

}

add_action('admin_menu', 'frontlinesms_admin_menu');

function frontline_post($args)
{
    if (isset($_SERVER['QUERY_STRING']))
    {
            global $wpdb;
            $table = $wpdb->prefix."frontlinesms";
            $default = array (
                's' => '',
                'm' => '',
                'k' => '',
                'lewat' => TRUE
                );
                $dt = date("Y-m-d");

                //Melewatkan argumen yang datang dan memasukkannya dalam $default
                $args = wp_parse_args( $args, $default);

                //Mendeklarasikan setiap item pada $args menjadi variabel
                extract( $args, EXTR_SKIP);
                $frontlinesms_key = $wpdb->get_var($wpdb->prepare("SELECT FRONTLINE_key FROM $table"));

                if(!empty($s) AND !empty($m) AND !empty($k))
                {
                    if($k == $frontlinesms_key)
                    {
                        $send = "INSERT INTO $table( FRONTLINE_key, sender_number, message_content, dt) VALUES( %s, %d, %s, %d)";
                        $wpdb->query($wpdb->prepare($send, $k, $s, $m, $dt));
                        $wpdb->show_errors();
                    }
                }
    }

}

frontline_post($_SERVER['QUERY_STRING'])
?>
