<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST,  DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// session_start();
require ('controller/Controller.php');
$controller = new Controller();

try {
    // $postdata = file_get_contents("php://input");
    // echo($postdata);
    if (isset($_POST['datas'])) {

        $datas = json_decode($_POST['datas'], true);
        var_dump($datas);
        //  var_dump($datas[0]['newKeywords']);

        $controller -> uploadImg($_FILES);
        $controller -> uploadDatas($datas);


        // $newKeyword = $result[0]['newKeywords'];
        // echo json_encode($newKeyword);

        // $newKeyword = $result[1]['file'];
        // echo json_encode($newKeyword);

    }
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'getKeyWords') {
            $controller -> getKeyWordsList();
        }
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

