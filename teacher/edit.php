<?php
require_once '../config/database.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'teacher') {
    header('Location: ../login.php');
    exit();
}

$student_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_performance = $_POST['class_performance'];
    $experiment_performance = $_POST['experiment_performance'];
    $homework_performance = $_POST['homework_performance'];
    $project_performance = $_POST['project_performance'];
    $regular_bonus = $_POST['regular_bonus'];
    $special_bonus = $_POST['special_bonus'];

    // 计算总成绩 (可以根据需要调整权重)
    $total_score = $class_performance + $experiment_performance + $homework_performance + $project_performance + $regular_bonus + $special_bonus;

    $sql = "REPLACE INTO student_scores (student_id, class_performance, experiment_performance, homework_performance, project_performance, regular_bonus, special_bonus, total_score) VALUES ('$student_id', '$class_performance', '$experiment_performance', '$homework_performance', '$project_performance', '$regular_bonus', '$special_bonus', '$total_score')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql = "SELECT * FROM student_scores WHERE student_id='$student_id'";
$result = $conn->query($sql);
$scores = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>录入成绩</title>
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
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            color: #555;
        }
        input[type="number"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px;
            background-color: #5cb85c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }
        button:hover {
            background-color: #4cae4c;
        }
        a {
            margin-top: 20px;
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
        <h2>录入成绩</h2>
        <form method="post" action="edit.php?id=<?php echo htmlspecialchars($student_id); ?>">
            <label for="class_performance">课堂表现:</label>
            <input type="number" id="class_performance" name="class_performance" value="<?php echo htmlspecialchars($scores['class_performance'] ?? 0); ?>">
            <label for="experiment_performance">实验:</label>
            <input type="number" id="experiment_performance" name="experiment_performance" value="<?php echo htmlspecialchars($scores['experiment_performance'] ?? 0); ?>">
            <label for="homework_performance">课后作业:</label>
            <input type="number" id="homework_performance" name="homework_performance" value="<?php echo htmlspecialchars($scores['homework_performance'] ?? 0); ?>">
            <label for="project_performance">大作业:</label>
            <input type="number" id="project_performance" name="project_performance" value="<?php echo htmlspecialchars($scores['project_performance'] ?? 0); ?>">
            <label for="regular_bonus">普通加分:</label>
            <input type="number" id="regular_bonus" name="regular_bonus" value="<?php echo htmlspecialchars($scores['regular_bonus'] ?? 0); ?>">
            <label for="special_bonus">特别加分:</label>
            <input type="number" id="special_bonus" name="special_bonus" value="<?php echo htmlspecialchars($scores['special_bonus'] ?? 0); ?>">
            <button type="submit">保存</button>
        </form>
        <a href="index.php">返回</a>
    </div>
</body>
</html>

