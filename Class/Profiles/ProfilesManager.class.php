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


    class ProfilesManager 
    {
        protected $db;


        public function __construct(PDO $db) {

            $this->db = $db;

        }

        
        public function update_profile(Profile $profile) {

            $sql = 'INSERT INTO profiles
                       ( profile_first_name,
                         profile_last_name,
                         profile_gender,
                         profile_birthday,
                         profile_bio,
                         profile_country,
                         profile_region,
                         profile_profession,
                         profile_experience,
                         profile_create_at,
                         author_id)
                   VALUES
                       ( :first_name,
                         :last_name,
                         :gender,
                         :birthday,
                         :bio,
                         :country,
                         :region,
                         :profession,
                         :experience,
                         NOW(),
                         :author_id)
                   ';

           $query = $this->db->prepare($sql);
           $query->bindValue(':first_name', $profile->get_profile_first_name(), PDO::PARAM_STR);
           $query->bindValue(':last_name', $profile->get_profile_last_name(), PDO::PARAM_STR);
           $query->bindValue(':gender', $profile->get_profile_gender(), PDO::PARAM_STR);
           $query->bindValue(':birthday', $profile->get_profile_birthday(), PDO::PARAM_STR);
           $query->bindValue(':bio', $query->get_profile_bio(), PDO::PARAM_STR);
           $query->bindValue(':country', $query->get_profile_country(), PDO::PARAM_STR);
           $quey->bindValue(':region', $query->get_profile_profession(), PDO::PARAM_STR);
           $query->bindValue(':experience', $query->get_author_id(), PDO::PARAM_INT);
           $query->execute() or die(print_r($query->errorInfo()));

           $query->closeCursor();

        }


        public function is_first_name_valid($firstName) {
           $firstName = trim($firstName); 
           return (empty($firstName) || strlen($firstName) < 2 ) ? false : true;

        }


        public function is_last_name_valid($lastName) {
            $lastName = trim($lastName);
            return (empty($lastName) || strlen($lastName) < 2 ) ? false : true;
        }


        public function is_gender_valid($gender) {
        }
        

        public function is_birthday_valid($birthday) {
        }

        
        public function is_bio_valid($bio) {
            $bio = trim($bio);
            return (empty($bio) || strlen($bio) < 10) ? false : true;
        }


        public function is_country_valid($country) {
        }


        public function is_region_valid($region) {
        }


        public function is_profession_valid($profession) {
        }

        
        public function is_experience_valid($experience) {
            $experience = trim($experience);
            return (empty($experience) || strlen($experience) < 5 ) ? false : true;
        }



    }
