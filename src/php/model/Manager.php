<?php

class Manager
{
	protected function dbConnect() {
        $bdd = new PDO('mysql:host=localhost;dbname=imagedb;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    }
}