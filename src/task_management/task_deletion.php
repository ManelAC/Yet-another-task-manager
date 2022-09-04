<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(!isset($_SESSION['active_user'])) {
        header("Location: ../index.php");
    }

    if(!isset($_POST['entry_to_delete'])) {
        header("Location: ./dashboard.php");
    }

    try {
        $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
        array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
      }
      catch(PDOException $exception) {
        $_SESSION['cant_connect_to_database'] = true;
        $exception->getMessage();
      }

    foreach($database_connection->query('select * from tasks') as $temp_row) {
        if($temp_row['tasks_id'] == $_SESSION['entry_to_delete']) {
            if($temp_row['tasks_user_id'] != $_SESSION['active_user_id']) {
                $_SESSION['not_allowed_to_delete'] = true;
                header("Location: ./dashboard.php");
            }
        }
    }

        

    try {
        $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
        array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }
    catch(PDOException $exception) {
        $_SESSION['cant_connect_to_database'] = true;
        $exception->getMessage();
    }

            
    $delete_statement = $database_connection->prepare("delete from tasks where tasks_id = :tasks_id");
    
    $delete_statement->execute(
        array(
            ':tasks_id' => $_SESSION['entry_to_delete']
        )
    );
    
    $database_connection = null;
    $_SESSION['entry_to_delete'] = null;

    $_SESSION['task_successfully_deleted'] = true;
    header("Location: ./dashboard.php");

?>
