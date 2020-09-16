<?php
require_once(dirname(__DIR__, 4) . '/config.php');
require_once(dirname(__DIR__, 4) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 4) . '/includes/db.php');
define("TITLE", "Dashboard User");
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
        echo '<div class="dashboard-list">
        <h1>SENARAI PENGGUNA</h1>
        <div class="dashboard-list-table-wrapper">
            <table>
                <tr>
                    <th>ID</th>
                    <th>NAMA PENUH</th>
                    <th>NAMA PENGGUNA (USERNAME)</th>
                    <th>PERANAN</th>
                    <th></th>
                    <th></th> 
                </tr>';
                $stmt = $pdo->prepare('SELECT * FROM users');
                $stmt->execute();
                $fetchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($fetchs as $fetch){
                    if($fetch['role'] == 1){
                        $userRole = 'admin';
                    }elseif($fetch['role'] == 2){
                        $userRole = 'moderator';
                    }
                    echo "<tr>    
                        <td>" . strtoupper($fetch['id']) . "</td>
                        <td>" . strtoupper($fetch['fullname']) . "</td>
                        <td>" . strtoupper($fetch['username']) . "</td>
                        <td>" . strtoupper($userRole) . "</td>
                        <td><a href='" . APP_URL . "/dashboard/edit.php?type=user&id=" . $fetch['id'] . "&method=1'>SUNTING</a></td>
                        <td><a href='" . APP_URL . "/dashboard/edit.php?type=8user&id=" . $fetch['id'] . "&method=2'>PADAM</a></td>
                    </tr>";
                }
        echo '
                    </table>
                </div>
            </div>
            <div class="dashboard-add">';
            if(isset($_SESSION['error'])){
                echo '<div class="dashboard-add-error">
                            <p>' . $_SESSION['error'] . '</p>
                        </div>';
                unset($_SESSION['error']);
            }
        echo '
                <p>TAMBAH PENGGUNA</p>
                <form action="/includes/dashboard-handler.php" method="POST">
                    <input type="hidden" name="type" value="user" class="dashboard-input">
                    <input type="hidden" name="add" class="dashboard-input">
                    <input type="text" name="ufullname" id="ufullname" placeholder="NAMA PENUH PENGGUNA" required>
                    <input type="text" name="username" id="username" placeholder="NAMA PENGGUNA (USERNAME)" required>
                    <input type="password" name="upass" id="upass" placeholder="KATA LALUAN" required>
                    <input type="password" name="uconfirmpass" id="uconfirmpass" placeholder="ULANG KATA LALUAN" required>
                    <select name="urole" id="urole">
                        <option value="1">ADMIN</option>
                        <option value="2">MODERATOR</option>
                    </select>
                    <button type="submit" name="submit">TERUSKAN</button>
                </form>
                <ul id="password-complexity">
                    KATA LALUAN MESTI MEMENUHI KRITERIA KERUMITAN SEPERTI BERIKUT:
                    <li>PANJANG KATA LALUAN SEKURANGNYA 8 KARAKTER</li>
                    <li>SEKURANGNYA 1 KARAKTER BERIKUT: !@#$&*-_</li>
                    <li>SEKURANGNYA 1 NOMBOR</li>
                    <li>KOMBINASI HURUF BESAR DAN HURUF KECIL</li>
                </ul>
            </div>';
    }
?>
<?php
stuse::template('dashboard/footer');