<?php
include_once('./API/Client/RestAPIClient.php');
include_once('./API/Client/MynewsDesk.php');
include_once('./mySQL/MYSQL.php');
header('Content-Type: application/json');

$unique_id = "28bd64f75e8ed32da31c6386ff354c22";

/*Merge types*/
$MynewsDesk = new  MynewsDesk($unique_id);
$jsonString =$MynewsDesk->getItemsAsJSON();


/*INSERT data to wordpress database
* TODO: Add more meta data */
$MynewsDesk->SaveToWordPressDb();

/*Print list*/
echo $jsonString;
?>

