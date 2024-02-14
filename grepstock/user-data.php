<?php

 $userID = $review['userID'];
 $user_data_sql = "SELECT username, profilepicture FROM users WHERE userID = $userID";
 $user_data_result = $con->query($user_data_sql);
 $user_data = $user_data_result->fetch_assoc();
 $username = $user_data['username'];
 $profilepicture = $user_data['profilepicture'];

?>