<?php
session_start();
require_once(dirname(__DIR__ , 1) . '\config.php');
require_once(__DIR__ . '\db.php');
//ik it's kinda weird if i want to pass success messages with session with the name "error" but well ¯\_(ツ)_/¯
/*
Id (studentIcNo or locationId)
Method (1=edit,2=delete,3=add)
*/
if(isset($_POST['submit'])){
    if(!isset($_POST['type'])){
        header('Location:' . APP_URL . '/dashboard');
        die();
    }else{
        if($_POST['type'] == 'student'){
            if(isset($_POST['delete'])){
                if($_POST['delete'] == 1){
                    $stmt = $pdo->prepare('DELETE FROM students where icNo = ?');
                    $stmt->execute([$_POST['id']]);
                    header('Location:' . APP_URL . '/dashboard/student');
                    die();
                }elseif($_POST['delete'] == 2){
                    header('Location:' . APP_URL . '/dashboard/student');
                    die();
                }
            }elseif(isset($_POST['edit'])){
                $stmt = $pdo->prepare('UPDATE students SET name = ?, gender = ?, dormCode = ?, classCode = ? WHERE icNo = ?');
                $stmt->execute([strtolower($_POST['name']), strtolower($_POST['gender']), strtolower($_POST['dorm']), strtolower($_POST['class']), strtolower($_POST['id'])]);
                header('Location:' . APP_URL . '/dashboard/student');
                die();
            }elseif(isset($_POST['add'])){
                $stmt = $pdo->prepare('SELECT * FROM students WHERE icNo = ?');
                $stmt->execute([$_POST['id']]);
                $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if($fetch){
                    $_SESSION['error'] = "PELAJAR TERSEBUT TELAH WUJUD!";
                    header('Location:' . APP_URL . '/dashboard/student');
                    die();
                }elseif(!$fetch){
                    $stmt = $pdo->prepare('INSERT INTO students (icNo,name,gender,dormCode,classCode) VALUES (?, ?, ?, ?, ?)');
                    $stmt->execute([strtolower($_POST['id']),strtolower($_POST['name']),strtolower($_POST['gender']),strtolower($_POST['dorm']),strtolower($_POST['class'])]);
                    header('Location:' . APP_URL . '/dashboard/student');
                    die();
                }
            }
        }elseif($_POST['type'] == 'location'){
            if(isset($_POST['delete'])){
                if($_POST['delete'] == 1){
                    $stmt = $pdo->prepare('DELETE FROM locations where id = ?');
                    $stmt->execute([$_POST['id']]);
                    header('Location:' . APP_URL . '/dashboard/location');
                    die();
                }elseif($_POST['delete'] == 2){
                    header('Location:' . APP_URL . '/dashboard/location');
                    die();
                }
            }elseif(isset($_POST['edit'])){
                $stmt = $pdo->prepare('UPDATE locations SET name = ? WHERE id = ?');
                $stmt->execute([strtolower($_POST['name']), $_POST['id']]);
                header('Location:' . APP_URL . '/dashboard/location');
                die();
            }elseif(isset($_POST['add'])){
                    $stmt = $pdo->prepare('INSERT INTO locations (name) VALUES (?)');
                    $stmt->execute([strtolower($_POST['name'])]);
                    header('Location:' . APP_URL . '/dashboard/location');
                    die();
            }
        }elseif($_POST['type'] == 'user'){
            $uFullName = $_POST['ufullname'];
            $uUsername = $_POST['username'];
            $uPass = $_POST['upass'];
            $uConfirmPass = $_POST['uconfirmpass'];
            $uRole = $_POST['urole'];
            if(isset($_POST['logout'])){
                unset($_SESSION['username']);
                unset($_SESSION['urole']);
                session_destroy();
                header('Location:' . APP_URL);
                die();
            }elseif(isset($_POST['login'])){
                $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
                $stmt->execute([$uUsername]);
                $fetch = $stmt->fetch(PDO::FETCH_ASSOC);
                if($fetch){
                    if(!password_verify($uPass, $fetch['password'])){
                        $_SESSION['error'] = "KATA LALUAN YANG DIMASUKKAN TIDAK BETUL!";
                        header('Location:' . APP_URL . '/dashboard/user/login');
                        die();
                    }elseif(password_verify($uPass, $fetch['password'])){
                        $_SESSION['error'] = "LOG MASUK BERJAYA";
                        $_SESSION['username'] = $fetch['username'];
                        $_SESSION['urole'] = $fetch['role'];
                        header('Location:' . APP_URL);
                        die();
                    }
                }else{
                    $_SESSION['error'] = "TIADA PENGGUNA DIJUMPAI!";
                    header('Location:' . APP_URL . '/dashboard/user/login');
                    die();
                }
            }elseif(isset($_POST['add'])){
                if($uPass == $uConfirmPass){
                    if(!preg_match('/^[a-zA-Z0-9]*$/', $uUsername)){
                        $_SESSION['error'] = "NAMA PENGGUNA (USERNAME) TIDAK SAH!";
                        header('Location:' . APP_URL . '/dashboard/user');
                        die();
                    }else{
                        if(!preg_match('/^(?=.*[A-Z])(?=.*[!@#$&*-_])(?=.*[0-9])(?=.*[a-z]).{8,}$/', $uPass)){
                            $_SESSION['error'] = "KATA LALUAN TIDAK MEMENUHI KRITERIA KERUMITAN!";
                            header('Location:' . APP_URL . '/dashboard/user');
                            die();
                        }else{
                            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
                            $stmt->execute([$uUsername]);
                            $fetch = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if($fetch){
                                $_SESSION['error'] = "PENGGUNA TERSEBUT TELAH WUJUD!";
                                header('Location:' . APP_URL . '/dashboard/user');
                                die();
                            }elseif(!$fetch){
                                    $stmt = $pdo->prepare('INSERT INTO users (fullname,username,password,role) VALUES (?, ?, ?, ?)');
                                    $stmt->execute([strtolower($uFullName),$uUsername,password_hash($uPass, PASSWORD_DEFAULT),$uRole]);
                                    header('Location:' . APP_URL . '/dashboard/user');
                                    die();
                            }
                        }
                    }
                }else{
                    $_SESSION['error'] = "KATA LALUAN TIDAK SAMA!";
                    header('Location:' . APP_URL . '/dashboard/user');
                    die();
                }
            }
        }
    }
}else{
    header('Location:' . APP_URL);
    die();
}
?>