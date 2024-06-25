<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sidebar Navigation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            min-width: 250px;
            max-width: 250px;
            background-color: #343a40;
            padding: 15px;
            height: 100vh;
            position: fixed;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px 0;
        }
        .sidebar a.active {
            background-color: #495057;
        }
        .content {
            margin-left: 270px; /* width of sidebar + some margin */
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="navbar-brand text-white">Welcome, <?php echo isset($_SESSION['Username']) ? $_SESSION['Username'] : 'Guest'; ?>!</div>
    <ul class="navbar-nav">
        <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="index.php">List</a>
        </li>
        <li class="nav-item <?php echo ($current_page == 'livesearch.php' OR $current_page == 'update.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="livesearch.php">Tenant List</a>
        </li>
        <li class="nav-item <?php echo ($current_page == 'register.php' OR $current_page == 'update.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="register.php">Register</a>
        </li>
        <li class="nav-item <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
            <a class="nav-link" href="logout.php">Logout</a>
        </li>
    </ul>
</div>

<div class="content">
    <!-- Page content goes here -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

