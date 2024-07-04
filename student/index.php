<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'student') {
    header('Location: ../login.php');
    exit();
}

$student_id = $_SESSION['user_id'];

// 获取学生成绩
$sql = "SELECT * FROM student_scores WHERE student_id='$student_id'";
$result = $conn->query($sql);
$scores = $result->fetch_assoc();

// 获取所有学生的排名
$sql_rank = "SELECT student_id, total_score, FIND_IN_SET( total_score, (
    SELECT GROUP_CONCAT( total_score ORDER BY total_score DESC )
    FROM student_scores )
    ) AS rank
    FROM student_scores
    WHERE student_id='$student_id'";
$result_rank = $conn->query($sql_rank);
$rank = $result_rank->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>我的成绩</title>
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
            padding: 20px 40px;
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
            margin-bottom: 20px;
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
    </style>
</head>
<body>
    <div class="container">
        <h2>我的成绩</h2>
        <table>
            <tr>
                <th>课堂表现</th>
                <td><?php echo htmlspecialchars($scores['class_performance'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>实验</th>
                <td><?php echo htmlspecialchars($scores['experiment_performance'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>课后作业</th>
                <td><?php echo htmlspecialchars($scores['homework_performance'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>大作业</th>
                <td><?php echo htmlspecialchars($scores['project_performance'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>普通加分</th>
                <td><?php echo htmlspecialchars($scores['regular_bonus'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>特别加分</th>
                <td><?php echo htmlspecialchars($scores['special_bonus'] ?? '暂无'); ?></td>
            </tr>
            <tr>
                <th>排名</th>
                <td><?php echo $rank['rank'] ?? '暂无'; ?></td>
            </tr>
        </table>
        <a href="../logout.php">注销</a>
    </div>
</body>
</html>
