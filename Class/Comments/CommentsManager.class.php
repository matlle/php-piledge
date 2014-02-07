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

    class CommentsManager
    {
        protected $db;


        public function __construct(PDO $db) {

            $this->db = $db;

        }


        protected function add_comment(Comments $comment) {
        
            $sql = 'INSERT INTO comments
                        ( file_id,
                          author_id,
                          comment_content,
                          comment_created_at)
                    VALUES
                        ( :file_id,
                          :author,
                          :content,
                           NOW())
                    ';

            $query = $this->db->prepare($sql);
            $query->execute(array(
                               'file_id' => $comment->get_file_id(),
                               'author' => $comment->get_author_id(),
                               'content' => $comment->get_comment_content(),
                           )) or die(print_r($query->errorInfo()));

            $query->closeCursor();


        }


        public function save_comment(Comments $comment) {

            if ($comment->isValid()) {

                $comment->isNew() ? $this->add_comment($comment) : $this->update_comment($comment);


            } else {
            
                throw new RuntimeException('Comment need to be valid for save');

            }

        }

        
        public function delete_comment($id) {
        }
        

        protected function update_comment(Comment $comment) {
        }
        

        public function get_comment_id($id) {
        }

        


        public function get_all_comments_by_file($fid) {

            $sql = 'SELECT
                       c.comment_id,
                       c.comment_content,
                       c.comment_created_at,
                       c.comment_updated_at,
                       c.author_id,
                       a.author_id,
                       a.author_pseudo,
                       av.avatar_30x30
                     FROM comments c
                     INNER JOIN authors a USING(author_id)
                     LEFT JOIN avatars av USING(author_id)
                     WHERE c.file_id = :fid
                     ORDER BY c.comment_created_at ASC
                   ';
            
            $data = array();

            $query = $this->db->prepare($sql);
            $query->bindValue(':fid', $fid, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $comment_count = $query->rowCount();


            while ($row = $query->fetch()) {
                array_push($data, $row);
            }

            $query->closeCursor();


            $sql1 = 'UPDATE files
                     SET file_comments_count = :count
                     WHERE file_id = :fid
                    ';

            $ucquery = $this->db->prepare($sql1);
            $ucquery->bindValue(':count', $comment_count, PDO::PARAM_INT);
            $ucquery->bindValue(':fid', $fid, PDO::PARAM_INT);
            $ucquery->execute() or die(print_r($ucquery->errorInfo()));
            
            $ucquery->closeCursor();

            return $data;              


        }

        
        public function get_limit_comments_by_file($fid, $l) {

            $sql = 'SELECT
                       c.comment_id,
                       c.comment_content,
                       c.comment_created_at,
                       c.comment_updated_at,
                       c.author_id,
                       a.author_id,
                       a.author_pseudo,
                       a.author_avatar
                     FROM comments c
                     INNER JOIN authors a USING(author_id)
                     WHERE c.file_id = :fid
                     ORDER BY c.comment_created_at ASC
                     LIMIT :l
                   ';
            
            $data = array();

            $query = $this->db->prepare($sql);
            $query->bindValue(':fid', $fid, PDO::PARAM_INT);
            $query->bindValue(':l', $l, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));


           // $comment_count = $query->rowCount();


            while ($row = $query->fetch()) {
                array_push($data, $row);
            }

            $query->closeCursor();


           /* $sql1 = 'UPDATE files
                     SET file_comments_count = :count
                     WHERE file_id = :fid
                    ';

            $ucquery = $this->db->prepare($sql1);
            $ucquery->bindValue(':count', $comment_count, PDO::PARAM_INT);
            $ucquery->bindValue(':fid', $fid, PDO::PARAM_INT);
            $ucquery->execute() or die(print_r($ucquery->errorInfo()));
            
            $ucquery->closeCursor();*/

            return $data;              
        

        }
        
         
         public function get_offset_comments_by_file($fid, $l, $offset) {
         

            $sql = 'SELECT
                       c.comment_id,
                       c.comment_content,
                       c.comment_created_at,
                       c.comment_updated_at,
                       c.author_id,
                       a.author_id,
                       a.author_pseudo,
                       av.avatar_30x30
                     FROM comments c
                     INNER JOIN authors a USING(author_id)
                     LEFT JOIN avatars av USING(author_id)
                     WHERE c.file_id = :fid
                     LIMIT :l OFFSET :offset
                   ';
            
            $data = array();

            $query = $this->db->prepare($sql);
            $query->bindValue(':fid', $fid, PDO::PARAM_INT);
            $query->bindValue(':l', $l, PDO::PARAM_INT);
            $query->bindValue(':offset', $offset, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            //$comment_count = $query->rowCount(); 

            while ($row = $query->fetch()) {
                array_push($data, $row);
            }

            $query->closeCursor();


          /*  $sql1 = 'UPDATE files
                     SET file_comments_count = :count
                     WHERE file_id = :fid
                    ';

            $ucquery = $this->db->prepare($sql1);
            $ucquery->bindValue(':count', $comment_count, PDO::PARAM_INT);
            $ucquery->bindValue(':fid', $fid, PDO::PARAM_INT);
            $ucquery->execute() or die(print_r($ucquery->errorInfo()));
            
            $ucquery->closeCursor(); */

            return $data;              
        

        }
 


        public function get_all_comments() {

            $sql = 'SELECT
                   ';   

        }





    }
