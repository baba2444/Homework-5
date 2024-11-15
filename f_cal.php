<?php
require_once 'functions.php';

// Database configuration
$servername = "localhost";
$username = "csc350";
$password = "xampp";
$dbname = "CourseGrade";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure Assessments table is populated
$conn->query("
    INSERT IGNORE INTO Assessments (assessment_id, weight) VALUES
    (1, 0.1), (2, 0.1), (3, 0.1), (4, 0.1), (5, 0.1), -- Homework
    (6, 0.05), (7, 0.05), (8, 0.05), (9, 0.05), (10, 0.05), -- Quizzes
    (11, 0.3), -- Midterm
    (12, 0.2) -- Final Project
");

// Ensure Students table has the student record
$student_id = 1;
$conn->query("INSERT IGNORE INTO Students (student_id, first_name, last_name) VALUES ($student_id, 'John', 'Doe')");

// Sample data for grades
$homework = [90, 85, 88, 92, 87];
$quizzes = [78, 82, 85, 80, 79];
$midterm = 86;
$final_project = 90;

// Insert grades
insertGrades($student_id, $homework, $quizzes, $midterm, $final_project, $conn);

echo "Grades inserted successfully.";

$conn->close();
?>
