<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $school_name = $_POST['school_name'];
    $starting_date = $_POST['starting_date'];
    $pass_duration = (int)$_POST['pass_duration'];
    
    $fee = 0;
    if ($pass_duration == 1) $fee = 750;
    elseif ($pass_duration == 3) $fee = 2000;
    elseif ($pass_duration == 6) $fee = 3000;
    elseif ($pass_duration == 12) $fee = 5000;

    $stmt = $pdo->prepare("SELECT name, email, mobile, age FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    $upload_dir = '../uploads/students/';
    $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
    $max_size = 2 * 1024 * 1024; // 2MB

    function uploadFile($file, $dir, $allowed, $max_size) {
        if ($file['error'] !== UPLOAD_ERR_OK) return false;
        if (!in_array($file['type'], $allowed)) return false;
        if ($file['size'] > $max_size) return false;

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $dir . $filename)) {
            return $filename;
        }
        return false;
    }

    $bonafide = uploadFile($_FILES['bonafide_document'], $upload_dir, $allowed_types, $max_size);
    $light_bill = uploadFile($_FILES['light_bill'], $upload_dir, $allowed_types, $max_size);
    $aadhar = uploadFile($_FILES['aadhar_card'], $upload_dir, $allowed_types, $max_size);
    $fees_receipt = uploadFile($_FILES['fees_receipt'], $upload_dir, $allowed_types, $max_size);
    $photo = uploadFile($_FILES['photo'], $upload_dir, ['image/jpeg', 'image/png'], $max_size);

    if ($bonafide && $light_bill && $aadhar && $fees_receipt && $photo) {
        $app_no = 'PMPML-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $stmt = $pdo->prepare("INSERT INTO student_applications 
            (application_number, user_id, name, email, mobile, school_name, age, bonafide_document, light_bill, aadhar_card, fees_receipt, photo, starting_date, pass_duration, fee) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$app_no, $user_id, $user['name'], $user['email'], $user['mobile'], $school_name, $user['age'], $bonafide, $light_bill, $aadhar, $fees_receipt, $photo, $starting_date, $pass_duration, $fee])) {
            $_SESSION['success_msg'] = "Application submitted successfully! Application Number: $app_no";
            header("Location: applications.php");
            exit();
        } else {
            echo "Error submitting application.";
        }
    } else {
        echo "Error uploading files. Ensure they are JPG/PNG/PDF and under 2MB.";
    }
} else {
    header("Location: application.php");
    exit();
}
?>
