<?php
require_once(dirname(__DIR__, 2) . '/config.php');
require_once(dirname(__DIR__, 2) . '/includes/auto-load.php');
define("TITLE", "Laman Utama");
stuse::template('header');
?>
<div class="homepage">
    <h1>Selamat Datang Ke Aplikasi easyTemp</h1>
    <ul>
        <?php
        if(!isset($_SESSION['username'])){
            echo '<li><a href="./dashboard/user/login">Log Masuk</a></li>';
        }else{
            echo '
            <li><a href="./dashboard">Dashboard</a></li>
            <li><a href="./scan">Imbas</a></li>
            <li><a href="./report">Laporan</a></li>
            ';
        }
        ?>
    </ul>
</div>
<?php
stuse::template('footer');