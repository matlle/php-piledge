<?php

/*
	@@ -=::MATLLE::=-
-----------------------------------------------------------------------------	
	# author: @matlle
	# email: paso.175@gmail.com
	# mobile: (225) 41870768
-----------------------------------------------------------------------------
	@@ Simple is better than complex.
*/

    class DBFactory
    {
        public static function PgDAO() {
            
             try {

                 $db = new PDO('pgsql:host=localhost;dbname=databasename', 'matlle', 'password');                  
                 return $db;

             } catch(Exception $e) {

                 die('Erreur : ' .$e->getMessage());
            }
       }

    }
