<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(!isset($_SESSION['active_user'])) {
        header("Location: ../task_management/dashboard.php");
    }

    if(!isset($_POST['task_id'])) {
        header("Location: ../index.php");
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
        if($temp_row['tasks_id'] == $_POST['task_id']) {
            if($temp_row['tasks_user_id'] != $_SESSION['active_user_id']) {
                $_SESSION['not_allowed_to_edit'] = true;
                header("Location: ./dashboard.php");
            }
        }
    }

    $_SESSION['task_successfully_edited'] = null;
    $can_edit_task = true;

    if(strlen($_POST["description"]) > 200) {
        $_SESSION['description_too_long'] = true;
        $can_edit_task = false;
    }
    else{
        $_SESSION['description_too_long'] = null;
    }

    if(strlen($_POST["description"]) < 3) {
        $_SESSION['description_too_short'] = true;
        $can_edit_task = false;
    }
    else {
        $_SESSION['description_too_short'] = null;
    }

    if(strlen($_POST["explanation"]) > 2000) {
        $_SESSION['detailed_description_too_long'] = true;
        $can_create_task = false;
    }
    else{
        $_SESSION['detailed_description_too_long'] = null;
    }

    if($_POST['start_date'] > $_POST['end_date']) {
        $_SESSION['wrong_dates'] = true;
        $can_edit_task = false;
    }
    else {
        $_SESSION['wrong_dates'] = null;
    }



    if($can_edit_task) {
        $_SESSION['task_successfully_edited'] = true;

        try {
            $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
            array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $exception) {
            $_SESSION['cant_connect_to_database'] = true;
            $exception->getMessage();
        }

				
        $update_statement = $database_connection->prepare("update tasks set
            tasks_description = :tasks_description, 
            tasks_explanation = :tasks_explanation, 
            tasks_start_date = :tasks_start_date, 
            tasks_end_date = :tasks_end_date, 
            tasks_category = :tasks_category, 
            tasks_state = :tasks_state 
            where tasks_id = ".$_POST['task_id']."");
        
        $update_statement->execute(
            array(
                ':tasks_description' => $_POST['description'], 
                ':tasks_explanation' => $_POST['explanation'], 
                ':tasks_start_date' => $_POST['start_date'],
                ':tasks_end_date' => $_POST['end_date'], 
                ':tasks_category' => $_POST['category'], 
                ':tasks_state' => $_POST['state']
            )
        );
        
        $database_connection = null;
    }

    header("Location: ./edit_task.php?id=".$_POST['task_id']);

?>
