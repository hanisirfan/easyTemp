<?php
session_start();
require_once(dirname(__DIR__, 3) . '/config.php');
require_once(dirname(__DIR__, 3) . '/includes/db.php');
require_once(dirname(__DIR__, 3) . '/includes/lib/fpdf182/fpdf.php');
require_once(dirname(__DIR__, 3) . '/includes/lib/fpdf-multicell/fpdf-multicell.php');
if(!isset($_SESSION['username'])){
    header('Location:' . APP_URL . '/report');
    die();
}elseif($_SESSION['urole'] != 1){
    header('Location:' . APP_URL . '/report');
    die();
}else{
    if(!isset($_GET['location']) || !isset($_GET['date'])){
        echo '<style>p,a{font-size:4vw}</style>';
        echo '<p>Parameter location atau date tidak diterima</p><br>';
        echo '<a href="'.APP_URL.'">Kembali</a>';
    }else{
        $stmt = $pdo->prepare('SELECT * FROM records where locationID = ? and date = ?');
        $stmt->execute([$_GET['location'], $_GET['date']]);
        $recordCheck = $stmt->fetchAll();
        if(count($recordCheck) <= 0){
            echo '<style>p,a{font-size:4vw}</style>';
            echo '<p>Tiada rekod dijumpai!</p><br>';
            echo '<a href="' . APP_URL . '/report' . '">Kembali</a>';
        }else{
            class PDF extends PDF_MC_Table{
                function Header()
                {
                    //$this->Image('logo.png',10,6,30);
                    $this->SetFont('Arial','B', 16);
                    $this->Cell(50,15,'REKOD SUHU PELAJAR');
                    $this->Ln(8);
                    $this->SetFont('Arial','I', 12);
                    //Check for locations based on given ID
                    global $pdo;
                    $stmt = $pdo->prepare('SELECT name FROM locations WHERE id = ?');
                    $stmt->execute([$_GET['location']]);
                    $location = $stmt->fetch();
                    $locationName = $location['name'];
                    $this->Cell(50,15,'LOKASI: ' . strtoupper($locationName));
                    $this->Ln(5);
                    $this->Cell(50,15,'TARIKH: ' . $_GET['date']);
                    $this->Ln(15);
                }
                function Footer()
                {
                    $this->SetY(-20);
                    $this->SetFont('Arial','I',8);
                    $this->Cell(70);
                    $this->Cell(0,10,'Dijanakan menggunakan perisian ' . APP_NAME, 'C');
                    $this->Ln(3);
                    $this->Cell(93);
                    $this->Cell(0,10,'Versi: ' . APP_VERSION, 'C');
                    $this->Ln(3);
                    $this->Cell(10);
                    $this->Cell(0,10,chr(169) . ' Hak Cipta ' . APP_AUTHOR . ' 2020',0,0,'C');
                    $this->Cell(-20);
                    $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,);
                }
            }
        //Init new object and settings
        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetTitle('Rekod Suhu Pelajar');
        $pdf->SetAuthor(APP_AUTHOR);
        //Thanks to this lib: https://github.com/gemul/fthis-multicell-table
        //Tutorial: https://www.youtube.com/watch?v=pELrw9P5ywM
        $pdf->SetWidths(array(12,65,22,20,15,20,18,15));
        $pdf->SetLineHeight(5);
        $pdf->SetAligns(array('C','C','C','C','C','C','C','C'));
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(12, 5, 'BIL.', 1, 'C');
        $pdf->Cell(65, 5, 'NAMA', 1, 'C');
        $pdf->Cell(22, 5, 'JANTINA', 1, 'C');
        $pdf->Cell(20, 5, 'KELAS', 1, 'C');
        $pdf->Cell(15, 5, 'DORM', 1, 'C');
        $pdf->Cell(20, 5, 'STATUS', 1, 'C');
        $pdf->Cell(18, 5, 'WAKTU', 1, 'C');
        $pdf->Cell(15, 5, 'SUHU', 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', '', 10);
        //Getting records
        $stmt = $pdo->prepare('SELECT id, studentIcNo, locationID, time, date, status, temperature FROM records WHERE locationID = ? AND date = ? ORDER by id DESC');
        $location = $_GET['location'];
        $date = $_GET['date'];
        $stmt->execute([$location, $date]);
        $records = $stmt->fetchAll();
        $num = 0;
        foreach ($records as $record) {
            $num++;
            $recordID = $record['id'];
            $recordStudentIc = $record['studentIcNo'];
            $recordStatus = $record['status'];
            if ($recordStatus == 1) {
                $statusDisplay = 'MASUK';
            }elseif($recordStatus == 2){
                $statusDisplay = 'KELUAR';
            }else{
                $statusDisplay = 'N/A';
            }
            $recordTime = $record['time'];
            $recordTemperature = $record['temperature'];
            //Simply change if status == 1 it will output MASUK etc
     
            //Getting students info
            $stmt = $pdo->prepare('SELECT icNo, name, gender, dormCode, classCode FROM students');
            $stmt->execute();
            $students = $stmt->fetchAll();
            foreach ($students as $student) {
                $studentIcNo = $student['icNo'];
                //Compare IC no and gender from records and students table
                if($recordStudentIc == $studentIcNo){
                    $studentName = strtoupper($student['name']);
                    $studentGender = strtoupper($student['gender']);
                    $studentDormCode = strtoupper($student['dormCode']);
                    $studentClassCode = strtoupper($student['classCode']);
                }
            }
            $pdf->Row(Array(
                $num,
                $studentName,
                $studentGender,
                $studentClassCode,
                $studentDormCode,
                $statusDisplay,
                $recordTime,
                $recordTemperature,
            )); 
        }
        $stmt = $pdo->prepare('SELECT name FROM locations WHERE id = ?');
        $stmt->execute([$_GET['location']]);
        $location = $stmt->fetch();
        $locationName = $location['name'];
        //Output this file
        $pdf->Output('I', 'easyTemp' . ' - ' . strtoupper($locationName) . ' - ' . $date . '.pdf', true);
        }
    }
}
