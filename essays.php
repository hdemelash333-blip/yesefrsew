<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : null;

if ($slug) {
    $stmt = $pdo->prepare("SELECT * FROM essays WHERE slug = ? AND status = 'published'");
    $stmt->execute([$slug]);
    $essay = $stmt->fetch();

    if (!$essay) {
        redirect('essays.php');
    }

    $page_title = $essay['title'] . " | YESEFERSEW Essays";
    include 'includes/header.php';
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title"><?php echo $essay['title']; ?></h1>
        <?php if($essay['image']): ?>
            <img src="<?php echo $essay['image']; ?>" alt="<?php echo $essay['title']; ?>" style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 1rem; margin-bottom: 2rem;">
        <?php endif; ?>
        <div class="byline">By <?php echo $essay['author']; ?> | <?php echo date('F j, Y', strtotime($essay['created_at'])); ?></div>
        <div class="section-text" style="margin-top: 2rem;">
            <?php echo nl2br($essay['content']); ?>
        </div>
        <a href="essays.php" class="btn btn-secondary" style="margin-top: 2rem;">← Back to Essays</a>
    </main>
    <?php
} else {
    $page_title = "Critical Essays | YESEFERSEW Journal";
    include 'includes/header.php';
    $essays = $pdo->query("SELECT * FROM essays WHERE status='published' ORDER BY created_at DESC")->fetchAll();
    ?>
    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        <h1 class="section-title">Critical Essays</h1>
        <p class="section-text">Scholarly articles on Ethiopian modernism, postcolonial aesthetics, and emerging practices.</p>
        <div class="journal-grid">
            <?php if ($essays): foreach ($essays as $essay): ?>
                <div class="journal-card">
                    <h3><?php echo $essay['title']; ?></h3>
                    <p><?php echo $essay['excerpt']; ?></p>
                    <a href="essays.php?slug=<?php echo $essay['slug']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Read Full Essay →</a>
                </div>
            <?php endforeach; else: ?>
                <p>No essays published yet. Check back soon!</p>
            <?php endif; ?>
        </div>
    </main>
    <?php
}
include 'includes/footer.php';
?>
