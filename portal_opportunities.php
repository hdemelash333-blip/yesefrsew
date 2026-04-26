<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Opportunities Portal | YESEFERSEW";
include 'includes/header.php';

// Fetch opportunities from DB
$opportunities = $pdo->query("SELECT * FROM opportunities ORDER BY created_at DESC")->fetchAll();
?>
<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Opportunities Portal</h1>
    <p class="section-text">Curated listings of residencies, open calls, fellowships, and job opportunities for Ethiopian visual arts professionals.</p>

    <div class="news-grid">
        <?php if ($opportunities): foreach ($opportunities as $opp): ?>
            <div class="news-card">
                <i class="fas fa-bullhorn news-icon"></i>
                <h3><?php echo htmlspecialchars($opp['title']); ?></h3>
                <p><?php echo htmlspecialchars($opp['description']); ?></p>
                <div style="margin-top: 1rem; color: var(--gold);">Deadline: <?php echo htmlspecialchars($opp['deadline']); ?></div>
                <a href="<?php echo htmlspecialchars($opp['link']); ?>" class="btn btn-gold" style="margin-top: 1rem; display: inline-block;">View Details →</a>
            </div>
        <?php endforeach; else: ?>
            <div class="news-card">
                <i class="fas fa-palette news-icon"></i>
                <h3>Residency Milestones</h3>
                <p>International residency opportunities for Ethiopian artists.</p>
                <a href="#" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Launching Soon →</a>
            </div>
            <div class="news-card">
                <i class="fas fa-file-contract news-icon"></i>
                <h3>Grant Deadlines</h3>
                <p>Upcoming funding opportunities for research and creation.</p>
                <a href="#" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Launching Soon →</a>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php include 'includes/footer.php'; ?>
