<?php require_once 'config/database.php'; ?>
<?php require_once 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1>PMPML Online Bus Pass System</h1>
        <p class="lead mb-4">A convenient and digital way to apply, manage, and renew your bus passes online without standing in long queues.</p>
        <a href="#apply" class="btn btn-warning btn-lg fw-bold text-dark px-4 py-2">Apply Now</a>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">About PMPML</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800&auto=format&fit=crop" class="img-fluid rounded shadow" alt="PMPML Bus">
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <p>Pune Mahanagar Parivahan Mahamandal Ltd (PMPML) is the public transport bus service provider for the city of Pune and its extended city limits.</p>
                <p>The digital bus pass facility is introduced to make public transportation more accessible, efficient, and passenger-friendly. It allows students and regular passengers to securely apply for a pass, upload required documents, and obtain a printable receipt within minutes.</p>
                <ul>
                    <li>Extensive route coverage across Pune & Pimpri-Chinchwad</li>
                    <li>Subsidized passes for students</li>
                    <li>Easy online renewal process</li>
                    <li>Secure digital records</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Apply / Registration Cards -->
<section id="apply" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-5">Get Your Bus Pass</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 p-4 border-top border-4 border-primary">
                    <div class="card-body text-center">
                        <h3 class="card-title fw-bold text-primary mb-3">Student Pass</h3>
                        <p class="text-muted mb-4">For students aged 15 to 25 years. Valid ID and Bonafide required.</p>
                        <div class="d-grid gap-2">
                            <a href="student/register.php" class="btn btn-primary">Student Registration</a>
                            <a href="student/login.php" class="btn btn-outline-primary">Student Login</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4 border-top border-4 border-success">
                    <div class="card-body text-center">
                        <h3 class="card-title fw-bold text-success mb-3">Passenger Pass</h3>
                        <p class="text-muted mb-4">For regular passengers aged 26 to 60 years. Easy application process.</p>
                        <div class="d-grid gap-2">
                            <a href="passenger/register.php" class="btn btn-success">Passenger Registration</a>
                            <a href="passenger/login.php" class="btn btn-outline-success">Passenger Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Routes Section -->
<section id="routes" class="py-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Bus Routes & Information</h2>
        <div class="table-responsive bg-white rounded shadow-sm p-3">
            <table class="table table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Route No.</th>
                        <th>Bus No.</th>
                        <th>Starting Point</th>
                        <th>Destination</th>
                        <th>Major Stops</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $pdo->query("SELECT * FROM routes ORDER BY id ASC");
                    while($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td><strong>{$row['route_number']}</strong></td>";
                        echo "<td>{$row['bus_number']}</td>";
                        echo "<td>{$row['starting_point']}</td>";
                        echo "<td>{$row['destination']}</td>";
                        echo "<td><small>{$row['major_stops']}</small></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Image Gallery Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">Gallery</h2>
        <div class="row g-3">
            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=800&auto=format&fit=crop" class="img-fluid gallery-img shadow-sm" alt="Bus Stop">
            </div>
            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1464219789935-c2d9d9aba644?q=80&w=800&auto=format&fit=crop" class="img-fluid gallery-img shadow-sm" alt="Public Transport">
            </div>
            <div class="col-md-4">
                <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=800&auto=format&fit=crop" class="img-fluid gallery-img shadow-sm" alt="Bus Pass">
            </div>
        </div>
    </div>
</section>

<!-- Helpline Section -->
<section id="helpline" class="py-5 bg-dark text-white text-center">
    <div class="container">
        <h2 class="fw-bold text-warning mb-4">Helpline & Support</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM helpline LIMIT 1");
        $helpline = $stmt->fetch();
        if($helpline) {
        ?>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-secondary text-white border-0 shadow">
                    <div class="card-body p-4">
                        <p class="lead mb-4"><?= htmlspecialchars($helpline['description']) ?></p>
                        <div class="row text-start">
                            <div class="col-md-6 mb-3">
                                <h5><i class="fas fa-phone text-warning me-2"></i> Contact Number</h5>
                                <p class="mb-0 fs-5"><?= htmlspecialchars($helpline['contact_number']) ?></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <h5><i class="fas fa-envelope text-warning me-2"></i> Email</h5>
                                <p class="mb-0 fs-5"><?= htmlspecialchars($helpline['email']) ?></p>
                            </div>
                            <div class="col-12 mt-3">
                                <h5><i class="fas fa-map-marker-alt text-warning me-2"></i> Office Address</h5>
                                <p class="mb-0"><?= htmlspecialchars($helpline['office_address']) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
