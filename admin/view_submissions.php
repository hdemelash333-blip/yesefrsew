<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) redirect('login.php');

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM paper_submissions WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    redirect('view_submissions.php');
}

$submissions = $pdo->query("SELECT s.*, c.title as call_title FROM paper_submissions s LEFT JOIN calls_for_papers c ON s.call_id = c.id ORDER BY s.created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Submissions | YESEFERSEW Admin</title>
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
        .btn { padding: 0.5rem 1rem; border-radius: 0.3rem; text-decoration: none; font-size: 0.8rem; cursor: pointer; border: none; }
        .btn-view { background: #007bff; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 2rem; border-radius: 1rem; width: 800px; max-height: 90vh; overflow-y: auto; }
        .detail-row { margin-bottom: 1rem; border-bottom: 1px solid #eee; padding-bottom: 0.5rem; }
        .detail-label { font-weight: bold; color: #555; display: block; margin-bottom: 0.2rem; }
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
            <li><a href="view_submissions.php" class="active"><i class="fas fa-file-invoice"></i> Submissions</a></li>
            <li><a href="manage_members.php"><i class="fas fa-users"></i> Members</a></li>
            <li><a href="manage_subscribers.php"><i class="fas fa-envelope"></i> Subscribers</a></li>
            <li><a href="logout.php" style="margin-top: 2rem; color: #ff6b6b;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Paper Submissions</h1>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Call</th>
                    <th>Paper Title</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $sub): ?>
                <tr>
                    <td><?php echo htmlspecialchars($sub['name']); ?></td>
                    <td><?php echo htmlspecialchars($sub['email']); ?></td>
                    <td><?php echo htmlspecialchars($sub['call_title']); ?></td>
                    <td><?php echo htmlspecialchars($sub['paper_title']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($sub['created_at'])); ?></td>
                    <td>
                        <button class="btn btn-view" onclick='viewSub(<?php echo htmlspecialchars(json_encode($sub), ENT_QUOTES, "UTF-8"); ?>)'>View Details</button>
                        <a href="?delete=<?php echo $sub['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this submission?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="subModal" class="modal">
        <div class="modal-content">
            <h2>Submission Details</h2>
            <div id="subDetails"></div>
            <button type="button" class="btn btn-delete" onclick="hideModal()">Close</button>
        </div>
    </div>

    <script>
        function hideModal() { document.getElementById('subModal').style.display = 'none'; }
        function viewSub(sub) {
            let details = `
                <div class="detail-row"><span class="detail-label">Call for Papers</span>${sub.call_title}</div>
                <div class="detail-row"><span class="detail-label">Name</span>${sub.name}</div>
                <div class="detail-row"><span class="detail-label">Email</span>${sub.email}</div>
                <div class="detail-row"><span class="detail-label">Affiliation</span>${sub.affiliation}</div>
                <div class="detail-row"><span class="detail-label">Paper Title</span>${sub.paper_title}</div>
                <div class="detail-row"><span class="detail-label">Keywords</span>${sub.keywords}</div>
                <div class="detail-row"><span class="detail-label">Abstract</span><p>${sub.abstract.replace(/\n/g, '<br>')}</p></div>
                <div class="detail-row"><span class="detail-label">Submitted On</span>${sub.created_at}</div>
            `;
            document.getElementById('subDetails').innerHTML = details;
            document.getElementById('subModal').style.display = 'flex';
        }
    </script>
</body>
</html>
