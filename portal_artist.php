<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Artist Portal | YESEFERSEW";
include 'includes/header.php';
?>
<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Artist Portal</h1>
    <div class="network-grid">
        <div class="network-card">
            <i class="fas fa-id-card network-icon"></i>
            <h3>Portfolio Management</h3>
            <p>Upload and manage your professional art portfolio.</p>
        </div>
        <div class="network-card">
            <i class="fas fa-file-signature network-icon"></i>
            <h3>Open Call Applications</h3>
            <p>Apply for current exhibitions and biennial calls.</p>
        </div>
        <div class="network-card">
            <i class="fas fa-award network-icon"></i>
            <h3>Grant Access</h3>
            <p>Exclusive access to funding opportunities for members.</p>
        </div>
    </div>
    <div class="text-center" style="margin-top: 3rem;">
        <a href="membership.php?type=artist" class="btn btn-primary">Register to Access Portal</a>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
