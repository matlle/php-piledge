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

    class Files 
    {
    
    protected $errors = array();
    protected $ext;
    protected $file_id;
    protected $author_id;
    protected $file_title;
    protected $file_description;
    protected $file_type;
    protected $file_size;
    protected $file_name;
    protected $file_ext;
    protected $file_error;
    protected $file_tmp_name;
    protected $file_thumb_name;
    protected $file_pdf_name;
    protected $file_pages_number;
    protected $file_created_at;
    protected $file_updated_at;

    const TITLE_INVALID = 1;
    const DESCRIPTION_INVALID = 2;
    const TYPE_INVALID = 3;
    const SIZE_INVALID = 4;
    const NAME_INVALID = 5;
    const EXTENSION_INVALID = 6;

    const EXT_PDF = 1;
    const EXT_DOCX = 2;
    const EXT_DOC = 3;
    const EXT_TXT = 4;

    const MAXSIZE = 900000000;

    const PDF       = 'docs/pdf/';
    const THUMBNAIL = 'docs/thumbnails/';

    
    public function __construct(array $values) {
        
        if (!empty($values)) {
            $this->hydrate($values);
        }
    }

    public function hydrate($data) {

        foreach ($data as $key => $value) {

            $method = "set_" . "$key";

            if (method_exists($this, $method)) {

                $this->$method($value);
            
            }

        }
    }
    

    public function isValid() {

        return !(empty($this->file_title) || empty($this->file_description) || empty($this->file_type) || empty($this->file_size) || empty($this->file_name));
    }
   

   public function isNew() {

       return empty($this->file_id);

   }


   protected function byte_convert($size) {

       # size smaller then 1kb
       if ($size < 1024) return $size . ' Byte';
       # size smaller then 1mb
       if ($size < 1048576) return sprintf("%4.2f KB", $size/1024);
       # size smaller then 1gb
       if ($size < 1073741824) return sprintf("%4.2f MB", $size/1048576);
       # size smaller then 1tb
       if ($size < 1099511627776) return sprintf("%4.2f GB", $size/1073741824);
       # size larger then 1tb
      else return sprintf("%4.2f TB", $size/1073741824);

    }


   protected function get_number_Pages($document)  {

        $cmd = "/usr/bin/pdfinfo";          // Linux
        //$cmd = "C:\\location\\pdfinfo.exe"; // Windows

        // Parse entire output
        exec("$cmd \"$document\"", $output);

        // Iterate through lines
        $pagecount = 0;
        foreach($output as $op) {

            // Extract the number
            if(preg_match("/Pages:\s*(\d+)/i", $op, $matches) === 1) {
                $pagecount = intval($matches[1]);
                break;
            }
        }

       return $pagecount;
    }

    
 /* -------------------- GETTERS AND SETTERS ---------------------------- */
    
    public function get_file_id() {

        return $this->file_id;
    }


    public function set_file_id($id) {

        $this->file_id = (int) $id;
    }


    public function get_author_id() {

        return $this->author_id;
    }


    public function set_author_id($authorId) {
    
        $this->author_id = (int) $authorId;

    }


    public function get_file_title() {

        return $this->file_title;
    }
    

    public function set_file_title($fileTitle) {
        
        $fileTitle = (string) $fileTitle;

        if (empty($fileTitle) AND (strlen($fileTitle) > 15)) {

            $this->errors[] = self::TITLE_INVALID;

        } else {
            $this->file_title = $fileTitle;
        }
    }
    

    public function get_file_description() {

        return $this->file_description;

    }
    

    public function set_file_description($fileDescription) {
        
        $fileDescription = (string) $fileDescription;

        if (empty($fileDescription) AND strlen($fileDescription) > 250) {
            
            $this->errors[] = self::DESCRIPTION_INVALID;

        } else {
            $this->file_description = $fileDescription;
        }

    }
    
    
    public function get_file_type() {

        return $this->file_type;
    }


    public function set_file_type($fileType) {

        $allow_ext = array('docx', 'pdf');
        $info = pathinfo($fileType);
        $upload_ext = $info['extension'];


        if(empty($fileType) || !(in_array($upload_ext, $allow_ext))) {

            $this->errors[] = self::TYPE_INVALID;

        } else {

            $this->file_type = $fileType;
        }
    }

   
    public function get_file_size() {

        return $this->file_size;
    }

    
    public function set_file_size($fileSize) {

        if (empty($fileSize) || $fileSize < 0 || $fileSize > self::MAXSIZE) {
            
            $this->errors[] = self::SIZE_INVALID;
            

        } else {
 
            $this->file_size = $this->byte_convert($fileSize);
        }


    }
    


    public function get_file_name() {

        return $this->file_name;
    }
    

    public function set_file_name($fileName) {
    
        if (empty($fileName) || !is_string($fileName)) {

            $this->errors[] = self::NAME_INVALID;
        
        } else {

            $this->file_name = (string) $fileName;
        }


    }

    

    public function get_file_ext() {
        
        return $this->file_ext;
    }

    
    public function set_file_ext($fileExt) {

        $info_file = pathinfo($fileExt);
        $fileExt = $info_file['extension'];

        if (empty($fileExt)) {

            $this->errors[] = self::EXTENSION_INVALID;
        
        } else {
            
            $this->file_ext = $fileExt;
        }

        if ($fileExt == 'pdf') {

            $this->ext = self::EXT_PDF;

        } elseif ($fileExt == 'docx') {
            $this->ext = self::EXT_DOCX;
        } elseif ($fileExt == 'doc') {
            $this->ext = self::EXT_DOC;
        } elseif ($fileExt == 'txt') {
            $this->ext = self::EXT_TXT;
        }
        
        
    }

    

    public function get_file_error() {

        return $this->file_error;
    }

    
    protected function set_file_error($fileError) {


        $fileError = (int) $fileError;

        if (!is_int($fileError)) {

            throw new RuntimeException('Error file unknown');

        } else {

            $this->file_error = $fileError;
        }

    }


    public function get_file_tmp_name() {

        return $this->file_tmp_name;
    }

    
    protected function set_file_tmp_name($fileTmpName) {

        
        if (empty($fileTmpName) || !is_string($fileTmpName)) {
            
            throw new RuntimeException('Folder tmp is not present');
        
        } else {

            $this->file_tmp_name = $fileTmpName;
        }

    }
    
    
    
    
    public function get_file_thumb_name() {

        return $this->file_thumb_name;
    }


    public function set_file_thumb_name($fileThumbName) {

        $fileThumbName = self::THUMBNAIL . $fileThumbName . '.png';

        if (empty($fileThumbName) || !is_string($fileThumbName)) {
            
            throw new RuntimeException('File thumbnail is not given');
        
        } else {

            $this->file_thumb_name = $fileThumbName;
        }

    }


    public function get_file_pdf_name() {

        return $this->file_pdf_name;
    }


    public function set_file_pdf_name($filePdfName) {

        $filePdfName = self::PDF . $filePdfName;

        if (empty($filePdfName) || !is_string($filePdfName)) {

            throw new RuntimeException('File pdf name is not given');
        
        } else {

            $this->file_pdf_name = $filePdfName;
        }
    }


    public function get_file_pages_number() {

        return $this->file_pages_number;

    }
    

    public function set_file_pages_number($filePagesNumber) {

        $filePagesNumber =  $this->get_number_pages($filePagesNumber);

        if (!is_int($filePagesNumber) || $filePagesNumber <= 0) {

            throw new RuntimeException('File pdf pages number not given');
        
        } else {

            $this->file_pages_number = $filePagesNumber;
        }
    }
     


    public function get_file_created_at() {

        return $this->file_created_at;
    }


    public function set_file_created_at($fileCreatedAt) {

        $this->file_created_at = $fileCreatedAt;

    }


    public function get_file_updated_at() {

        return $this->file_updated_at;
    }

    
    public function set_file_updated_at($fileUpdatedAt) {

        $this->file_updated_at = $fileUpdatedAt;
    }


    public function get_errors() {

        return $this->errors;
    }

    public function get_ext() {

        return $this->ext;
    }
    




}
