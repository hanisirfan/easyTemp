<?php
require_once(dirname(__DIR__, 4) . '/config.php');
require_once(dirname(__DIR__, 4) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 4) . '/includes/db.php');
define("TITLE", "Dashboard Lokasi");
stuse::template('dashboard/header');
?>
<?php
    if(!isset($_SESSION['username'])){
        echo '<div class="login-status">
                <p>SILA LOG MASUK</p>
                <a href="' . APP_URL .'/dashboard/user/login">LOG MASUK</a>
            </div>';
    }elseif($_SESSION['urole'] != 1){
        echo '<div class="login-status">
            <p>ANDA TIADA AKSES PADA HALAMAN INI</p>
            <a href="' . APP_URL . '">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        echo '<div class="dashboard-list">
                <h1>SENARAI LOKASI</h1>
                <div class="dashboard-list-table-wrapper">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>NAMA</th>
                            <th></th>
                            <th></th>
                        </tr>';
                        $stmt = $pdo->prepare('SELECT * FROM locations');
                        $stmt->execute();
                        $fetchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach($fetchs as $fetch){
                            echo "<tr>    
                                <td>" . strtoupper($fetch['id']) . "</td>
                                <td>" . strtoupper($fetch['name']) . "</td>
                                <td><a href='" . APP_URL . "/dashboard/edit.php?type=location&id=" . $fetch['id'] . "&method=1'>SUNTING</a></td>
                                <td><a href='" . APP_URL . "/dashboard/edit.php?type=location&id=" . $fetch['id'] . "&method=2'>PADAM</a></td>
                            </tr>";
                        }
        echo '      </table>
                </div>
            </div>
            <div class="dashboard-add">
                <p>TAMBAH LOKASI</p>
                <form action="' . APP_URL .'/includes/dashboard-handler.php" method="POST">
                    <input type="hidden" name="type" value="location" class="dashboard-input">
                    <input type="hidden" name="add" class="dashboard-input">
                    <input type="text" name="name" id="name" placeholder="NAMA LOKASI" required>
                    <button type="submit" name="submit">TERUSKAN</button>
                </form>
            </div>';
    }
?>
<?php
stuse::template('dashboard/footer');