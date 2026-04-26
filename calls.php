<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_abstract'])) {
    $call_id = $_POST['call_id'];
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $affiliation = sanitize($_POST['affiliation']);
    $title = sanitize($_POST['title']);
    $abstract = sanitize($_POST['abstract']);
    $keywords = sanitize($_POST['keywords']);

    $stmt = $pdo->prepare("INSERT INTO paper_submissions (call_id, name, email, affiliation, paper_title, abstract, keywords) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$call_id, $name, $email, $affiliation, $title, $abstract, $keywords]);
    $success = "Thank you! Your abstract has been submitted.";
}

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM calls_for_papers WHERE slug = ? AND status = 'active'");
    $stmt->execute([$slug]);
    $call = $stmt->fetch();

    if (!$call) redirect('calls.php');

    $page_title = $call['title'] . " | Call for Papers";
    include 'includes/header.php';
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title"><?php echo $call['title']; ?></h1>
        <?php if(isset($success)) echo "<div class='portal-badge' style='display:block; margin-bottom:1rem; background:green; color:white; padding:1rem;'>$success</div>"; ?>

        <div class="cfp-grid">
            <div class="cfp-content">
                <p class="section-text"><?php echo nl2br($call['description']); ?></p>
                <h3>Submit Your Abstract</h3>
                <form method="POST" class="subscription-form" style="text-align: left; background: var(--light); border: 1px solid #ddd;">
                    <input type="hidden" name="call_id" value="<?php echo $call['id']; ?>">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Abstract Title</label>
                        <input type="text" name="title" required>
                    </div>
                    <div class="form-group">
                        <label>Abstract</label>
                        <textarea name="abstract" rows="10" style="width:100%; border-radius:1rem; padding:1rem;" required></textarea>
                    </div>
                    <button type="submit" name="submit_abstract" class="btn btn-primary">Submit Abstract</button>
                </form>
            </div>
            <div class="cfp-sidebar">
                <h4>Guidelines</h4>
                <div class="submission-info"><?php echo $call['guidelines']; ?></div>
            </div>
        </div>
    </main>
    <?php
} else {
    $page_title = "Calls for Papers | YESEFERSEW Journal";
    include 'includes/header.php';
    $calls = $pdo->query("SELECT * FROM calls_for_papers WHERE status='active' ORDER BY created_at DESC")->fetchAll();
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title">Open Calls for Papers</h1>
        <div class="journal-grid">
            <?php if ($calls): foreach ($calls as $call): ?>
                <div class="journal-card">
                    <h3><?php echo $call['title']; ?></h3>
                    <p>Deadline: <?php echo $call['deadline_text']; ?></p>
                    <a href="calls.php?slug=<?php echo $call['slug']; ?>" class="btn btn-primary" style="margin-top: 1rem; display: inline-block;">View & Submit →</a>
                </div>
            <?php endforeach; else: ?>
                <p>No active calls at the moment. Stay tuned!</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
}
include 'includes/footer.php';
?>
