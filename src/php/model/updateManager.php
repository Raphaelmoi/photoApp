<?php
require_once("model/Manager.php");

class UpdateManager extends Manager
{
    function updateImageTable($imageArray){
        $bdd = $this->dbConnect();
        for ($i=0; $i < count($imageArray); $i++) { 
            $item = $imageArray[$i];
            $bdd->query("UPDATE imageDatas SET title = '" . $item['title'] ."', alt = '" .$item['alt'] . "', legend = '" .$item['legend'] . "' WHERE id = '" . $item['id'] ."'");
        }
    }
    function updateOneKeywordTable( $keywordArray){
        var_dump($keywordArray);
        $bdd = $this->dbConnect();
        $bdd->query("UPDATE keyword SET keywords = '" . $keywordArray[0] ."', imageName = '" .$keywordArray[2] . "', main_image = '" .$keywordArray[3] . "' WHERE id = '" . $keywordArray[1] ."'");
    }

    function downNbreUtilisationImg($imageArray) {
        $bdd = $this->dbConnect();
        for ($i=0; $i < count($imageArray); $i++) { 
            $item = $imageArray[$i];
            $bdd->query("UPDATE imageDatas SET nbre_utilisation = nbre_utilisation - 1 WHERE id = '" . $item['id'] ."'");
        }
    }

    function updateKeywordTable($keywordArray) {
        var_dump($keywordArray);
        $bdd = $this->dbConnect();
        for ($i=0; $i < count($keywordArray); $i++) { 
            $item = $keywordArray[$i];
            $bdd->query("UPDATE keyword SET keywords = '" . $item[0] ."', imageName = '" .$item[2] . "', main_image = '" .$item[3] . "' WHERE id = '" . $item[1] ."'");
        }
    }
}
