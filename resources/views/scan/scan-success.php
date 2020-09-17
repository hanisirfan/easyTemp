<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
$title = 'Test';

stuse::template('header');

?>
<?php
if(!isset($_SESSION['username'])){
        echo '<div class="login-status">
                    <p>SILA LOG MASUK</p>
                    <a href="' . APP_URL .'/dashboard/user/login">LOG MASUK</a>
                </div>';
    }elseif(!isset($_SESSION['urole'])){
        echo '<div class="login-status">
            <p>ANDA TIADA AKSES PADA HALAMAN INI</p>
            <a href="' . APP_URL . '">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        echo '<div class="section scan-success">
            <div class="scan-success-container">
                <h1>Rekod telah dimasukkan!</h1>
                <div class="scan-success-option">
                    <div class="scan-success-home">
                        <a href="' . APP_URL .'">Kembali Ke Laman Utama</a>
                    </div>
                    <div class="scan-success-scan">
                        <a href="' . APP_URL . '/scan' . '">Buat Tambahan Rekod</a>
                    </div>
                </div>
            </div>
        </div>';
    }
?>
<?php
stuse::template('footer');