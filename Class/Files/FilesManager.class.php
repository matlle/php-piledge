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


     class FilesManager extends FollowersManager
    {    
         protected $db;
         
         const UPLOADPATH = 'docs/';
         const THUMBNAIL  = 'docs/thumbnails/';
         const PDF        = 'docs/pdf/';
         

         public function __construct(PDO $db) {

            $this->db = $db;
         }
         

         protected function add_file(Files $file) {
            
            if ($file->get_file_error() == 0) {                
                    
                    switch ($file->get_ext()) {

                        case 1:
                            $this->s_pdf($file);
                            break;

                        default:        
                            echo "Sorry there an or many errors whithin your source code :(";

                    }
                
             }

         }
         

         public function save_file(Files $file) {

            if ($file->isValid()) {

                $file->isNew() ? $this->add_file($file) : $this->update_file($file);
            
            } else {
                
                throw new RuntimeException('File need to be valid for save');
            }

         }
         

         protected function s_pdf(Files $file) {
         
             if (move_uploaded_file($file->get_file_tmp_name(), $file->get_file_pdf_name())) {
         
                 $file->set_file_pages_number($file->get_file_pdf_name());
                 $pages_number = $file->get_file_pages_number();

                            $thumb = new Imagick($file->get_file_pdf_name() . '[0]');
                            $thumb->thumbnailImage(150, 200);
                            $thumb->setImageFormat('png');
                            $thumb->writeImage($file->get_file_thumb_name());

                            $sql = 'INSERT INTO files 
                                       ( file_title,
                                         author_id,
                                         file_description,
                                         file_type,
                                         file_size,
                                         file_ext,
                                         file_name,
                                         file_pdf_name,
                                         file_thumb_name,
                                         file_pages_number,
                                         file_created_at)
                                     VALUES 
                                       ( :title,
                                         :author,
                                         :description,
                                         :type,
                                         :size,
                                         :ext,
                                         :name,
                                         :pdf_name,
                                         :thumb_name,
                                         :pages_number,
                                         NOW())
                                   ';

                            $query = $this->db->prepare($sql);
                            $query->execute(array(
                                               'title' => $file->get_file_title(),
                                               'author' => $file->get_author_id(),
                                               'description' => $file->get_file_description(),
                                               'type' => $file->get_file_type(),
                                               'size'=> $file->get_file_size(),
                                               'ext' => $file->get_file_ext(),
                                               'name'=> $file->get_file_name(),
                                               'pdf_name' => $file->get_file_pdf_name(),
                                               'thumb_name' => $file->get_file_thumb_name(),
                                               'pages_number' => $pages_number

                                           )) or die(print_r($query->errorInfo()));

                           @unlink($file->get_file_tmp_name());

                            $query->closeCursor();
              }

         }




         


         
         public function get_preview_file_thumbnail($tmp, $pdfn, $thumbname) {
         
             if (move_uploaded_file($tmp, $pdfn)) {
         

                            $thumb = new Imagick($pdfn . '[0]');
                            $thumb->thumbnailImage(150, 200);
                            $thumb->setImageFormat('png');
                            $thumb->setImageCompressionQuality(90);
                            $thumb->writeImage($thumbname);
                 
                 @unlink($tmp);

                             
                 return $thumbname;               
              }

         }





         
         
         protected function s_docx() {
         }


         protected function s_doc() {
         }
         

         protected function s_txt() {
         }


         public function delete_file($id) {
         }
         

         protected function update_file(Files $file) {
         }
         

         public function get_file_id($id) {

            $id = (int) $id;

            $sql = 'SELECT 
                        f.file_id,
                        f.file_title,
                        f.file_name,
                        f.file_description,
                        f.file_type,
                        f.file_size,
                        f.file_created_at,
                        f.file_updated_at,
                        f.file_pdf_name,
                        f.file_ext,
                        f.author_id,
                        a.author_pseudo,
                        av.avatar_50x50
                     FROM files f
                     INNER JOIN authors a USING(author_id)
                     LEFT JOIN avatars av USING(author_id)
                     WHERE f.file_id = :id
                   ';

            
            $data = array();

            $fquery = $this->db->prepare($sql);
            $fquery->bindValue(':id', $id, PDO::PARAM_INT);
            $fquery->execute() or die(print_r($fquery->errorInfo()));
            $data = $fquery->fetch();
            $fquery->closeCursor();


            return $data;

         }
         

         public function get_all_files() {

            $sql = 'SELECT
                       f.*,
                       a.*,
                       av.avatar_50x50
                    FROM files f
                    INNER JOIN authors a USING(author_id)
                    LEFT JOIN avatars av USING(author_id)
                    ORDER BY f.file_created_at DESC
                   ';

           $query = $this->db->prepare($sql);
           $query->execute() or die(print_r($query->errorInfo()));

           $rows = $query->fetchAll();

           $query->closeCursor();


           return $rows;
         }



         public function get_all_files_by_author($pseudo) {

            $sql = 'SELECT
                        f.*,
                        av.avatar_50x50,
                        a.*
                    FROM files f
                    INNER JOIN authors a USING(author_id)
                    LEFT JOIN avatars av USING(author_id)
                    WHERE a.author_id = :aid
                    ORDER BY f.file_created_at DESC
                   ';

            $aid = $this->get_author_id($pseudo);

            $query = $this->db->prepare($sql);
            $query->bindValue(':aid', $aid, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));
            
            $rows = $query->fetchAll();
            
            $query->closeCursor();
            
            return $rows;

         }


         public function get_all_files_by_followings($author_id) {

            $sql = 'SELECT
                        f.*,
                        av.avatar_50x50,
                        a.*
                    FROM files f
                    INNER JOIN authors a USING(author_id)
                    LEFT JOIN avatars av USING(author_id)
                    WHERE f.author_id in(SELECT follower_id FROM user_followers WHERE author_id = :aid) OR a.author_id = :aid
                    ORDER BY f.file_created_at DESC
                   ';


            // WHERE fo.author_id = :aid OR a.author_id = :aid

            $pseudo = $this->get_author_pseudo($author_id);

            $query = $this->db->prepare($sql);
            $query->bindValue(':aid', $author_id, PDO::PARAM_INT);
            //$query->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $query->execute() or die(print_r($query->errorInfo()));
            
            $rows = $query->fetchAll();
            
            $query->closeCursor();

            return $rows;

         }
         



         public function count_files($author_id) {

            $sql = "SELECT COUNT('file_id')
                    FROM files
                    WHERE author_id = :auid
                   ";
            $query = $this->db->prepare($sql);
            $query->bindValue(':auid', $author_id, PDO::PARAM_INT);
            $query->execute() or die(print_r($query->errorInfo()));

            $files = $query->fetchColumn();

            $query->closeCursor();

            return $files;

         }

        


    }
