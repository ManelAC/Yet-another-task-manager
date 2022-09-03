<!doctype html>
<html lang="en-gb">

<head>
	<title>Yet another task manager</title>
    <link rel="icon" href="../../assets/list.png">

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sticky-footer-navbar/sticky-footer-navbar.css">

</head>

<?php
    include '../php_functions/php_functions.php';

    session_start();

    if(isset($_SESSION['active_user'])) {
        header("Location: ../task_management/dashboard.php");
    }
?>

<body>
    <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="../index.php">YATM</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <?php
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Log in or create an account</a>';
                    echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="./login.php">Log in</a>';
                    echo '<a class="dropdown-item" href="./create_account.php">Create account</a>';
                    echo '</div>';
                ?>
            </li>
        </ul>
    </div>
    </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <h1 class="mt-5">Create account</h1>
        
        <?php
            session_start();

            if(isset($_SESSION["username_contains_whitespaces"])) {
                echo '<div class="alert alert-danger" role="alert">The username can\'t contain whitespaces.</div>';
            }
            if(isset($_SESSION["username_contains_non_allowed_characters"])) {
                echo '<div class="alert alert-danger" role="alert">The username can only contain the following characters: a-z, A-Z, 0-9</div>';
            }
            if(isset($_SESSION["username_too_long"])) {
                echo '<div class="alert alert-danger" role="alert">The username is too long. The maximum length is 100.</div>';
            }
            if(isset($_SESSION["username_too_short"])) {
                echo '<div class="alert alert-danger" role="alert">The username is too short. The minimum length is 3.</div>';
            }
            if(isset($_SESSION["username_already_exists"])) {
                echo '<div class="alert alert-danger" role="alert">The username is already in use. Pick a different one.</div>';
            }
            if(isset($_SESSION["mail_has_wrong_format"])) {
                echo '<div class="alert alert-danger" role="alert">The email has a wrong format.</div>';
            }
            if(isset($_SESSION["email_already_in_use"])) {
                echo '<div class="alert alert-danger" role="alert">The email is already in use. Pick a different one.</div>';
            }
            if(isset($_SESSION['password_too_short'])) {
                echo '<div class="alert alert-danger" role="alert">The password is too short. The minimum length is 8.</div>';
            }
            if(isset($_SESSION['cant_connect_to_database'])) {
                echo '<div class="alert alert-danger" role="alert">Can\'t connect to database. Please open an issue on the GitHub repository.</div>';
            }
            if(isset($_SESSION['account_successfully_created'])) {
                echo '<div class="alert alert-success" role="alert">The account was succesfully created. You can <a href="./login.php" class="alert-link">log in</a> now.</div>';
            }
            
            session_destroy();
        ?>

        <form action="./account_creation.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="username_help" placeholder="Enter username" required autocomplete="on" value="<?php echo $_SESSION['correct_username'] ?>">
                <small id="username_help" class="form-text text-muted">Username must be at least 3 characters long.</small>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email" required autocomplete="on" value="<?php echo $_SESSION['correct_mail'] ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="password_help" placeholder="Enter password" required>
                <small id="password_help" class="form-text text-muted">Password must be at least 8 characters long.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>

    <footer class="footer">
    <div class="container">
        <span class="text-muted">On <a href="https://github.com/ManelAC/Yet-another-task-manager">GitHub</a> by @ManelAC</span>
    </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
</body>
</html>
