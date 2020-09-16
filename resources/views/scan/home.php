<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
define("TITLE", "Imbas");
stuse::template('header');
?>
<?php
    if(!isset($_SESSION['username'])){
        echo '<div class="login-status">
                <p>SILA LOG MASUK</p>
                <a href="/dashboard/user/login">LOG MASUK</a>
            </div>';
    }elseif(!isset($_SESSION['urole'])){
        echo '<div class="login-status">
            <p>ANDA TIADA AKSES PADA HALAMAN INI</p>
            <a href="/">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        echo '<div class="section scan-page-index">
        <div class="scan-choose">
            <ul>
                <li><img src="' . stuse::imgSVG('keyboard') . '" alt="" id="scan-choose-manual"></li>
                <li><img src="' . stuse::imgSVG('barcode') . '" alt="" id="scan-choose-barcode"></li>
            </ul>
        </div>
        <div class="scan-manual">
            <div class="scan-back-btn">
                <p>Kembali</p>
            </div>
            <form action="/scan/verify.php" method="POST">
                <h1>Manual</h1>
                <input type="text" name="identification" id="identification" inputmode="numeric" required>
                <div class="location-status">
                    <!-- Will loop through all available locations from DB-->';
                    $stmt = $pdo->prepare('SELECT id,name FROM locations');
                    $stmt->execute();
                    $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '
                    <select name="location" id="location">';
                            foreach ($locations as $location) {
                                echo '<option value="' . $location['id'] .'">' . strtoupper($location['name']) .'</option>';
                            }
        echo '
                    </select>
                    <select name="status" id="status">
                        <option value="1">MASUK</option>
                        <option value="2">KELUAR</option>
                    </select>
                </div>
                <button type="submit" name="submit">Teruskan</button>
            </form>
        </div>
        <div class="scan-barcode">
            <form action="/scan/verify.php" method="POST" id="barcode-form">
                <div class="location-status">
                        <!-- Will loop through all available locations from DB-->
            ';
                        $stmt = $pdo->prepare('SELECT id,name FROM locations');
                        $stmt->execute();
                        $locations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo '
                        <select name="location" id="location">';
                                foreach ($locations as $location) {
                                    echo '<option value="' . $location['id'] .'">' . strtoupper($location['name']) .'</option>';
                                }
        echo '
                        </select>
                        <select name="status" id="status">
                            <option value="1">MASUK</option>
                            <option value="2">KELUAR</option>
                        </select>
                </div>
                <div class="scan-detected-identification">
                    <input type="text" name="identification" class="barcode-identification" value="">
                </div>
            </form>
            <div class="scan-back-btn-2">
                <p>Kembali</p>
            </div>
            <div class="scan-camera">
                <div class="barcode-scanner" id="barcode-scanner">
                    <video src=""></video>
                    <canvas class="drawingBuffer"></canvas>
                </div>
            </div>
        </div>
        <script src="' . stuse::js('time') . '"></script>
        <script src="' . stuse::js('scan') . '"></script>
        <script src="' . stuse::js('quagga.min') . '"></script>
        <script src="' . stuse::js('barcode') . '"></script>
    </div>';
    }
?>
<?php
stuse::template('footer');
?>

