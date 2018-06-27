<?php
include_once('./API/Client/RestAPIClient.php');
include_once('./API/Client/MynewsDesk.php');
include_once('./mySQL/Mysql.php');
header('Content-Type:application/json; charset=UTF-8');

$unique_id = "<key>";

/*Merge types*/
$MynewsDesk = new  MynewsDesk($unique_id);
$jsonString =$MynewsDesk->getItemsAsJSON();

/*INSERT data to wordpress database
 * TODO: Add more meta data */
if($_POST["action"]=="add") {
    if($MynewsDesk->SaveToWordPressDb()==false) {
    }
    echo '{"error":"none"}';
} else if($_POST["action"]=="delete") {
        $mysql = new Mysql();

        if($mysql->Connect()) {
            $mysql->freeRun("DELETE FROM wp_posts");
            echo '{"error":"none"}';
        }
} else {
    /*Print list*/
    echo $jsonString;
}

?>

