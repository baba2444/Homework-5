<?php
// Database connection
$servername = "localhost";
$username = "csc350";
$password = "xampp";
$dbname = "CourseGrade";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to insert student grades securely
function insertGrades($student_id, $homework, $quizzes, $midterm, $final_project, $conn) {
    // Assessment IDs for Homework, Quizzes, Midterm, and Final Project
    $homework_assessment_ids = [1, 2, 3, 4, 5];  // Update with actual homework assessment IDs
    $quiz_assessment_ids = [6, 7, 8, 9, 10];     // Update with actual quiz assessment IDs
    $midterm_assessment_id = 11;                 // Midterm assessment ID
    $final_project_assessment_id = 12;           // Final project assessment ID

    // Insert each homework score
    foreach ($homework as $index => $score) {
        $stmt = $conn->prepare("INSERT INTO StudentScores (student_id, assessment_id, score) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $student_id, $homework_assessment_ids[$index], $score);
        $stmt->execute();
        $stmt->close();
    }

    // Insert each quiz score
    foreach ($quizzes as $index => $score) {
        $stmt = $conn->prepare("INSERT INTO StudentScores (student_id, assessment_id, score) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $student_id, $quiz_assessment_ids[$index], $score);
        $stmt->execute();
        $stmt->close();
    }

    // Insert midterm score
    $stmt = $conn->prepare("INSERT INTO StudentScores (student_id, assessment_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $student_id, $midterm_assessment_id, $midterm);
    $stmt->execute();
    $stmt->close();

    // Insert final project score
    $stmt = $conn->prepare("INSERT INTO StudentScores (student_id, assessment_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iid", $student_id, $final_project_assessment_id, $final_project);
    $stmt->execute();
    $stmt->close();
}

// Function to calculate and retrieve final grades for each student
function getFinalGrades($conn) {
    $sql = "
        SELECT s.student_id, s.first_name, s.last_name,
               ROUND(SUM(ss.score * a.weight), 2) AS final_grade
        FROM Students s
        JOIN StudentScores ss ON s.student_id = ss.student_id
        JOIN Assessments a ON ss.assessment_id = a.assessment_id
        GROUP BY s.student_id;
    ";

    $result = $conn->query($sql);

    $grades = [];
    while ($row = $result->fetch_assoc()) {
        $grades[] = $row;
    }

    return $grades;
}
