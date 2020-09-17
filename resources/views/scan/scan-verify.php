<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
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
            <a href="'. APP_URL . '">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        if(!isset($_POST['location'])){
            header('Location: ' . APP_URL);
        }else{
            echo '<div class="section scan-page-verify">';
            $stmt = $pdo->prepare('SELECT name FROM students WHERE icNo = ? LIMIT 1');
            $identification = $_POST['identification'];
            $stmt->execute([$identification]);
            $student = $stmt->fetch();
            if(!$student)
            {
                die('<div class="scan-scan-err">
                <p>Pelajar Tidak Dijumpai</p>
                <a href="' . APP_URL . '/scan' . '">Kembali</a>
            </div>');
            }
        echo '
            <div class="scan-page-verify-item-container">
                <form action="' . APP_URL .'/includes/scan-verify-handler.php" method="POST">
                    <div class="scan-page-verify-details">
                        <table>
                            <tr class="verify-status-column-header">
                                <th class="verify-details-header"><h1>NAMA</h1></th>
                                <th class="verify-details-header"><h1>NO KAD PENGENALAN</h1></th>
                            </tr>
                            <tr class="verify-status-column-data">
                                <!-- User name will be fetch from database based from icNo -->';
                                    #Verifies if the user is still available, hope this works. Okay the SQL conditional <= may not work..LEL
                                    $stmt = $pdo->prepare('SELECT name FROM students WHERE icNo = ?');
                                    $identification = $_POST['identification'];
                                    $stmt->execute([$identification]);
                                    $student = $stmt->fetch();
        echo '
                                <td><p>'. strtoupper($student['name']) . '</p></td>
                                <td><input type="text" name="icNo" id="icNo" value="' . $_POST['identification'] . '" class="verify-info-input"></p></td>
                            </tr>
                            <tr class="verify-status-column-header">
                                <th class="verify-details-header"><h1>LOKASI</h1></th>
                                <th class="verify-details-header"><h1>WAKTU</h1></th>
                            </tr>
                            <tr class="verify-status-column-data">
                                <!-- Location will be based on locationID from DB -->';
                                    $stmt = $pdo->prepare('SELECT name FROM locations WHERE id = ? LIMIT 1');
                                    $location = $_POST['location'];
                                    $stmt->execute([$location]);
                                    $location = $stmt->fetch();
        echo '
                                <td><p><input type="text" name="location" id="location" value="' . strtoupper($location['name']) . '" class="verify-info-input"></p></td>
                                <td><p><input type="text" name="time" id="time" value="" class="verify-info-input"></p></td>
                            </tr>
                            <tr class="verify-status-row">
                                <th>TARIKH</th>
                                <td><input type="text" name="date" id="date" value="" class="verify-info-input"></td>
                            </tr>
                            <tr class="verify-status-row">
                                <th>STATUS</th>';
                                    $status = $_POST['status'];
                                    if ($status == 1) {
                                        $statusDisplay = 'MASUK';
                                    }elseif($status == 2){
                                        $statusDisplay = 'KELUAR';
                                    }else{
                                        $statusDisplay = 'N/A';
                                    };
        echo '
                                <td><input type="text" name="status" id="status" value="' . $statusDisplay .'" class="verify-info-input"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="scan-page-verify-temperature">
                            <input type="float" name="temperature" id="temperature" placeholder="Masukkan suhu disini" inputmode="numeric" required>
                            <button type="submit" name="submit" class="scan-page-verify-confirm">SAHKAN</button>
                    </div>
                </form>
                <script src="' . stuse::js('time') . '"></script>
                <script>
                    document.getElementById("time").value = currentTime; 
                    document.getElementById("date").value = currentDate;
                </script>
            </div>
        </div>';
        }
    }
?>
