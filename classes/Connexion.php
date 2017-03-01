<?php


    /**
     * Created by PhpStorm.
     * User: Mouhssine Soumairi
     * Date: 17/02/2017
     * Time: 16:43
     */
    class Connexion
    {
        protected $con;


        public function __construct(){
            $this->con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        }

    }
