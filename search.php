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

    require_once 'Helper/autoload.inc.php';
    require_once 'initwig.php';
    require_once 'Helper/appvar.php';
    require_once 'Helper/fucs_helper.php';

    //require_once 'sphinxapi.php';
    
    //$client = new SphinxClient();
    $db = DBFactory::PgDAO();

   /* $client->SetServer('localhost', 9312);
    $client->SetConnectTimeout(1);
    $client->SetArrayResult(true); */


    function build_query($user_search) {

        $search_query = "SELECT 
                         f.*,
                         a.*,
                         av.avatar_50x50
                         FROM files f
                         INNER JOIN authors a USING(author_id)
                         LEFT JOIN avatars av USING(author_id)
                        ";

        $user_search = strtolower($user_search);

        // Extract the search keywords into an array
        $bad = array('.',',','?',';',':','/','!','§','%','ù','*','µ','¨','^','$','£','ø','=','+','}',')','°',']','@','^','\\','|','[','{','#','~','}',']','&','²'); 
        $clean_search = str_replace($bad, ' ', $user_search);
        $search_words = explode(' ', $clean_search);

        $final_search_words = array();

        if (count($search_words) > 0) {
            foreach ($search_words as $word) {
                if (!empty($word)) {
                    $final_search_words[] = $word;
                }
            }
        }

        // Generate a WHERE clause using all of the search keywords
        
        $where_list = array();
        if (count($final_search_words) > 0) {
            foreach($final_search_words as $word) {
                $where_list[] = "LOWER(file_description) LIKE '%$word%'";
                $where_list[] = "LOWER(file_title) LIKE '%$word%'";
                $where_list[] = "LOWER(author_pseudo) LIKE '%$word%'";
            }
        }

        $where_clause = implode(' OR ', $where_list);
        
        // Add the keyword WHERE clause to the search query
        if (!empty($where_clause)) {
            $search_query .= " WHERE $where_clause";
        }

        return $search_query; 

        //return $final_search_words;
        
    }
   
   /* $sql = "SELECT *
            FROM files f
            WHERE f.file_id = :fileid";

    $file_stmt = $db->prepare($sql);
    
    $no_result = false;

    function get_results($results) {
        global $file_stmt;
        
        if (!isset($results['matches'])) {
            $no_result = true;
            return;
        }
        
        $all_results = array();
        foreach ($results['matches'] as $result) {
            $file_stmt->bindParam(':fileid', $result['id'], PDO::PARAM_INT);
            $file_stmt->execute() or die(print_r($file_stmt->errorInfo()));
            $all_results[] = $file_stmt->fetch();
        }

        return $all_results;
    }*/

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_term = $_GET['search'];
        $sql = build_query($search_term);
        
       // $words = get_words($search_term);

        //$client->SetMatchMode(SPH_MATCH_ANY);
       // $results = get_results($client->Query($words));
        //$count = count($results);
          
        $search = $db->prepare($sql);
        $search->execute() or die(print_r($search->errorInfo()));
        $results = $search->fetchAll();
        $count = $search->rowCount();
        
        
        echo $twig->render('base/results.html', array(
            'author' => $author,
            'nb_file' => $nb_file,
            'nb_following' => $nb_following,
            'nb_follower' => $nb_follower,
            'msg_unread' => $msg_unread,
            'no_result' => $no_result,
            'results' => $results,
            'count' => $count
        ));

        //$search->closeCursor();
 }
