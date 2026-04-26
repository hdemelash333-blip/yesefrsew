<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$page_title = "YESEFERSEW | Ethiopian Art Ecosystem & Addis Adwa Biennial";
include 'includes/header.php';

// Fetch dynamic content
$essays = $pdo->query("SELECT * FROM essays WHERE status='published' ORDER BY created_at DESC LIMIT 1")->fetchAll();
$interviews = $pdo->query("SELECT * FROM interviews WHERE status='published' ORDER BY created_at DESC LIMIT 1")->fetchAll();
$calls = $pdo->query("SELECT * FROM calls_for_papers WHERE status='active' ORDER BY created_at DESC LIMIT 1")->fetchAll();
$news_items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 2")->fetchAll();
?>

<main>
    <section class="hero-platform" id="platform-home">
        <div class="container">
            <h1>Bridging Creation, Community & Commerce</h1>
            <p>The YESEFERSEW Fine Arts Network Platform is a unified, digitally-driven ecosystem that professionalizes the Ethiopian visual arts sector and connects it to the global stage.</p>
            <div class="flex justify-center gap-1 flex-wrap" style="margin-top: 2rem;">
                <a href="#network" class="btn btn-primary">Explore Network</a>
                <a href="#biennial-home" class="btn btn-secondary">Discover Biennial 2027</a>
            </div>
        </div>
    </section>

    <section class="hero-biennial" id="biennial-home">
        <div class="container">
            <div class="hero-badge">BIENNIAL EDITION</div>
            <h1>Ethiopianism</h1>
            <div class="hero-tag">Addis Adwa Art Biennial • Second Edition</div>
            <p>A new discourse on pan-Ethiopian visual identity, decolonial curatorial practice, and the emergence of a unified art infrastructure.</p>
            <div class="byline">Adwa Museum Park, Addis Ababa — 2027 Central Venue</div>
        </div>
    </section>

    <section id="journal">
        <div class="container">
            <h2 class="section-title">YESEFERSEW Journal & Newsletters</h2>
            <p class="section-text">A peer-reviewed digital publication featuring critical essays, artist interviews, curatorial statements, and monthly newsletters documenting the evolving discourse of Ethiopian contemporary art.</p>
            <div class="journal-grid">
                <?php if ($essays): foreach ($essays as $essay): ?>
                    <div class="journal-card"><i class="fas fa-feather-alt journal-icon"></i><h3><?php echo $essay['title']; ?> <?php if($essay['is_new']) echo '<span class="portal-badge">New</span>'; ?></h3><p><?php echo $essay['excerpt']; ?></p><a href="essays.php?slug=<?php echo $essay['slug']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Read Essays →</a></div>
                <?php endforeach; else: ?>
                    <div class="journal-card"><i class="fas fa-feather-alt journal-icon"></i><h3>Critical Essays <span class="portal-badge">New</span></h3><p>Scholarly articles on Ethiopian modernism, postcolonial aesthetics, and emerging practices from leading voices in the field.</p><a href="essays.php" class="btn-outline-light journal-essay-link" style="margin-top: 1rem; display: inline-block;">Read Essays →</a></div>
                <?php endif; ?>

                <?php if ($interviews): foreach ($interviews as $interview): ?>
                    <div class="journal-card"><i class="fas fa-microphone-alt journal-icon"></i><h3><?php echo $interview['title']; ?></h3><p><?php echo $interview['excerpt']; ?></p><a href="interviews.php?slug=<?php echo $interview['slug']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Explore Interviews →</a></div>
                <?php endforeach; else: ?>
                    <div class="journal-card"><i class="fas fa-microphone-alt journal-icon"></i><h3>Artist Interviews</h3><p>In-depth conversations with established and emerging Ethiopian artists about their practice, influences, and visions for the future.</p><a href="interviews.php" class="btn-outline-light journal-interview-link" style="margin-top: 1rem; display: inline-block;">Explore Interviews →</a></div>
                <?php endif; ?>

                <div class="journal-card"><i class="fas fa-newspaper journal-icon"></i><h3>Monthly Newsletter <span class="portal-badge">Subscribe</span></h3><p>Curated monthly digest featuring exhibition openings, residency opportunities, grant deadlines, and Biennial updates delivered to your inbox.</p><a href="#" class="btn-outline-light open-subscribe-modal" style="margin-top: 1rem; display: inline-block;">Subscribe Now →</a></div>

                <div class="journal-card"><i class="fas fa-chalkboard-teacher journal-icon"></i><h3>Curatorial Notes</h3><p>Exhibition reviews, curatorial methodologies, and reflections on the biennial from curators worldwide.</p><a href="curatorial.php" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">View Curatorial →</a></div>
            </div>
            <div class="subscription-form">
                <h3 style="margin-bottom: 1rem;">Subscribe to YESEFERSEW Journal & Newsletter</h3>
                <p style="margin-bottom: 1rem;">Receive quarterly journal issues, monthly newsletters, and Biennial announcements.</p>
                <button class="btn btn-primary open-subscribe-modal" style="border: none;">Open Subscription Portal →</button>
            </div>
        </div>
    </section>

    <section id="global-news">
        <div class="container">
            <h2 class="section-title">Global Art News: Ethiopian Artists on the World Stage</h2>
            <p class="section-text">Tracking the remarkable presence and achievements of Ethiopian visual artists, curators, and cultural practitioners in international exhibitions, biennials, residencies, and collections worldwide.</p>
            <div class="news-grid">
                <?php if ($news_items): foreach ($news_items as $news): ?>
                    <div class="news-card">
                        <i class="fas fa-university news-icon"></i>
                        <h3><?php echo $news['title']; ?></h3>
                        <a href="<?php echo $news['link']; ?>" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Exhibition Report →</a>
                    </div>
                <?php endforeach; else: ?>
                    <div class="news-card">
                        <i class="fas fa-university news-icon"></i>
                        <h3>1-54 Contemporary African Art Fair</h3>
                        <a href="news.php" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">Exhibition Report →</a>
                    </div>
                    <div class="news-card">
                        <i class="fas fa-palette news-icon"></i>
                        <h3>Residency Milestones</h3>
                        <a href="news.php" class="btn-outline-light" style="margin-top: 1rem; display: inline-block;">View Opportunities →</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section id="call-for-papers" class="callforpapers">
        <div class="container">
            <h2 class="section-title" style="color: var(--secondary-light); border-left-color: var(--secondary);">Call for Papers</h2>
            <?php if ($calls): foreach ($calls as $call): ?>
                <div class="cfp-grid">
                    <div class="cfp-content">
                        <h3><?php echo $call['title']; ?></h3>
                        <p class="section-text" style="color: #e0e0e0;"><?php echo $call['description']; ?></p>

                        <div class="cfp-deadline">
                            <i class="fas fa-calendar-alt" style="color: var(--secondary); margin-right: 10px;"></i>
                            <strong>Submission Deadline:</strong> <?php echo $call['deadline_text']; ?><br>
                            <i class="fas fa-clock" style="color: var(--secondary); margin-right: 10px; margin-top: 8px; display: inline-block;"></i>
                            <strong>Publication Date:</strong> <?php echo $call['publication_date_text']; ?>
                        </div>

                        <h4 style="color: var(--secondary); margin: var(--space-6) 0 var(--space-3) 0;">Suggested Topics Include:</h4>
                        <ul class="cfp-topics">
                            <?php
                            $topics = explode("\n", $call['topics']);
                            foreach($topics as $topic) {
                                if(trim($topic)) echo "<li>".trim($topic)."</li>";
                            }
                            ?>
                        </ul>

                        <a href="calls.php?slug=<?php echo $call['slug']; ?>" class="btn btn-gold" style="margin-top: var(--space-4); display: inline-block;">
                            <i class="fas fa-paper-plane"></i> Submit Your Abstract
                        </a>
                    </div>

                    <div class="cfp-sidebar">
                        <h4><i class="fas fa-info-circle"></i> Submission Guidelines</h4>
                        <div class="submission-info">
                            <?php echo $call['guidelines']; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; else: ?>
                <div class="cfp-grid">
                    <div class="cfp-content">
                        <h3>Systemic & Institutional Challenges in the Visual Art Sector</h3>
                        <p class="section-text" style="color: #e0e0e0;">YESEFERSEW Journal invites scholars, practitioners, curators, artists, and cultural policy experts to submit original research articles, critical essays, and case studies examining the structural barriers and institutional dynamics shaping contemporary visual art ecosystems—with special focus on African and diaspora contexts.</p>
                        <a href="calls.php" class="btn btn-gold" style="margin-top: var(--space-4); display: inline-block;">
                            <i class="fas fa-paper-plane"></i> Submit Your Abstract
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="pillars">
        <div class="container">
            <h2 class="section-title">Our Five Core Pillars</h2>
            <div class="pillar-container">
                <div class="pillar-card"><div class="pillar-icon"><i class="fas fa-laptop-code"></i></div><h3>Tech-Enabled Services</h3><p>Software solutions for art management, distribution, and digital showcasing.</p></div>
                <div class="pillar-card"><div class="pillar-icon"><i class="fas fa-users"></i></div><h3>Networking</h3><p>Formalizing connections between local and international artists, galleries, and institutions.</p></div>
                <div class="pillar-card"><div class="pillar-icon"><i class="fas fa-archive"></i></div><h3>Digital Archiving</h3><p>High-quality profiling, standardized catalogs, and professional portfolios.</p></div>
                <div class="pillar-card"><div class="pillar-icon"><i class="fas fa-newspaper"></i></div><h3>Media & Critique</h3><p>A dedicated source for news, reviews, and critical discourse on Ethiopian contemporary art.</p></div>
                <div class="pillar-card"><div class="pillar-icon"><i class="fas fa-graduation-cap"></i></div><h3>Education</h3><p>E-learning modules, virtual forums, workshops, and resources for artistic growth.</p></div>
            </div>
        </div>
    </section>

    <section id="network">
        <div class="container">
            <h2 class="section-title">YESEFERSEW Network: The Professional Ecosystem</h2>
            <p class="section-text">Ethiopia's first comprehensive professional network dedicated to visual artists, curators, galleries, critics, and cultural institutions — growing daily with active members across the country and diaspora.</p>
            <div class="network-grid">
                <div class="network-card"><i class="fas fa-user-plus network-icon"></i><h3>Artist Membership</h3><p>Professional portfolios, exhibition opportunities, grant access, and peer mentorship.</p><a href="membership.php?type=artist" class="btn-outline-light">Register as Artist →</a></div>
                <div class="network-card"><i class="fas fa-chalkboard-user network-icon"></i><h3>Curators & Critics</h3><p>Curatorial exchanges, review platforms, and critical discourse networks.</p><a href="membership.php?type=curator" class="btn-outline-light">Join Curatorial Network →</a></div>
                <div class="network-card"><i class="fas fa-building network-icon"></i><h3>Institutional Partners</h3><p>Galleries, museums, universities, and cultural centers collaborating with YESEFERSEW.</p><a href="membership.php?type=institution" class="btn-outline-light">Become Partner →</a></div>
                <div class="network-card"><i class="fas fa-globe-africa network-icon"></i><h3>Diaspora Network</h3><p>Ethiopian artists and professionals across the global diaspora connected through YESEFERSEW.</p><a href="membership.php?type=diaspora" class="btn-outline-light">Join Diaspora Network →</a></div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
