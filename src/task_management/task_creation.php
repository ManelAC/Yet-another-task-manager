<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(isset($_SESSION['active_user'])) {
        header("Location: ../task_management/dashboard.php");
    }

    $_SESSION['task_successfully_created'] = null;
    $can_create_task = true;

    if(strlen($_POST["description"]) > 200) {
        $_SESSION['description_too_long'] = true;
        $can_create_task = false;
    }
    else{
        $_SESSION['description_too_long'] = null;
    }

    if(strlen($_POST["description"]) < 3) {
        $_SESSION['description_too_short'] = true;
        $can_create_task = false;
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
        $can_create_task = false;
    }
    else {
        $_SESSION['wrong_dates'] = null;
    }



    if($can_create_task) {
        $_SESSION['task_successfully_created'] = true;

        try {
            $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
            array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $exception) {
            $_SESSION['cant_connect_to_database'] = true;
            $exception->getMessage();
        }

        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $insert_statement = $database_connection->prepare("insert into tasks(tasks_description, tasks_explanation, tasks_start_date, tasks_end_date, tasks_category, tasks_state, tasks_user_id)
            values
			(:tasks_description, :tasks_explanation, :tasks_start_date, :tasks_end_date, :tasks_category, :tasks_state, :tasks_user_id)");

        $insert_statement->execute(
            array(
                ':tasks_description' => $_POST['description'], 
                ':tasks_explanation' => $_POST['explanation'], 
                ':tasks_start_date' => $_POST['start_date'],
                ':tasks_end_date' => $_POST['end_date'], 
                ':tasks_category' => $_POST['category'], 
                ':tasks_state' => $_POST['state'],
                ':tasks_user_id' => $_SESSION['active_user_id']
            )
        );

        $_SESSION['form_description'] = null;
        $_SESSION['form_start_date'] = null;
        $_SESSION['form_end_date'] = null;
        $_SESSION['form_category'] = null;
        $_SESSION['form_state'] = null;
        $_SESSION['form_explanation'] = null;

        header("Location: ./dashboard.php");
    }
    else {
        $_SESSION['form_description'] = $_POST['description'];
        $_SESSION['form_start_date'] = $_POST['start_date'];
        $_SESSION['form_end_date'] = $_POST['end_date'];
        $_SESSION['form_category'] = $_POST['category'];
        $_SESSION['form_state'] = $_POST['state'];
        $_SESSION['form_explanation'] = $_POST['explanation'];

        header("Location: ./new_task.php");
    }
?>
