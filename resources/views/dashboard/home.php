<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
define("TITLE", "Dashboard");
stuse::template('dashboard/header');
?>
<?php
    if(!isset($_SESSION['username'])){
        echo '<div class="login-status">
                <p>SILA LOG MASUK</p>
                <a href="/dashboard/user/login">LOG MASUK</a>
            </div>';
    }elseif($_SESSION['urole'] != 1){
        echo '<div class="login-status">
            <p>ANDA TIADA AKSES PADA HALAMAN INI</p>
            <a href="/">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        echo '<div class="home">
                <ul>
                <li><a href="/dashboard/student"><img src="' . stuse::imgSVG('student') . '" alt=""></a></li>
                <li><a href="/dashboard/location"><img src="' . stuse::imgSVG('location') . '" alt=""></a></li>
                <li><a href="/dashboard/user"><img src="' . stuse::imgSVG('user') . '" alt=""></a></li>
                </ul>
            </div>';
    }
?>
<?php
stuse::template('dashboard/footer');