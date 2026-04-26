<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) redirect('login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_item'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $title = sanitize($_POST['title']);
    $category = sanitize($_POST['category']);
    $content = sanitize($_POST['content']);
    $link = sanitize($_POST['link']);

    if ($id) {
        $stmt = $pdo->prepare("UPDATE news SET title=?, category=?, content=?, link=? WHERE id=?");
        $stmt->execute([$title, $category, $content, $link, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO news (title, category, content, link) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $category, $content, $link]);
    }
    redirect('manage_news.php');
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM news WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    redirect('manage_news.php');
}

$items = $pdo->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage News | YESEFERSEW Admin</title>
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
        .btn-add { background: var(--primary); color: var(--dark); margin-bottom: 1rem; display: inline-block; }
        .btn-edit { background: #007bff; color: white; }
        .btn-delete { background: #dc3545; color: white; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .modal-content { background: white; padding: 2rem; border-radius: 1rem; width: 600px; max-height: 90vh; overflow-y: auto; }
        input, textarea, select { width: 100%; padding: 0.8rem; margin: 0.5rem 0; border: 1px solid #ddd; border-radius: 0.5rem; box-sizing: border-box; }
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
            <li><a href="manage_news.php" class="active"><i class="fas fa-newspaper"></i> News</a></li>
            <li><a href="manage_calls.php"><i class="fas fa-file-alt"></i> Calls for Papers</a></li>
            <li><a href="manage_members.php"><i class="fas fa-users"></i> Members</a></li>
            <li><a href="manage_subscribers.php"><i class="fas fa-envelope"></i> Subscribers</a></li>
            <li><a href="logout.php" style="margin-top: 2rem; color: #ff6b6b;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Manage Global Art News</h1>
        <button class="btn btn-add" onclick="showModal()">Add News Item</button>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['title']; ?></td>
                    <td><?php echo $item['category']; ?></td>
                    <td><?php echo date('Y-m-d', strtotime($item['created_at'])); ?></td>
                    <td>
                        <button class="btn btn-edit" onclick='editItem(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, "UTF-8"); ?>)'>Edit</button>
                        <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this item?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="itemModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Add News Item</h2>
            <form method="POST">
                <input type="hidden" name="id" id="itemId">
                <label>Title</label>
                <input type="text" name="title" id="itemTitle" required>
                <label>Category</label>
                <input type="text" name="category" id="itemCategory" placeholder="e.g. 1-54, Exhibition, Residency">
                <label>Content</label>
                <textarea name="content" id="itemContent" rows="3"></textarea>
                <label>Link</label>
                <input type="url" name="link" id="itemLink">
                <button type="submit" name="save_item" class="btn btn-add">Save</button>
                <button type="button" class="btn btn-delete" onclick="hideModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('itemModal').style.display = 'flex';
            document.getElementById('modalTitle').innerText = 'Add News Item';
            document.getElementById('itemId').value = '';
            document.getElementById('itemTitle').value = '';
            document.getElementById('itemCategory').value = '';
            document.getElementById('itemContent').value = '';
            document.getElementById('itemLink').value = '';
        }
        function hideModal() { document.getElementById('itemModal').style.display = 'none'; }
        function editItem(item) {
            showModal();
            document.getElementById('modalTitle').innerText = 'Edit News Item';
            document.getElementById('itemId').value = item.id;
            document.getElementById('itemTitle').value = item.title;
            document.getElementById('itemCategory').value = item.category;
            document.getElementById('itemContent').value = item.content;
            document.getElementById('itemLink').value = item.link;
        }
    </script>
</body>
</html>
