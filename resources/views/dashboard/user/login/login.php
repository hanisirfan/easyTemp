<?php
require_once(dirname(__DIR__, 5) . '/config.php');
require_once(dirname(__DIR__, 5) . '/includes/auto-load.php');
define("TITLE", "Log Masuk Pengguna");
stuse::template('dashboard/header');
?>
<div class="dashboard-user-login">
    <h1>LOG MASUK PENGGUNA</h1>
    <?php
        if(isset($_SESSION['error'])){
            echo '<div class="dashboard-user-login-error">
                        <p>' . $_SESSION['error'] . '</p>
                    </div>';
            unset($_SESSION['error']);
        }
    ?>
    <form action="/includes/dashboard-handler.php" method="POST">
        <input type="hidden" name="type" value="user" class="dashboard-input">
        <input type="hidden" name="login" class="dashboard-input">
        <input type="text" name="username" id="username" placeholder="NAMA PENGGUNA (USERNAME)" required>
        <input type="password" name="upass" id="upass" placeholder="KATA LALUAN" required>
        <button type="submit" name="submit">LOG MASUK</button>
    </form>
</div>
<?php
stuse::template('dashboard/footer');