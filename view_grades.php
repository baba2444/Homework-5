<?php
include('functions.php');
$final_grades = getFinalGrades($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Final Grades</h1>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Final Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($final_grades as $grade): ?>
                <tr>
                    <td><?php echo $grade['student_id']; ?></td>
                    <td><?php echo $grade['first_name']; ?></td>
                    <td><?php echo $grade['last_name']; ?></td>
                    <td><?php echo $grade['final_grade']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php">Enter More Grades</a>
</body>
</html>
