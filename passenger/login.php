<?php
require_once '../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'passenger'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_type'] = $user['user_type'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
}
?>
<?php require_once '../includes/header.php'; ?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Passenger Login</h4>
                </div>
                <div class="card-body">
                    <?php if($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label>Email ID</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Login</button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
