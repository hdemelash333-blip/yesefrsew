<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Global Art News | YESEFERSEW";
include 'includes/header.php';
$news_items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Global Art News</h1>
    <p class="section-text">Tracking Ethiopian artists on the world stage.</p>
    <div class="news-grid">
        <?php if ($news_items): foreach ($news_items as $news): ?>
            <div class="news-card">
                <i class="fas fa-university news-icon"></i>
                <h3><?php echo $news['title']; ?></h3>
                <p><?php echo $news['category']; ?></p>
                <?php if($news['content']): ?><p><?php echo $news['content']; ?></p><?php endif; ?>
                <a href="<?php echo $news['link']; ?>" target="_blank" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">View Report →</a>
            </div>
        <?php endforeach; else: ?>
            <div class="news-card">
                <i class="fas fa-university news-icon"></i>
                <h3>1-54 Contemporary African Art Fair</h3>
                <a href="#" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Exhibition Report →</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
