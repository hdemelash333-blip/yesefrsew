<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM curatorial_notes WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $note = $stmt->fetch();

    if (!$note) redirect('curatorial.php');

    $page_title = $note['title'] . " | Curatorial Notes";
    include 'includes/header.php';
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title"><?php echo $note['title']; ?></h1>
        <div class="byline">By <?php echo $note['curator_name']; ?> | <?php echo date('F j, Y', strtotime($note['created_at'])); ?></div>
        <div class="section-text" style="margin-top: 2rem;">
            <?php echo nl2br($note['content']); ?>
        </div>
        <a href="curatorial.php" class="btn btn-secondary" style="margin-top: 2rem;">← Back to Curatorial</a>
    </main>
    <?php
} else {
    $page_title = "Curatorial Notes | YESEFERSEW";
    include 'includes/header.php';
    $notes = $pdo->query("SELECT * FROM curatorial_notes WHERE status='published' ORDER BY created_at DESC")->fetchAll();
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title">Curatorial Notes</h1>
        <div class="journal-grid">
            <?php if ($notes): foreach ($notes as $note): ?>
                <div class="journal-card">
                    <i class="fas fa-chalkboard-teacher journal-icon"></i>
                    <h3><?php echo $note['title']; ?></h3>
                    <p><?php echo $note['excerpt']; ?></p>
                    <a href="curatorial.php?slug=<?php echo $note['slug']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">View Full Note →</a>
                </div>
            <?php endforeach; else: ?>
                <p>Curatorial reflections coming soon.</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
}
include 'includes/footer.php';
?>
