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


    class Profiles
    {
        protected $profile_id;
        protected $profile_first_name;
        protected $profile_last_name;
        protected $profile_gender;
        protected $profile_birthday;
        protected $profile_bio;
        protected $profile_country;
        protected $profile_region;
        protected $profile_profession;
        protected $profile_experience;
        protected $author_id;
        protected $profile_created_at;
        protected $profile_updated_at;


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

            return !(empty($this->profile_first_name) && empty($this->profile_last_name) && empty($this->profile_gender) && empty($this->profile_birthday) && empty($this->profile_bio) && empty($this->profile_country) && empty($this->profile_region) && empty($this->profile_profession) && empty($this->profile_expererience));

        }




       
       /* ------------------------ GETTER AND SITTERS ----------------------------------- */



       public function get_profile_id() {

           return $this->profile_id;

       }

       public function set_profile_id($id) {

           $this->profile_id = (int) $id;

       }


       public function get_author_id() {

           return $this->author_id;

       }


       public function set_author_id($autor_id) {

           $this->author_id = (int) $author_id;

       }

       

       public function get_profile_first_name() {
           
           return $this->profile_first_name;

       }

       public function set_profile_first_name($first_name) {

           $this->profile_first_name = (string) $first_name;

       }

       

       public function get_profile_last_name() {
           
           return $this->profile_last_name;     

       }

       public function set_profile_last_name($last_name) {

           $this->profile_last_name = (string) $last_name;

       }


       public function get_profile_gender() {

           return $this->profile_gender;

       }

       public function set_profile_gender($gender) {

           $this->profile_gender = (string) $gender;

       }


       
       public function get_profile_birthday() {
       
           return $this->profile_birthday;

       }

       public function set_profile_birthday($birthday) {

           $this->profile_birthday = (string) $birthday;

       }


      
       public function get_profile_bio() {

           return $this->profile_bio;

       }

       public function set_profile_bio($bio) {

           $this->profile_bio = (string) $bio;

       }




       public function get_profile_country() {

           return $this->profile_country;       

       }

       public function set_profile_country($country) {

           $this->profile_country = (string) $country;

       }
        

       
       public function get_profile_region() {

           return $this->profile_region;

       }

       public function set_profile_region($region) {

           $this->profile_region = (string) $region;

       }



       public function get_profile_profession() {

           return $this->profile_profession;

       }


       public function set_profile_profession($profession) {

           $this->profile_profession = (string) $profession;

       }



       public function get_profile_experience() {

           return $this->profile_experience;

       }

       public function set_profile_experience($experience) {

           $this->profile_experience = (string) $experience;

       }




    }
