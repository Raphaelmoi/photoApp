<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST,  DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

require ('controller/Controller.php');
$controller = new Controller();

try {

    if (isset($_GET['action'])) {

        if ($_GET['action'] == 'getKeyWords') {
            $controller -> getKeyWordsList();
        }
        elseif ($_GET['action'] == 'getImages') {
            $controller -> getImagesDatas();
        }
        elseif ($_GET['action'] == 'newdatas') {
            if (isset($_POST['datas'])) {
                // TODO
                // SECURISER L'envoie?
                $datas = json_decode($_POST['datas'], true);
                var_dump($datas);
                $controller -> uploadImg($_FILES);
                $controller -> uploadDatas($datas);
            }
        }
        elseif ($_GET['action'] == 'updatediaporama') {
            $controller -> updateDiaporama(json_decode($_POST['imageDatas'], true), json_decode($_POST['currentKeywordDatas'], true));
            // var_dump($_POST);
        }
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

