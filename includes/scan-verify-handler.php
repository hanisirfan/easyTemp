<?php
require_once(__DIR__ . '/db.php');

if(isset($_POST['icNo'])){
    #Fetch location ID from DB based on POST locationID
    $locstmt = $pdo->prepare('SELECT id FROM locations WHERE name = ? LIMIT 1');
    $loc = strtolower($_POST['location']);
    $locstmt->execute([$loc]);
    $locations = $locstmt->fetch();

    #Insert data into records table
    $stmt = $pdo->prepare('INSERT INTO records (studentIcNo,locationID,time,date,status,temperature)
    VALUES (?,?,?,?,?,?)');
    $icNo = $_POST['icNo'];
    $location = $locations['id'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $status = $_POST['status'];
    if ($status = 'KELUAR') {
        $status = 1; 
    }elseif($status = 'MASUK'){
        $status = 2;
    }
    $temperature = $_POST['temperature'];
    $stmt->execute([$icNo, $location, $time, $date, $status, $temperature]);
    header('Location:' . APP_URL . '/scan/success.php');
}else{
    header('Location:' . APP_URL);
}



