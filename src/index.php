<!doctype html>
<html lang="en-gb">

<head>
	<title>Yet another task manager</title>

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../assets/list.png">

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css">
	
	<!-- Custom styles for this template -->
	<link rel="stylesheet" href="https://getbootstrap.com/docs/4.1/examples/sticky-footer-navbar/sticky-footer-navbar.css">

</head>

<?php
	include './php_functions/php_functions.php';
?>

<body>
    <header>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-expand navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">YATM</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <?php
                    session_start();

                    // $_SESSION['previous_session'] = "true";

                    if(isset($_SESSION['previous_session'])){
                        index_navbar_session_isset();
                    }
                    else {
                        index_navbar_session_not_set();
                    }

                ?>
            </li>
        </ul>
    </div>

    </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <h1 class="mt-5">Yet another task manager</h1>
        <p class="lead">Log in or create a new account to use this application.</p>

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
