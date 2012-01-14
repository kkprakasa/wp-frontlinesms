<?php

function generateRandomString($length)
{
        $result = '';
              
         $num = rand(0,26);
         $result .= substr(md5(microtime()),$num,$length);
                   
         return $result;
}

function check_frontlinesms_key()
{
    global $wpdb;
    $table = $wpdb->prefix."frontlinesms";
    $frontlinesms_key = $wpdb->get_var($wpdb->prepare("SELECT FRONTLINE_key FROM $table"));
    if(!isset($frontlinesms_key)){
        
        $frontlinesms_key = generateRandomString(8);
        $send = "INSERT INTO $table(FRONTLINE_key) VALUES('$frontlinesms_key')";
        $wpdb->query($send);
        return $frontlinesms_key;
    }else{

        return $frontlinesms_key;
    }
    return;

}
echo "Keyword : ";
echo "<b>" . check_frontlinesms_key() . "</b>";
?>
<br />
<?
echo "<b> Link : " . $_SERVER['HTTP_HOST'] . "/index.php?s=\${sender_number}&m=\${message_content}&k=" . check_frontlinesms_key() . " </b><br />";
echo "Just fill the link above to the frontlineSMS external command Http Request";
?>