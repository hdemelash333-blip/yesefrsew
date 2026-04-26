<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Biennial Registration | YESEFERSEW";
include 'includes/header.php';
?>
<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <div class="hero-biennial" style="border-radius: 2rem; margin-bottom: 3rem;">
        <div class="hero-badge">BIENNIAL 2027</div>
        <h1>Addis Adwa Art Biennial</h1>
        <p>Registration for the 2027 edition is now open for artists, volunteers, and attendees.</p>
    </div>

    <div class="network-grid">
        <div class="network-card">
            <h3>Exhibiting Artist</h3>
            <p>Submit your work for the central venue exhibition.</p>
            <a href="membership.php?type=biennial&reg=artist" class="btn btn-primary">Register</a>
        </div>
        <div class="network-card">
            <h3>Volunteer</h3>
            <p>Join the team making the biennial happen.</p>
            <a href="membership.php?type=biennial&reg=volunteer" class="btn btn-primary">Register</a>
        </div>
        <div class="network-card">
            <h3>Attendee</h3>
            <p>Get early bird access to tickets and schedules.</p>
            <a href="membership.php?type=biennial&reg=attendee" class="btn btn-primary">Register</a>
        </div>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
