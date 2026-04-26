<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "Opportunities & Residencies | YESEFERSEW";
include 'includes/header.php';
$items = $pdo->query("SELECT * FROM opportunities WHERE status='active' ORDER BY deadline ASC")->fetchAll();
?>

<main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
    <h1 class="section-title">Opportunities & Residencies</h1>
    <p class="section-text">Curated listings of residencies, open calls, and grants for the Ethiopian art community.</p>

    <div class="news-grid">
        <?php if ($items): foreach ($items as $item): ?>
            <div class="news-card">
                <i class="fas fa-palette news-icon"></i>
                <h3><?php echo $item['title']; ?></h3>
                <p><strong>Deadline:</strong> <?php echo $item['deadline']; ?></p>
                <div class="section-text"><?php echo nl2br($item['description']); ?></div>
                <a href="<?php echo $item['link']; ?>" target="_blank" class="btn btn-primary">Apply Now</a>
            </div>
        <?php endforeach; else: ?>
            <div class="news-card">
                <i class="fas fa-palette news-icon"></i>
                <h3>Global South Artist Residency 2025</h3>
                <p><strong>Deadline:</strong> August 30, 2024</p>
                <p>A fully funded 3-month residency in Berlin for artists from the Global South...</p>
                <a href="#" class="btn-outline-light">View Details →</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
