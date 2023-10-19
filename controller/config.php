<?php

    class DB {
        private static function connect(){
            $host = "localhost";
            $dbname = "id21202653_linkapp";
            $username = "id21202653_oah";
            $password = "8Ttx?QitMuWFtJEK";
            $pdo = new PDO("mysql:hostname=$host;dbname=$dbname;charset=UTF8",$username,$password); 
            $pdo->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
        public static function query ($query , $params) {
            $statement=self::connect()->prepare($query);
            $statement->execute($params);
            if (explode(" ",$query)[0]="SELECT") {
                $data = $statement->fetchAll();    
                return $data;
            }
        }
    }

?>