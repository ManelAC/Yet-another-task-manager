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

    if(!isset($_SESSION['active_user'])) {
        header("Location: ../index.php");
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
                    echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                    echo ''.$_SESSION['active_user'].' <img src="../../assets/user.png" width="24" height="24" class="d-inline-block align-top" alt=""></a>';
                    echo '<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">';
                    echo '<a class="dropdown-item" href="./dashboard.php">Go to the dashboard</a>';
                    echo '<a class="dropdown-item" href="../user_management/logout.php">Log out</a>';
                    echo '</div>';
                ?>
            </li>
        </ul>
    </div>

    </nav>
    </header>

    <!-- Begin page content -->
    <main role="main" class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-5 text-center">Pending tasks</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <div class="row mt-3"><a class="btn btn-primary" href="./new_task.php" role="button">New task</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./pending_tasks.php" role="button">Pending tasks</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./finished_tasks.php" role="button">Finished tasks</a></div>
                <div class="row mt-3"><a class="btn btn-primary" href="./Dashboard.php" role="button">Dashboard</a></div>
            </div>
            <div class="col-10">
                <?php
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


                    echo "<table class=\"table table-hover mt-3\">";
				    echo "<tr><th>Description</th><th>Start date</th><th>End date</th><th>Category</th><th>State</th></tr>";

                    foreach($database_connection->query('select tasks_id, tasks_description, tasks_start_date, tasks_end_date, tasks_category, tasks_state from tasks
                    where tasks_user_id = '.$_SESSION['active_user_id'].' and tasks_state < 3 order by tasks_end_date') as $row) {
                        echo '<tr>';
                        echo '<td>'.$row['tasks_description'].'</td>';
                        echo '<td>'.date("d/m/Y", strtotime($row['tasks_start_date'])).'</td>';
                        echo '<td>'.date("d/m/Y", strtotime($row['tasks_end_date'])).'</td>';

                        if($row['tasks_category'] == 1) {
                            echo '<td>Personal</td>';
                        }
                        else if($row['tasks_category'] == 2) {
                            echo '<td>Work</td>';
                        }

                        if($row['tasks_state'] == 1) {
                            echo '<td>To do</td>';
                        }
                        else if($row['tasks_state'] == 2) {
                            echo '<td>In progress</td>';
                        }

                        echo '<td><a class="btn btn-primary" href="./edit_task.php" role="button">Edit task</a></td>';
                        
                        echo '</tr>';
                    }

                    echo "</table>";

                    $database_connection = null;
                ?>
            </div>
        </div>
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
