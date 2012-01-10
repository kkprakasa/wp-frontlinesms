<?php

function generateRandomString($length)
{
        $result = '';

            for ($i = 0; $i < $length; $i++)
                    {
                                $num = rand(32, 126);
                                $result .= chr($num);
                    }

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
        echo $frontlinesms_key;
    }else{

        echo $frontlinesms_key;
    }
    return;

}
echo "Keyword :" . check_frontlinesms_key();
?>
<br />
<?
echo "Link : " . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . "?s={$Sender Number}&m={$Message content}&k=keyword";
echo "Just fill the link above to the frontlineSMS external command Http Request";
?>
