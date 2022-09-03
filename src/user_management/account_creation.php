<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(isset($_SESSION['active_user'])) {
        header("Location: ../task_management/dashboard.php");
    }

    $_SESSION['account_successfully_created'] = null;
    $can_create_user = true;
    $username_is_correct = true;
    $mail_is_correct = true;

    if(preg_match('/\s/', $_POST["username"])) {
        $_SESSION['username_contains_whitespaces'] = true;
        $can_create_user = false;
        $username_is_correct = false;
    }
    else{
        $_SESSION['username_contains_whitespaces'] = null;
    }

    if (!preg_match('/[A-Za-z0-9]/', $_POST["username"])) {
        $_SESSION['username_contains_non_allowed_characters'] = true;
        $can_create_user = false;
        $username_is_correct = false;
    }
    else{
        $_SESSION['username_contains_whitespaces'] = null;
    }

    if(strlen($_POST["username"]) > 100) {
        $_SESSION['username_too_long'] = true;
        $can_create_user = false;
        $username_is_correct = false;
    }
    else{
        $_SESSION['username_too_long'] = null;
    }

    if(strlen($_POST["username"]) < 3) {
        $_SESSION['username_too_short'] = true;
        $can_create_user = false;
        $username_is_correct = false;
    }
    else {
        $_SESSION['username_too_short'] = null;
    }

    if(does_user_already_exist($_POST['username'])) {
        $_SESSION['username_already_exists'] = true;
        $can_create_user = false;
        $username_is_correct = false;
    }
    else {
        $_SESSION['username_already_exists'] = null;
    }

    if($username_is_correct) {
        $_SESSION['correct_username'] = $_POST['username'];
    }
    else {
        $_SESSION['correct_username'] = null;
    }



    $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
    if (!preg_match ($pattern, $_POST['email']) ) {
        $_SESSION['mail_has_wrong_format'] = true;
        $can_create_user = false;
        $mail_is_correct = false;
    }
    else {
        $_SESSION['mail_has_wrong_format'] = null;
    }

    if(is_email_already_in_use($_POST['email'])) {
        $_SESSION['email_already_in_use'] = true;
        $can_create_user = false;
        $mail_is_correct = false;
    }
    else {
        $_SESSION['email_already_in_use'] = null;
    }
    if($mail_is_correct) {
        $_SESSION['correct_mail'] = $_POST['email'];
    }
    else {
        $_SESSION['correct_mail'] = null;
    }


    
    
    if(strlen($_POST['password']) < 8) {
        $_SESSION['password_too_short'] = true;
        $can_create_user = false;
    }
    else {
        $_SESSION['password_too_short'] = null;
    }

    if($can_create_user) {
        $_SESSION['account_successfully_created'] = true;

        try {
            $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
            array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $exception) {
            $_SESSION['cant_connect_to_database'] = true;
            $exception->getMessage();
        }

        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $insert_statement = $database_connection->prepare("insert into users(users_username, users_email, users_password)
            values
			(:users_username, :users_email, :users_password)");

        $insert_statement->execute(
            array(
                ':users_username' => $_POST['username'], 
                ':users_email' => $_POST['email'], 
                ':users_password' => $hashed_password
            )
        );
    }


    header("Location: ./create_account.php");
?>