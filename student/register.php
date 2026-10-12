<?php
require_once '../config/database.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $age = (int)$_POST['age'];

    if ($age < 15 || $age > 25) {
        $error = "You are not eligible for a Student Bus Pass. Student age must be between 15 and 25 years.";
    } elseif ($password !== $cpassword) {
        $error = "Passwords do not match!";
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $error = "Email already registered!";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, mobile, password, age, user_type) VALUES (?, ?, ?, ?, ?, 'student')");
            if ($stmt->execute([$name, $email, $mobile, $hash, $age])) {
                $message = "Registration successful! You can now <a href='login.php'>Login</a>.";
            } else {
                $error = "Registration failed! Please try again.";
            }
        }
    }
}
?>
<?php require_once '../includes/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Student Registration</h4>
                </div>
                <div class="card-body">
                    <?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                    <?php if($message): ?><div class="alert alert-success"><?= $message ?></div><?php else: ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email ID</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mobile Number</label>
                            <input type="text" name="mobile" class="form-control" required pattern="\d{10}">
                        </div>
                        <div class="mb-3">
                            <label>Age (15-25 years)</label>
                            <input type="number" name="age" class="form-control" required min="15" max="25">
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                    <?php endif; ?>
                </div>
                <div class="card-footer text-center">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
