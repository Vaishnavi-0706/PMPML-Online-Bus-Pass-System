<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    header("Location: login.php");
    exit();
}

if(!isset($_GET['id'])) {
    header("Location: applications.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM passenger_applications WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$app = $stmt->fetch();

if(!$app) {
    die("Application not found or unauthorized access.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Receipt - <?= $app['application_number'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; }
        .receipt-card { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .receipt-header { border-bottom: 2px solid #198754; padding-bottom: 15px; margin-bottom: 20px; }
        .applicant-photo { width: 120px; height: 140px; object-fit: cover; border: 2px solid #dee2e6; }
        @media print {
            body { background-color: #fff; }
            .no-print { display: none !important; }
            .receipt-card { box-shadow: none; margin: 0; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="receipt-card border-top border-4 border-success">
        <div class="receipt-header text-center position-relative">
            <h2 class="text-success fw-bold mb-1">PMPML Online Bus Pass System</h2>
            <h4 class="text-secondary">Application Receipt</h4>
            <div class="position-absolute top-0 end-0">
                <img src="../uploads/passengers/<?= htmlspecialchars($app['photo']) ?>" class="applicant-photo" alt="Applicant Photo">
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><th width="40%">Application No:</th><td><strong><?= htmlspecialchars($app['application_number']) ?></strong></td></tr>
                    <tr><th>Applicant Name:</th><td><?= htmlspecialchars($app['name']) ?></td></tr>
                    <tr><th>Applicant Type:</th><td>Passenger</td></tr>
                    <tr><th>Age:</th><td><?= htmlspecialchars($app['age']) ?> Years</td></tr>
                    <tr><th>Email ID:</th><td><?= htmlspecialchars($app['email']) ?></td></tr>
                    <tr><th>Mobile No:</th><td><?= htmlspecialchars($app['mobile']) ?></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless table-sm">
                    <tr><th width="40%">Status:</th><td><strong class="text-success"><?= htmlspecialchars($app['status']) ?></strong></td></tr>
                    <tr><th>Starting Date:</th><td><?= date('d F Y', strtotime($app['starting_date'])) ?></td></tr>
                    <tr><th>Applied On:</th><td><?= date('d F Y, h:i A', strtotime($app['application_date'])) ?></td></tr>
                </table>
            </div>
        </div>

        <div class="mt-4 border-top pt-3 text-center no-print">
            <button onclick="window.print()" class="btn btn-success px-4 me-2"><i class="fas fa-print"></i> Print Receipt</button>
            <a href="applications.php" class="btn btn-secondary px-4">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
