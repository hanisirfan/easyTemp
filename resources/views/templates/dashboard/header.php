<?php
session_start();
//idk why there's two header templates
require_once(dirname(__DIR__, 4) . '/config.php');
require_once(dirname(__DIR__, 4) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 4) . '/includes/db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php stuse::css('dashboard');?>">
    <link rel="stylesheet" href="<?php stuse::css('style');?>">
    <title><?php echo APP_NAME . ' | '  . TITLE?></title>
</head>
<body>
<div class="hamburger-menu">
    <div class="hamburger-lines"></div>
    <div class="hamburger-lines"></div>
    <div class="hamburger-lines"></div>
</div>
<div class="header">
    <div class="header-title">
        <a href="<?php echo APP_URL?>"><?php echo APP_NAME?></a>
    </div>
    <nav>
        <ul>
            <li><a href="<?php echo APP_URL?>">Laman Utama</a></li>
            <li><a href="<?php echo APP_URL . '/dashboard'?>">Dashboard</a></li>
            <li><a href="<?php echo APP_URL . '/scan'?>">Imbas</a></li>
            <li><a href="<?php echo APP_URL . '/report'?>">Laporan</a></li>
        </ul>
    </nav>
    <div class="user">
        <?php
            if(!isset($_SESSION['username'])){
                echo '<div class="user-logged-out">
                        <a href="' . APP_URL . '/dashboard/user/login">LOG MASUK</a>
                    </div>';
            }elseif(isset($_SESSION['username'])){
                echo '<div class="user-logged-in">
                <p>LOG MASUK SEBAGAI: <strong>' . $_SESSION['username'] .  '</strong></p>
                    <form action="' . APP_URL . '/includes/dashboard-handler.php" method="POST">
                        <input type="hidden" name="type" value="user" class="dashboard-input">
                        <input type="hidden" name="logout" class="dashboard-input">
                        <button type="submit" name="submit">LOG KELUAR</button>
                    </form>
                </div>';
            }
        ?>
    </div>
</div>
<script src="<?php echo stuse::js('header');?>"></script>
    
