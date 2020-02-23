<?php
require_once("model/Manager.php");

class UpdateManager extends Manager
{
    function updateImageTable($imageArray){
        $bdd = $this->dbConnect();

        // var_dump($item);
        for ($i=0; $i < count($imageArray); $i++) { 
            $item = $imageArray[$i];
            $bdd->query("UPDATE imageDatas SET title = '" . $item['title'] ."', alt = '" .$item['alt'] . "', legend = '" .$item['legend'] . "' WHERE id = '" . $item['id'] ."'");
        }
        // $req = $bdd->query("UPDATE imageDatas SET title = '" . $item['title'] ."', alt = '" .$item['alt'] . "', legend = '" .$item['legend'] . "' WHERE id = '" . $item['id'] ."'");
        // return $req;
    }
    function updateKeywordTable( $keywordArray){
        var_dump($keywordArray);

    }

}
