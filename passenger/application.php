<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    header("Location: login.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<?php require_once '../includes/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Apply for Passenger Bus Pass</h4>
                </div>
                <div class="card-body">
                    <form action="submit_application.php" method="POST" enctype="multipart/form-data" id="passengerPassForm">
                        <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email ID</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" value="<?= htmlspecialchars($user['mobile']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" class="form-control" value="<?= htmlspecialchars($user['age']) ?>" readonly>
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4">Required Documents <small class="text-muted">(JPG/PNG/PDF, Max 2MB)</small></h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhaar Card <span class="text-danger">*</span></label>
                                <input type="file" name="aadhar_card" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Passport-size Photo <span class="text-danger">*</span></label>
                                <input type="file" name="photo" class="form-control" required accept=".jpg,.jpeg,.png">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-2">Pass Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Starting Date <span class="text-danger">*</span></label>
                                <input type="date" name="starting_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fs-5">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('passengerPassForm').addEventListener('submit', function(e) {
    if(!confirm('Are you sure you want to submit this application? Please verify all details.')) {
        e.preventDefault();
    }
});
</script>
<?php require_once '../includes/footer.php'; ?>
