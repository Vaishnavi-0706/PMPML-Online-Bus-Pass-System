<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
    header("Location: login.php");
    exit();
}
?>
<?php require_once '../includes/header.php'; ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action active">Dashboard</a>
                <a href="application.php" class="list-group-item list-group-item-action">Apply for Bus Pass</a>
                <a href="applications.php" class="list-group-item list-group-item-action">My Applications</a>
                <a href="../logout.php" class="list-group-item list-group-item-action text-danger fw-bold">Logout</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card shadow-sm mb-4">
                <div class="card-body bg-light rounded">
                    <h3>Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h3>
                    <p class="text-muted">Manage your student bus pass applications from here.</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-primary h-100">
                        <div class="card-body text-center py-4">
                            <h4 class="card-title text-primary"><i class="fas fa-id-card mb-2"></i><br>Apply Now</h4>
                            <p class="card-text">Submit a new application for a student bus pass.</p>
                            <a href="application.php" class="btn btn-primary">Start Application</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-info h-100">
                        <div class="card-body text-center py-4">
                            <h4 class="card-title text-info"><i class="fas fa-list-alt mb-2"></i><br>Track Status</h4>
                            <p class="card-text">View status and download receipts of your applications.</p>
                            <a href="applications.php" class="btn btn-info text-white">View Applications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
