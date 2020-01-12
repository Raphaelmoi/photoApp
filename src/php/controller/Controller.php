<?php
class Controller
{       
    function __construct()
    {
        spl_autoload_register('Controller::chargerClasse');
        // require 'controller/UtiController.php';
        // require 'controller/UserController.php';
    }
    //autoload
    function chargerClasse($classname)
    {
        require 'model/'.$classname.'.php';
    }
    // function listPosts() {
    //     $postManager = new PostManager();
    //     $uticontroller = new UtiController();
    //     $reponse = $postManager -> getPosts();
    //     require('view/frontend/affichageAccueil.php');
    // }
    function getKeyWordsList(){
        $postManager = new PostManager();
        $result = $postManager -> getKeywords();
        echo json_encode($result);
        return $result;
    }

    function uploadDatas($datas){

        $postManager = new PostManager();

        $totalNewKeyWord = count($datas[0]['newKeywords']);
        $totalNewImages = count($datas);
        // var_dump($totalNewImages);
        //start at 1 because 0 is newkeyword
        for ($i=1; $i < $totalNewImages ; $i++) { 
            $send = $postManager -> postImgDatas( 
                $datas[$i]['name'],
                $datas[$i]['description'],
                $datas[$i]['legend']
            );

            $totalSelectedKeyword = count($datas[$i]['keyword']);
            for ($j=0; $j < $totalSelectedKeyword; $j++) { 
                $post = $postManager -> addImgNameToSelectedKeyword( $datas[$i]['keyword'][$j],  $datas[$i]['name'] );
            }
            
        }

        // $datas[0]['newKeywords']
    }



    function uploadImg(){
        $accepted_origins = array("https://localhost");
        // Images upload path
        $imageFolder = "../public/images/";
        reset($_FILES);
        $temp = current($_FILES);
        $total = count($temp['tmp_name']);

        for( $i=0 ; $i < $total ; $i++ ) {
            if(is_uploaded_file($temp['tmp_name'][$i])){
                if(isset($_SERVER['HTTPS_ORIGIN'])){
                    // Same-origin requests won't set an origin. If the origin is set, it must be valid.
                    if(in_array($_SERVER['HTTPS_ORIGIN'], $accepted_origins)){
                        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTPS_ORIGIN']);
                    }else{
                        header("HTTPS/1.1 403 Origin Denied");
                        return;
                    }
                }
                // Accept upload if there was no origin, or if it is an accepted origin
                // $filetowrite =  $imageFolder . 'baba.jpg';
                $filetowrite =  $imageFolder . $temp['name'][$i];
                move_uploaded_file($temp['tmp_name'][$i],$filetowrite);  
                // Respond to the successful upload with JSON.
                echo json_encode(array('location' => $filetowrite));

            } else {
                // Notify editor that the upload failed
                header("HTTPS/1.1 500 Server Error");
            }
        }
        return $filetowrite;
    }

}