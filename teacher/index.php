<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header('Location: ../login.php');
    exit();
}

$sql = "SELECT * FROM users WHERE role='student'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学生列表</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f8ff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 19px 42px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 21px;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9f9f9;
        }
        td {
            border: 1px solid #ddd;
        }
        a {
            display: block;
            text-align: center;
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }
        a:hover {
            background-color: #4cae4c;
        }
        .edit-link {
            color: #5cb85c;
            text-decoration: none;
        }
        .edit-link:hover {
            color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>学生列表</h2>
        <table>
            <thead>
                <tr>
                    <th>学生名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['username']); ?></td>
                    <td><a href="edit.php?id=<?php echo $student['id']; ?>">录入成绩</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="../logout.php">注销</a>
    </div>
</body>
</html>
