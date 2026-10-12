<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'student') {
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
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Apply for Student Bus Pass</h4>
                </div>
                <div class="card-body">
                    <form action="submit_application.php" method="POST" enctype="multipart/form-data" id="studentPassForm">
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
                        <div class="mb-4">
                            <label class="form-label">School/College Name <span class="text-danger">*</span></label>
                            <input type="text" name="school_name" class="form-control" required>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3">Required Documents <small class="text-muted">(JPG/PNG/PDF, Max 2MB)</small></h5>
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bonafide Certificate <span class="text-danger">*</span></label>
                                <input type="file" name="bonafide_document" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Light Bill <span class="text-danger">*</span></label>
                                <input type="file" name="light_bill" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Aadhaar Card <span class="text-danger">*</span></label>
                                <input type="file" name="aadhar_card" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fees Receipt <span class="text-danger">*</span></label>
                                <input type="file" name="fees_receipt" class="form-control" required accept=".jpg,.jpeg,.png,.pdf">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Passport-size Photo <span class="text-danger">*</span></label>
                                <input type="file" name="photo" class="form-control" required accept=".jpg,.jpeg,.png">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3">Pass Information</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Starting Date <span class="text-danger">*</span></label>
                                <input type="date" name="starting_date" class="form-control" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Pass Duration <span class="text-danger">*</span></label>
                                <select name="pass_duration" class="form-select" id="passDuration" required>
                                    <option value="">Select Duration</option>
                                    <option value="1">1 Month</option>
                                    <option value="3">3 Months</option>
                                    <option value="6">6 Months</option>
                                    <option value="12">12 Months</option>
                                </select>
                            </div>
                        </div>

                        <div class="alert alert-info text-center fw-bold fs-5">
                            Total Fee: <span id="totalFee">₹0</span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fs-5">Submit Application</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('passDuration').addEventListener('change', function() {
    const duration = this.value;
    let fee = 0;
    if (duration == '1') fee = 750;
    else if (duration == '3') fee = 2000;
    else if (duration == '6') fee = 3000;
    else if (duration == '12') fee = 5000;
    document.getElementById('totalFee').innerText = '₹' + fee.toLocaleString('en-IN');
});

document.getElementById('studentPassForm').addEventListener('submit', function(e) {
    if(!confirm('Are you sure you want to submit this application? Please verify all details.')) {
        e.preventDefault();
    }
});
</script>
<?php require_once '../includes/footer.php'; ?>
