<?php
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
require_once(dirname(__DIR__, 3) . '/includes/auto-load.php');
define("TITLE", "Laporan Biasa");
stuse::template('header');
?>
<?php
    if(!isset($_SESSION['username'])){
        echo '<div class="login-status">
                    <p>SILA LOG MASUK</p>
                    <a href="' . APP_URL . '/dashboard/user/login">LOG MASUK</a>
                </div>';
    }elseif($_SESSION['urole'] != 1){
        echo '<div class="login-status">
            <p>ANDA TIADA AKSES PADA HALAMAN INI</p>
            <a href="' . APP_URL . '">KEMBALI KE LAMAN UTAMA</a>
        </div>';
    }else{
        echo '<div class="section report-view">';
            if(!isset($_GET['location']) || !isset($_GET['date'])){
                echo '<style>.view-title,.report-view-table{display:none;}</style>';
                echo '<div class="report-view-error">--
                    <p>Parameter <strong>location</strong> atau <strong>date</strong> tidak diterima!</p>
                    </div>';
            }else{
                $stmt = $pdo->prepare('SELECT name FROM locations WHERE id = ?');
                $stmt->execute([$_GET['location']]);
                $location = $stmt->fetch();
                $locationName = $location['name'];
                echo '  <div class="view-title">
                            <h1>REKOD SUHU PELAJAR</h1>
                                <p class="view-location"> <strong>LOKASI</strong>:
                                ' . strtoupper($locationName) . '
                                </p>
                                <p class="view-date"> <strong>TARIKH</strong>:
                                ' . $_GET['date'] . '
                                </p>
                                <p class="view-disclaimer">
                                    Rekod akan dikemaskini secara automatik setiap 10 saat
                                </p>
                        </div>';
            };
        echo '<!-- Will display reports based on date from GET request and will be updated in real time with AJAX(FetchAPI) -->
                <table class="report-view-table">
                    <tr class="report-view-table-th">
                        <th>NAMA</th>
                        <th>JANTINA</th>
                        <th>STATUS (KELUAR/MASUK)</th>
                        <th>WAKTU (0000)</th>
                        <th>SUHU (°C)</th>
                    </tr>
                    <tbody class="report-view-table-tbody">
                        <tr class="report-view-table-td">
                            <td>NAMA</td>
                            <td>JANTINA</td>
                            <td>STATUS</td>
                            <td>WAKTU</td>
                            <td>SUHU</td>
                        </tr>
                    </tbody>
                </table>
            </div>';
        if(!isset($_GET['location']) || !isset($_GET['date'])){
            header('Location:' . APP_URL . '/report');
            die();    
        }else{
            echo "<script>
            var tbody = document.querySelector('.report-view-table-tbody');
            //Remove pre-inserted data from table
            while(tbody.firstChild){
                tbody.removeChild(tbody.firstChild);
            }
            const URL = '" . APP_URL . "/api/report.php?location=" . $_GET["location"] . "&date=" . $_GET["date"] . "';
            api();
            setInterval(api, 10000);
                    //Fetching data from API
                    function api(){
                        //Remove pre-inserted data from table everytime the data is fetch
                        while(tbody.firstChild){
                        tbody.removeChild(tbody.firstChild);
                        }
                        fetch(URL).then(function (response){
                            return response.json();
                        }).then(function (data){
                            var JSONdata = Object.entries(data);
                            JSONdata[2][1][0].forEach(element => {
                                const tr = document.createElement('tr');
                                tbody.appendChild(tr);
                                Object.entries(element).forEach(data => {
                                const td = document.createElement('td');
                                tr.appendChild(td);
                                td.textContent = data[1];
                            });
                            });
                        }).catch(function (error){
                            console.error(error);
                        })
                    }
            </script>";
        }
    }
?>
<?php
stuse::template('footer');