<?php
// Include the functions file
require_once '../functions.php'; // Adjust the path to functions.php

// Database configuration
$servername = "localhost";
$username = "csc350";
$password = "xampp";
$dbname = "CourseGrade";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function to check test results
function assertEqual($actual, $expected, $testName) {
    if ($actual === $expected) {
        echo "<p style='color: green;'>PASS: $testName</p>";
    } else {
        echo "<p style='color: red;'>FAIL: $testName - Expected $expected, got $actual</p>";
    }
}

// Test for insertGrades function
function testInsertGrades($conn) {
    echo "<h3>Testing insertGrades</h3>";

    // Clean up any existing data
    $conn->query("DELETE FROM Students WHERE student_id = 1");
    $conn->query("DELETE FROM StudentScores WHERE student_id = 1");
    $conn->query("DELETE FROM Assessments WHERE assessment_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)");

    // Insert the required assessments
    $conn->query("
        INSERT INTO Assessments (assessment_id, weight) VALUES
        (1, 0.1), (2, 0.1), (3, 0.1), (4, 0.1), (5, 0.1), -- Homework
        (6, 0.05), (7, 0.05), (8, 0.05), (9, 0.05), (10, 0.05), -- Quizzes
        (11, 0.3), -- Midterm
        (12, 0.2) -- Final Project
    ");

    // Insert the student record
    $conn->query("INSERT INTO Students (student_id, first_name, last_name) VALUES (1, 'John', 'Doe')");

    // Sample data
    $student_id = 1;
    $homework = [90, 85, 88, 92, 87];
    $quizzes = [78, 82, 85, 80, 79];
    $midterm = 86;
    $final_project = 90;

    // Call the function
    insertGrades($student_id, $homework, $quizzes, $midterm, $final_project, $conn);

    // Verify data insertion
    $result = $conn->query("SELECT COUNT(*) AS count FROM StudentScores WHERE student_id = $student_id");
    $row = $result->fetch_assoc();
    assertEqual((int)$row['count'], 12, "Correct number of scores inserted");

    // Clean up
    $conn->query("DELETE FROM StudentScores WHERE student_id = $student_id");
    $conn->query("DELETE FROM Students WHERE student_id = $student_id");
    $conn->query("DELETE FROM Assessments WHERE assessment_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12)");
}


// Test for getFinalGrades function
function testGetFinalGrades($conn) {
    echo "<h3>Testing getFinalGrades</h3>";

    // Clean up any existing data
    $conn->query("DELETE FROM Students WHERE student_id = 1");
    $conn->query("DELETE FROM StudentScores WHERE student_id = 1");
    $conn->query("DELETE FROM Assessments WHERE assessment_id IN (1, 2, 3)");

    // Insert mock data
    $conn->query("INSERT INTO Students (student_id, first_name, last_name) VALUES (1, 'John', 'Doe')");
    $conn->query("INSERT INTO Assessments (assessment_id, weight) VALUES (1, 0.2), (2, 0.2), (3, 0.6)");
    $conn->query("INSERT INTO StudentScores (student_id, assessment_id, score) VALUES (1, 1, 90), (1, 2, 80), (1, 3, 85)");

    // Call the function
    $grades = getFinalGrades($conn);

    // Check if grade exists for John Doe
    $found = false;
    foreach ($grades as $grade) {
        if ($grade['student_id'] == 1) {
            assertEqual((float)$grade['final_grade'], 85.0, "Final grade calculated correctly");
            $found = true;
        }
    }
    assertEqual($found, true, "Final grade returned for student John Doe");

    // Clean up
    $conn->query("DELETE FROM StudentScores WHERE student_id = 1");
    $conn->query("DELETE FROM Students WHERE student_id = 1");
    $conn->query("DELETE FROM Assessments WHERE assessment_id IN (1, 2, 3)");
}

// Run all tests
testInsertGrades($conn);
testGetFinalGrades($conn);

// Close connection
$conn->close();
?>
