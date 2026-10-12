<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $starting_date = $_POST['starting_date'];

    $stmt = $pdo->prepare("SELECT name, email, mobile, age FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    $upload_dir = '../uploads/passengers/';
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

    $aadhar = uploadFile($_FILES['aadhar_card'], $upload_dir, $allowed_types, $max_size);
    $photo = uploadFile($_FILES['photo'], $upload_dir, ['image/jpeg', 'image/png'], $max_size);

    if ($aadhar && $photo) {
        $app_no = 'PMPML-PASS-' . date('Y') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $stmt = $pdo->prepare("INSERT INTO passenger_applications 
            (application_number, user_id, name, email, mobile, age, aadhar_card, photo, starting_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$app_no, $user_id, $user['name'], $user['email'], $user['mobile'], $user['age'], $aadhar, $photo, $starting_date])) {
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
