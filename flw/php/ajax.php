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
  

include('AuthorsManager.class.php');
include('Followers.class.php');
include('FollowersManager.class.php');
include('DBFactory.class.php');
include('functions.php');

session_start();
//$userid = 2;

$db = DBFactory::PgDAO();
$amanager = new AuthorsManager($db);
$fomanager = new FollowersManager($db);

$author_id = $amanager->get_session_id();


	if(isset($_GET['r'])) { 
		## Execute functions as per the request
		$r = clean_input($_GET['r']);
			## Executing the user follow request over here.
			if($r == 'follow_user') {
				if(isset($_GET['token']) && isset($_GET['follow_id'])) {
					$token = clean_input($_GET['token']);
					$follow_id = intval($_GET['follow_id']);
						if(!empty($token) && !empty($follow_id)) {
							if(isset($_SESSION['token']) && $token == $_SESSION['token']) {
								if($follow_id != $author_id) {
									if($fomanager->is_follower($follow_id) == false) {
										echo 'success, You are following this user now.';

                                        $follower = new Followers(array(
                                                                   'author_id' => $author_id,
                                                                   'follower_id' => $follow_id
                                                                   ));

                                       if ($follower->isValid()) {

                                            $fomanager->add_follower($follower);

                                        } else {
                                            echo 'Adding follower is failed';
                                        }

									} else {
										echo 'success,You are already following this user.';
									}
								} else {
									echo 'error,You cannot follow yourself.';		
								}
							} else {
								echo 'error,Invalid request made.';
							}
						} else {
							echo 'error,Invalid request made.';
						}
				} else {
					echo 'error,Invalid request made.';
				}
			}

			## Executing the user unfollow request over here.
			if($r == 'unfollow_user') {
				if(isset($_GET['token']) && isset($_GET['unfollow_id'])) {
					$token = clean_input($_GET['token']);
					$unfollow_id = intval($_GET['unfollow_id']);
						if(!empty($token) && !empty($unfollow_id)) {
							if(isset($_SESSION['token']) && $token == $_SESSION['token']) {
								if($unfollow_id != $author_id) {
									echo 'success, you are unfollowing this user now.';
                                   //$fomanager->unfollow($author_id, $unfollow_id);

                                    $sql = 'DELETE FROM user_followers
                                            WHERE author_id = :aid AND follower_id = :foid
                                           ';

                                    $query = $db->prepare($sql);
                                    $query->bindValue(':aid', $author_id, PDO::PARAM_INT);
                                    $query->bindValue(':foid', $unfollow_id, PDO::PARAM_INT);
                                    $query->execute() or die(print_r($query->errorInfo()));

                                    $query->closeCursor();


                                
								} else {
									echo 'error,You cannot unfollow yourself.';		
								}
							} else {
								echo 'error,Invalid request made.';
							}
						} else {
							echo 'error,Invalid request made.';
						}
				} else {
					echo 'error,Invalid request made.';
				}
			}
	}
