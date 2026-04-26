<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Exhibition Reports | YESEFERSEW";
include 'includes/header.php';
$items = $pdo->query("SELECT * FROM exhibitions ORDER BY created_at DESC")->fetchAll();
?>

<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Exhibition Reports</h1>
    <p class="section-text">Detailed reports and reviews from international art fairs and exhibitions featuring Ethiopian artists.</p>

    <div class="news-grid">
        <?php if ($items): foreach ($items as $item): ?>
            <div class="news-card">
                <i class="fas fa-university news-icon"></i>
                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                <p><strong>Venue:</strong> <?php echo htmlspecialchars($item['venue']); ?></p>
                <p><strong>Dates:</strong> <?php echo htmlspecialchars($item['dates']); ?></p>
                <div class="section-text" style="margin-top: 1rem;"><?php echo nl2br(htmlspecialchars($item['description'])); ?></div>
                <?php if($item['link']): ?>
                    <a href="<?php echo htmlspecialchars($item['link']); ?>" target="_blank" class="btn btn-secondary" style="margin-top: 1rem; display: inline-block;">External Link →</a>
                <?php endif; ?>
            </div>
        <?php endforeach; else: ?>
            <div class="news-card">
                <i class="fas fa-university news-icon"></i>
                <h3>1-54 Contemporary African Art Fair 2024</h3>
                <p>Marrakech Edition</p>
                <p>Ethiopian artists showed a strong presence at this year's 1-54 Marrakech...</p>
                <a href="#" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Read Full Report →</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
