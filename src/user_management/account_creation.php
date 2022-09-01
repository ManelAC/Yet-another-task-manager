<?php
    include '../php_functions/php_functions.php';

    session_start();

    $_SESSION['account_successfully_created'] = null;
    $can_create_user = true;

    if(strlen($_POST["username"]) > 100) {
        $_SESSION['username_too_long'] = true;
        $can_create_user = false;
    }
    else{
        $_SESSION['username_too_long'] = null;
    }

    if(strlen($_POST["username"]) < 3) {
        $_SESSION['username_too_short'] = true;
        $can_create_user = false;
    }
    else {
        $_SESSION['username_too_short'] = null;
    }

    if(does_user_already_exist($_POST['username'])) {
        $_SESSION['username_already_exists'] = true;
        $can_create_user = false;
    }
    else {
        $_SESSION['username_already_exists'] = null;
    }

    if(is_email_already_in_use($_POST['email'])) {
        $_SESSION['email_already_in_use'] = true;
        $can_create_user = false;
    }
    else {
        $_SESSION['email_already_in_use'] = null;
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
            session_start();
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