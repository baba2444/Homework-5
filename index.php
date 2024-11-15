<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Grading Tool</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Enter Student Grades</h1>
    <form method="POST" action="f_cal.php">
        <label for="student_id">Student ID</label>
        <input type="number" name="student_id" required>

        <h2>Homework Grades</h2>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label for="homework<?php echo $i; ?>">Homework <?php echo $i; ?></label>
            <input type="number" name="homework[]" required>
        <?php endfor; ?>

        <h2>Quiz Grades</h2>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label for="quiz<?php echo $i; ?>">Quiz <?php echo $i; ?></label>
            <input type="number" name="quiz[]" required>
        <?php endfor; ?>

        <label for="midterm">Midterm</label>
        <input type="number" name="midterm" required>

        <label for="final_project">Final Project</label>
        <input type="number" name="final_project" required>

        <input type="submit" value="Calculate Final Grade">
    </form>

    <section>
        <h2>Student Grades</h2>
        <a href="view_grades.php">View All Final Grades</a>
    </section>
</body>
</html>
