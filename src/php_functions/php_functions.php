<?php
  function get_server_information() {
    return "localhost";
  }

  function get_database_name() {
    return "yet_another_task_manager";
  }

  function get_database_user_name() {
    return "yatm_user";
  }

  function get_database_user_password() {
    return "this_is_a_secure_password";
  }

  function does_user_already_exist($user) {
    session_start();
    $_SESSION['cant_connect_to_database'] = null;

    try {
      $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
      array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $exception) {
      session_start();
      $_SESSION['cant_connect_to_database'] = true;
      $exception->getMessage();
    }

    $counter = 0;

    foreach($database_connection->query('select * from users') as $row) {
      if($row['users_username'] == $user){
        $counter++;
      }
    }

    if($counter > 0) {
      return true;
    }
    else {
      return false;
    }

  }

  function is_email_already_in_use($email) {
    session_start();
    $_SESSION['cant_connect_to_database'] = null;

    try {
      $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
      array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $exception) {
      $_SESSION['cant_connect_to_database'] = true;
      $exception->getMessage();
    }

    $counter = 0;

    foreach($database_connection->query('select * from users') as $row) {
      if($row['users_email'] == $email){
        $counter++;
      }
    }

    if($counter > 0) {
      return true;
    }
    else {
      return false;
    }

  }

?>
