<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
define("TITLE", "Dashboard Sunting");
stuse::template('dashboard/header');
?>
<?php
/*
Id (studentIcNo or locationId)
Method (1=edit,2=delete,3=add)
*/
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
    if(!isset($_GET['type']) || !isset($_GET['id']) || !isset($_GET['method'])){
        echo 'Empty parameters';
    }elseif($_GET['type'] == 'student'){
        if($_GET['method'] == '1'){
            $stmt = $pdo->prepare('SELECT icNo,name,gender,dormCode,classCode FROM students WHERE icNo = ?');
            $stmt->execute([$_GET['id']]);
            $student = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<div class="dashboard-edit">
                    <p>SUNTING MAKLUMAT PELAJAR</p>
                    <p>NO KAD PENGENALAN: ' . $student['icNo'] . '</p>
                    <form action="' . APP_URL . '/includes/dashboard-handler.php" method="POST"> 
                        <input type="hidden" name="type" value="student" class="dashboard-input">
                        <input type="hidden" name="id" value="' . $_GET['id'] . '" class="dashboard-input">
                        <input type="hidden" name="edit" value="" class="dashboard-input">
                        <input type="text" name="name" id="name" class="dashboard-edit-input" placeholder="NAMA" value="' . $student['name'] . '" required>
                        <input type="text" name="gender" id="gender" class="dashboard-edit-input" placeholder="JANTINA" value="' . $student['gender'] . '" required>
                        <input type="text" name="dorm" id="dorm" class="dashboard-edit-input" placeholder="DORM" value="' . $student['dormCode'] . '" required>
                        <input type="text" name="class" id="class" class="dashboard-edit-input" placeholder="KELAS" value="' . $student['classCode'] . '" required>
                        <button type="submit" name="submit">TERUSKAN</button>
                    </form>
                </div>';
        }elseif($_GET['method'] == '2'){
            echo '<div class="dashbord-delete">
                    <p>ANDA PASTI MAHU MEMBUANG REKOD PELAJAR INI?</p>
                    <form action="' . APP_URL .'/includes/dashboard-handler.php" method="POST">
                        <input type="hidden" name="type" value="student" class="dashboard-input">
                        <input type="hidden" name="id" value="' . $_GET['id'] . '" class="dashboard-input">
                        <select name="delete" id="dashboard-delete-select">
                            <option value="1">YA</option>
                            <option value="2">TIDAK</option>
                        </select>
                        <button type="submit" name="submit">TERUSKAN</button>
                    </form>
                </div>';
        }
    }elseif($_GET['type'] == 'location'){
        if($_GET['method'] == '1'){
            $stmt = $pdo->prepare('SELECT id, name FROM locations WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $location = $stmt->fetch(PDO::FETCH_ASSOC);
            echo '<div class="dashboard-edit">
                    <p>SUNTING LOKASI INI</p>
                    <p>ID: '. $location['id'] . '</p>
                    <form action="/includes/dashboard-handler.php" method="POST"> 
                        <input type="hidden" name="type" value="location" class="dashboard-input">
                        <input type="hidden" name="id" value="' . $_GET['id'] . '" class="dashboard-input">
                        <input type="hidden" name="edit" value="" class="dashboard-input">
                        <input type="text" name="name" id="name" class="dashboard-edit-input" placeholder="NAMA" value="' . $location['name'] . '" required>
                        <button type="submit" name="submit">TERUSKAN</button>
                    </form>
                </div>';
        }elseif($_GET['method'] == '2'){
            echo '<div class="dashbord-delete">
                    <p>ANDA PASTI MAHU MEMBUANG REKOD LOKASI INI?</p>
                    <form action="' . APP_URL .'/includes/dashboard-handler.php" method="POST">
                        <input type="hidden" name="type" value="location" class="dashboard-input">
                        <input type="hidden" name="id" value="' . $_GET['id'] . '" class="dashboard-input">
                        <select name="delete" id="dashboard-delete-select">
                            <option value="1">YA</option>
                            <option value="2">TIDAK</option>
                        </select>
                        <button type="submit" name="submit">TERUSKAN</button>
                    </form>
                </div>';
        }
    }
}
?>
<?php
stuse::template('dashboard/footer');