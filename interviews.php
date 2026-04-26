<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM interviews WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $interview = $stmt->fetch();

    if (!$interview) redirect('interviews.php');

    $page_title = $interview['title'] . " | Artist Interviews";
    include 'includes/header.php';
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title"><?php echo $interview['title']; ?></h1>
        <div class="byline">Interview with <?php echo $interview['artist_name']; ?> | <?php echo date('F j, Y', strtotime($interview['created_at'])); ?></div>
        <div class="section-text" style="margin-top: 2rem;">
            <?php echo nl2br($interview['content']); ?>
        </div>
        <a href="interviews.php" class="btn btn-secondary" style="margin-top: 2rem;">← Back to Interviews</a>
    </main>
    <?php
} else {
    $page_title = "Artist Interviews | YESEFERSEW";
    include 'includes/header.php';
    $interviews = $pdo->query("SELECT * FROM interviews WHERE status='published' ORDER BY created_at DESC")->fetchAll();
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title">Artist Interviews</h1>
        <div class="journal-grid">
            <?php if ($interviews): foreach ($interviews as $interview): ?>
                <div class="journal-card">
                    <h3><?php echo $interview['title']; ?></h3>
                    <p><?php echo $interview['excerpt']; ?></p>
                    <a href="interviews.php?slug=<?php echo $interview['slug']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Read Interview →</a>
                </div>
            <?php endforeach; else: ?>
                <p>Coming soon!</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
}
include 'includes/footer.php';
?>
