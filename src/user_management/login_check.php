<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(isset($_SESSION['active_user'])) {
        header("Location: ../task_management/dashboard.php");
    }

    if(!does_user_already_exist($_POST['username'])) {
        $_SESSION['username_doesnt_exist'] = true;
        $_SESSION['used_username'] = $_POST['username'];

        header("Location: ./login.php");
    }
    else {
        $_SESSION['username_doesnt_exist'] = null;
        $_SESSION['used_username'] = $_POST['username'];

        $_SESSION['cant_connect_to_database'] = null;

        try {
            $database_connection = new PDO('mysql:host='.get_server_information().';dbname='.get_database_name().'', ''.get_database_user_name().'', ''.get_database_user_password().'', 
            array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $exception) {
            $_SESSION['cant_connect_to_database'] = true;
            $exception->getMessage();
            header("Location: ./login.php");
        }

        //$hashed = $database_connection->query('select users_password from users where users_username = '.$_POST['username'].'')->fetchColumn();

        foreach($database_connection->query('select * from users') as $row) {
            if($row['users_username'] == $_POST['username']) {
                $hashed = $row['users_password'];
            }
        }

        if(!password_verify($_POST['password'], $hashed)) {
            $_SESSION['wrong_password'] = true;

            header("Location: ./login.php");
        }
        else {
            $_SESSION['active_user'] = $_POST['username'];

            header("Location: ../task_management/dashboard.php");
        }

    }
?>
