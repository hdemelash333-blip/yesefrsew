<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) redirect('login.php');

$items = $pdo->query("SELECT * FROM members ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Members | YESEFERSEW Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --sidebar-w: 250px; --primary: #D4AF37; --bg: #f4f7f6; --dark: #1a1a2e; }
        body { font-family: 'Inter', sans-serif; margin: 0; display: flex; background: var(--bg); }
        .sidebar { width: var(--sidebar-w); background: var(--dark); color: white; height: 100vh; position: fixed; }
        .sidebar h2 { padding: 1.5rem; color: var(--primary); font-size: 1.2rem; border-bottom: 1px solid #2c2c44; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar li a { display: block; padding: 1rem 1.5rem; color: #b8c0d4; text-decoration: none; transition: 0.3s; }
        .sidebar li a:hover, .sidebar li a.active { background: #2c2c44; color: var(--primary); }
        .main-content { margin-left: var(--sidebar-w); flex: 1; padding: 2rem; }
        table { width: 100%; background: white; border-collapse: collapse; margin-top: 1rem; border-radius: 0.5rem; overflow: hidden; }
        th, td { padding: 1rem; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>YESEFERSEW ADMIN</h2>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="manage_essays.php"><i class="fas fa-feather-alt"></i> Essays</a></li>
            <li><a href="manage_interviews.php"><i class="fas fa-microphone-alt"></i> Interviews</a></li>
            <li><a href="manage_curatorial.php"><i class="fas fa-chalkboard-teacher"></i> Curatorial</a></li>
            <li><a href="manage_news.php"><i class="fas fa-newspaper"></i> News</a></li>
            <li><a href="manage_exhibitions.php"><i class="fas fa-university"></i> Exhibitions</a></li>
            <li><a href="manage_opportunities.php"><i class="fas fa-bullhorn"></i> Opportunities</a></li>
            <li><a href="manage_calls.php"><i class="fas fa-file-alt"></i> Calls for Papers</a></li>
            <li><a href="view_submissions.php"><i class="fas fa-file-invoice"></i> Submissions</a></li>
            <li><a href="manage_members.php" class="active"><i class="fas fa-users"></i> Members</a></li>
            <li><a href="manage_subscribers.php"><i class="fas fa-envelope"></i> Subscribers</a></li>
            <li><a href="logout.php" style="margin-top: 2rem; color: #ff6b6b;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Registered Members</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Details</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['email']; ?></td>
                    <td><?php echo ucfirst($item['type']); ?></td>
                    <td>
                        <?php
                        if($item['discipline']) echo "Disc: ".$item['discipline'];
                        if($item['country']) echo "Country: ".$item['country'];
                        if($item['affiliation']) echo "Affil: ".$item['affiliation'];
                        ?>
                    </td>
                    <td><?php echo date('Y-m-d', strtotime($item['created_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
