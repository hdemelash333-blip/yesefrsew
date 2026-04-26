<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "E-Learning Portal | YESEFERSEW";
include 'includes/header.php';
?>
<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">E-Learning Portal</h1>
    <p class="section-text">Access courses on art writing, curatorial practice, art management, and digital marketing for artists.</p>

    <div class="pillar-container">
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fas fa-pen-nib"></i></div>
            <h3>Art Writing</h3>
            <p>Master the craft of critical writing and artist statements.</p>
        </div>
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fas fa-briefcase"></i></div>
            <h3>Art Management</h3>
            <p>Learn the business side of the art world.</p>
        </div>
        <div class="pillar-card">
            <div class="pillar-icon"><i class="fas fa-camera"></i></div>
            <h3>Digital Marketing</h3>
            <p>Promote your work in the digital age.</p>
        </div>
    </div>

    <div class="subscription-form" style="margin-top: 4rem;">
        <h3>Coming Soon: Virtual Forums & Workshops</h3>
        <p>Register your interest to be notified when courses launch.</p>
        <button class="btn btn-primary open-subscribe-modal" style="margin-top: 1rem;">Notify Me →</button>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
