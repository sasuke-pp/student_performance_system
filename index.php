<?php
session_start();
require_once 'config/database.php';

// 如果用户已经登录，检查他们的角色并重定向到相应的页面
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'student') {
        header('Location: student/index.php');
        exit();
    } elseif ($_SESSION['role'] == 'teacher') {
        header('Location: teacher/index.php');
        exit();
    }
} else {
    // 如果用户未登录，重定向到登录页面
    header('Location: login.php');
    exit();
}
?>
