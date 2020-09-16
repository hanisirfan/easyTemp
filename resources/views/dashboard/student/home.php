<?php
require_once(dirname(__DIR__, 4) . '/config.php');
require_once(dirname(__DIR__, 4) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 4) . '/includes/db.php');
define("TITLE", "Dashboard Pelajar");
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
        <h1>SENARAI PELAJAR</h1>
        <div class="dashboard-list-table-wrapper">
            <table>
                <tr>
                    <th>NAMA</th>
                    <th>JANTINA</th>
                    <th>DORM</th>
                    <th>KELAS</th>
                    <th></th>
                    <th></th>
                </tr>';
                $stmt = $pdo->prepare('SELECT * FROM students');
                $stmt->execute();
                $fetchs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($fetchs as $fetch){
                    echo "<tr>    
                        <td>" . strtoupper($fetch['name']) . "</td>
                        <td>" . strtoupper($fetch['gender']) . "</td>
                        <td>" . strtoupper($fetch['dormCode']) . "</td>
                        <td>" . strtoupper($fetch['classCode']) . "</td>
                        <td><a href='" . APP_URL . "/dashboard/edit.php?type=student&id=" . $fetch['icNo'] . "&method=1'>SUNTING</a></td>
                        <td><a href='" . APP_URL . "/dashboard/edit.php?type=student&id=" . $fetch['icNo'] . "&method=2'>PADAM</a></td>
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
                    <p>TAMBAH PELAJAR</p>
                    <form action="/includes/dashboard-handler.php" method="POST">
                        <input type="hidden" name="type" value="student" class="dashboard-input">
                        <input type="hidden" name="add" class="dashboard-input">
                        <input type="text" name="id" id="" placeholder="NO KAD PENGENALAN" inputmode="numeric" required>
                        <input type="text" name="name" id="" placeholder="NAMA PENUH" required>
                        <input type="text" name="gender" id="" placeholder="JANTINA" required>
                        <input type="text" name="dorm" id="dorm" placeholder="KOD DORM" required>
                        <input type="text" name="class" id="class" placeholder="KOD KELAS" required>
                        <button type="submit" name="submit">TERUSKAN</button>
                    </form>
                </div>';
    }
?>
<?php
stuse::template('dashboard/footer');