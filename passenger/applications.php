<?php
require_once '../config/database.php';
if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'passenger') {
    header("Location: login.php");
    exit();
}
?>
<?php require_once '../includes/header.php'; ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="dashboard.php" class="list-group-item list-group-item-action">Dashboard</a>
                <a href="application.php" class="list-group-item list-group-item-action">Apply for Bus Pass</a>
                <a href="applications.php" class="list-group-item list-group-item-action active text-white bg-success border-success">My Applications</a>
                <a href="../logout.php" class="list-group-item list-group-item-action text-danger fw-bold">Logout</a>
            </div>
        </div>
        <div class="col-md-9">
            <?php if(isset($_SESSION['success_msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card shadow border-success">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">My Applications</h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Application No.</th>
                                    <th>Start Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM passenger_applications WHERE user_id = ? ORDER BY application_date DESC");
                                $stmt->execute([$_SESSION['user_id']]);
                                if ($stmt->rowCount() > 0) {
                                    while($row = $stmt->fetch()) {
                                        $badgeClass = '';
                                        if($row['status'] == 'Pending') $badgeClass = 'status-pending';
                                        elseif($row['status'] == 'Under Review') $badgeClass = 'status-review';
                                        elseif($row['status'] == 'Approved') $badgeClass = 'status-approved';
                                        elseif($row['status'] == 'Rejected') $badgeClass = 'status-rejected';

                                        echo "<tr>";
                                        echo "<td><strong>{$row['application_number']}</strong></td>";
                                        echo "<td>" . date('d M Y', strtotime($row['starting_date'])) . "</td>";
                                        echo "<td><span class='status-badge {$badgeClass}'>{$row['status']}</span></td>";
                                        echo "<td><a href='receipt.php?id={$row['id']}' class='btn btn-sm btn-outline-success'>View Receipt</a></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='4' class='text-center py-4'>No applications found. <a href='application.php' class='text-success'>Apply now</a></td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once '../includes/footer.php'; ?>
