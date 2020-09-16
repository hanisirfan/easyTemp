<?php
require_once(dirname(__DIR__, 1) . '/includes/db.php');

if(!isset($_GET['location']) || !isset($_GET['date'])){
    //Response with 400 if parameters isn't passed properly
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('HTTP/1.0 400 Bad Request');
}elseif(isset($_GET['location']) AND isset($_GET['date'])){
    $stmt = $pdo->prepare('SELECT id, name FROM locations WHERE id = ?');
    $stmt->execute([$_GET['location']]);
    $locations = $stmt->fetch(PDO::FETCH_ASSOC);
    $location = $locations['name'];
    //Fetch records data
    $stmt = $pdo->prepare('SELECT studentIcNo, status, time, temperature FROM records WHERE locationID = ? and date = ? ORDER by id DESC');
    $stmt->execute([$_GET['location'], $_GET['date']]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($records) < 1){
        //Response with 404 if there's no records
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header('HTTP/1.0 404 Not Found');
    }else{
        foreach ($records as $record) {
            $recordStatus = $record['status'];
            $recordsData = array();
            if ($recordStatus == 1) {
                $statusDisplay = 'MASUK';
            }elseif($recordStatus == 2){
                $statusDisplay = 'KELUAR';
            }else{
                $statusDisplay = 'N/A';
            }
            $stmt = $pdo->prepare('SELECT icNo, name, gender FROM students');
            $stmt->execute();
            $students = $stmt->fetchAll();
            foreach ($students as $student) {
                $studentIcNo = $student['icNo'];
                //Compare IC no and gender from records and students table
                if($record['studentIcNo'] == $studentIcNo){
                    $studentName = strtoupper($student['name']);
                    $studentGender = strtoupper($student['gender']);
                }
            }
            $recordsResponse[] = array(
                "name" => $studentName,
                "jantina" => $studentGender,
                "status" => $statusDisplay,
                "time" => $record['time'],
                "temperature" => $record['temperature']
            );
            array_push($recordsData, $recordsResponse);
        }
        $data = array(
            "location" => $location,
            "date" => $_GET['date'],
            "records" => $recordsData
        ); 
        //Successful connection
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}



