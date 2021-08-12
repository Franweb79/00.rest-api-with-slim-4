<?php

        //require 'db-connection-dev.php'; no needed, it will be called on the index.php

    /*

        this time will only be used to insert an item, but maybe in the future we could create methods to getItem and getItems,
        now this code is done on each route designed for each tasks. Maybe that way is more clean code

    */

    class Item{

        public function postNewItem($p_postNewItemFormData){


            $sql="INSERT INTO items (item_name)
            VALUES (:p_item_name);";

            ($sql);
            
            try{

                $conObj=new Connection();

                $conn=$conObj->connect();

                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                /*execute is for prepared sentence*/
                $sth->execute( array(':p_item_name' => $p_postNewItemFormData["itemName"]) ) ;

                $conObj = null; // clear db object (close the connection)


            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }
    }
?>