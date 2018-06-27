<?php

/**
 * MynewsDesk short summary.
 *
 * MynewsDesk description.
 *
 * @version 1.0
 * @author User
 */
class MynewsDesk
{
    private $key="";
    private $items;

    public function __construct($pKey) {
        $this->key=$pKey;
    }
    public function getItemsAsJSON() {
        $out = array_values($this->getItems());
        return json_encode($out);
    }

    public function SaveToWordPressDb() {
        $mysql = new Mysql();
        $mysql->Connect();
        foreach($this->items as $item) {
            $mysql->freeRun("INSERT INTO wp_post (post_title,post_content) VALUES('" . $item->header . "','" . $item->body . "')");
        }

    }

    public function getItems() {
        $items =array();
        $PressreleaseItem =$this->PressreleaseItem();
        array_push($items,$PressreleaseItem,$this->NewsItem(),$this->BlogPostItem());

        usort($PressreleaseItem, function($a, $b) {
            return strtotime($a->published_at) - strtotime($b->published_at);
        });
        $this->items=$items;
        return $items;
    }
    public function PressreleaseItem() {
        return $this->getFirstItem("news");
    }



    function NewsItem() {
        return $this->getFirstItem("news");
    }

    function BlogPostItem() {
        return $this->getFirstItem("blog_post");
    }

    function getFirstItem($pTypeOfMedia) {
        $client = new RestAPIClient();
        $rowData = $client->Get("http://www.mynewsdesk.com/services/pressroom/list/" . $this->key . "/?limit=2&format=json&locale=sv&pressroom=se&type_of_media=" . $pTypeOfMedia,null);

        $json =json_decode($rowData);

        return $json->items->item[0];
    }

}
?>