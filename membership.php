<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$type = isset($_GET['type']) ? sanitize($_GET['type']) : 'artist';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $type = $_POST['type'];
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $discipline = isset($_POST['discipline']) ? sanitize($_POST['discipline']) : null;
    $affiliation = isset($_POST['affiliation']) ? sanitize($_POST['affiliation']) : null;
    $country = isset($_POST['country']) ? sanitize($_POST['country']) : null;

    $stmt = $pdo->prepare("INSERT INTO members (type, name, email, discipline, affiliation, country) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$type, $name, $email, $discipline, $affiliation, $country]);
    $success = "Registration successful! Welcome to the network.";
}

$page_title = "Join the Network | YESEFERSEW";
include 'includes/header.php';
?>

<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Become a Member</h1>
    <?php if(isset($success)) echo "<div class='portal-badge' style='display:block; margin-bottom:1rem; background:green; color:white; padding:1rem;'>$success</div>"; ?>

    <div class="subscription-form" style="text-align: left; max-width: 600px; margin: 0 auto; background: var(--white); border: 1px solid #eee;">
        <form method="POST">
            <div class="form-group">
                <label>Membership Type</label>
                <select name="type" required>
                    <option value="artist" <?php if($type == 'artist') echo 'selected'; ?>>Artist</option>
                    <option value="curator" <?php if($type == 'curator') echo 'selected'; ?>>Curator/Critic</option>
                    <option value="institution" <?php if($type == 'institution') echo 'selected'; ?>>Institution</option>
                    <option value="diaspora" <?php if($type == 'diaspora') echo 'selected'; ?>>Diaspora</option>
                </select>
            </div>
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>

            <?php if($type == 'artist'): ?>
            <div class="form-group">
                <label>Discipline</label>
                <input type="text" name="discipline" placeholder="e.g. Painting, Sculpture">
            </div>
            <?php endif; ?>

            <?php if($type == 'curator' || $type == 'institution'): ?>
            <div class="form-group">
                <label>Affiliation</label>
                <input type="text" name="affiliation">
            </div>
            <?php endif; ?>

            <?php if($type == 'diaspora'): ?>
            <div class="form-group">
                <label>Country of Residence</label>
                <input type="text" name="country">
            </div>
            <?php endif; ?>

            <button type="submit" name="register" class="btn btn-primary" style="width: 100%;">Complete Registration</button>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
