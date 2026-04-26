<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

if (!is_admin_logged_in()) redirect('login.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_item'])) {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $title = sanitize($_POST['title']);
    $slug = get_slug($title);
    $description = $_POST['description'];
    $deadline = sanitize($_POST['deadline_text']);
    $pub_date = sanitize($_POST['publication_date_text']);
    $topics = $_POST['topics'];
    $guidelines = $_POST['guidelines'];
    $status = $_POST['status'];

    if ($id) {
        $stmt = $pdo->prepare("UPDATE calls_for_papers SET title=?, slug=?, description=?, deadline_text=?, publication_date_text=?, topics=?, guidelines=?, status=? WHERE id=?");
        $stmt->execute([$title, $slug, $description, $deadline, $pub_date, $topics, $guidelines, $status, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO calls_for_papers (title, slug, description, deadline_text, publication_date_text, topics, guidelines, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $slug, $description, $deadline, $pub_date, $topics, $guidelines, $status]);
    }
    redirect('manage_calls.php');
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare("DELETE FROM calls_for_papers WHERE id=?");
    $stmt->execute([$_GET['delete']]);
    redirect('manage_calls.php');
}

$items = $pdo->query("SELECT * FROM calls_for_papers ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Calls | YESEFERSEW Admin</title>
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
        .modal-content { background: white; padding: 2rem; border-radius: 1rem; width: 700px; max-height: 90vh; overflow-y: auto; }
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
            <li><a href="manage_news.php"><i class="fas fa-newspaper"></i> News</a></li>
            <li><a href="manage_calls.php" class="active"><i class="fas fa-file-alt"></i> Calls for Papers</a></li>
            <li><a href="manage_members.php"><i class="fas fa-users"></i> Members</a></li>
            <li><a href="manage_subscribers.php"><i class="fas fa-envelope"></i> Subscribers</a></li>
            <li><a href="logout.php" style="margin-top: 2rem; color: #ff6b6b;"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h1>Manage Calls for Papers</h1>
        <button class="btn btn-add" onclick="showModal()">Add New Call</button>

        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['title']; ?></td>
                    <td><?php echo $item['deadline_text']; ?></td>
                    <td><?php echo $item['status']; ?></td>
                    <td>
                        <button class="btn btn-edit" onclick='editItem(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, "UTF-8"); ?>)'>Edit</button>
                        <a href="?delete=<?php echo $item['id']; ?>" class="btn btn-delete" onclick="return confirm('Delete this call?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="itemModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Add New Call</h2>
            <form method="POST">
                <input type="hidden" name="id" id="itemId">
                <label>Title</label>
                <input type="text" name="title" id="itemTitle" required>
                <label>Description</label>
                <textarea name="description" id="itemDesc" rows="5"></textarea>
                <label>Deadline Text</label>
                <input type="text" name="deadline_text" id="itemDeadline">
                <label>Publication Date Text</label>
                <input type="text" name="publication_date_text" id="itemPubDate">
                <label>Topics (One per line)</label>
                <textarea name="topics" id="itemTopics" rows="5"></textarea>
                <label>Guidelines (HTML allowed)</label>
                <textarea name="guidelines" id="itemGuidelines" rows="5"></textarea>
                <label>Status</label>
                <select name="status" id="itemStatus">
                    <option value="active">Active</option>
                    <option value="closed">Closed</option>
                </select>
                <button type="submit" name="save_item" class="btn btn-add">Save</button>
                <button type="button" class="btn btn-delete" onclick="hideModal()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function showModal() {
            document.getElementById('itemModal').style.display = 'flex';
            document.getElementById('modalTitle').innerText = 'Add New Call';
            document.getElementById('itemId').value = '';
            document.getElementById('itemTitle').value = '';
            document.getElementById('itemDesc').value = '';
            document.getElementById('itemDeadline').value = '';
            document.getElementById('itemPubDate').value = '';
            document.getElementById('itemTopics').value = '';
            document.getElementById('itemGuidelines').value = '';
        }
        function hideModal() { document.getElementById('itemModal').style.display = 'none'; }
        function editItem(item) {
            showModal();
            document.getElementById('modalTitle').innerText = 'Edit Call';
            document.getElementById('itemId').value = item.id;
            document.getElementById('itemTitle').value = item.title;
            document.getElementById('itemDesc').value = item.description;
            document.getElementById('itemDeadline').value = item.deadline_text;
            document.getElementById('itemPubDate').value = item.publication_date_text;
            document.getElementById('itemTopics').value = item.topics;
            document.getElementById('itemGuidelines').value = item.guidelines;
            document.getElementById('itemStatus').value = item.status;
        }
    </script>
</body>
</html>
