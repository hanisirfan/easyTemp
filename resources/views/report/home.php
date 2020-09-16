<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
define("TITLE", "Laporan");
stuse::template('header');
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
        echo '<div class="section main">
                <div class="report-selection">
                    <div class="report-selection-option">
                        <a href="#normal">Paparan Biasa</a>
                        <a href="#pdf">Paparan PDF</a>
                    </div>
                </div>
                <div class="report-selection" id="normal">
                        <form action="/report/view.php" method="get">
                            <h1>Papar Laporan</h1>';
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
                            <input type="date" name="date" id="date">
                            <button type="submit">PAPAR</button>
                        </form>
                </div>
                <div class="report-selection" id="pdf">
                        <form action="/report/viewPDF.php" method="get">
                            <h1>Papar Laporan (PDF)</h1>';
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
                            <input type="date" name="date" id="date">
                            <button type="submit">PAPAR</button>
                        </form>
                    </div>
            </div>';
    }
?>
<?php
stuse::template('footer');