-- Create the database
CREATE DATABASE IF NOT EXISTS CourseGrade;
USE CourseGrade;

-- Table to store courses (subjects)
CREATE TABLE IF NOT EXISTS Courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL, 
    course_code VARCHAR(50) NOT NULL UNIQUE
);

-- Insert sample courses
INSERT INTO Courses (course_name, course_code)
VALUES
    ('C Computing', 'CIS_32'),
    ('Data Lab', 'CSC_30'),
    ('Digital Programming', 'CIS_35'),
    ('Data Structure', 'CSC_31');

-- Table to store students
CREATE TABLE IF NOT EXISTS Students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARBINARY(255) NOT NULL
);

-- Insert sample students
INSERT INTO Students (first_name, last_name, email, password_hash)
VALUES
    ('Nana', 'Dod', 'Nana.dod@gmail.com', SHA2('password111', 256)),
    ('Lili', 'Dod', 'lili.dod@gmail.com', SHA2('password222', 256)),
    ('Ali', 'Smith', 'ali.smith@gmail.com', SHA2('password333', 256)),
    ('Buba', 'Brown', 'buba.brown@gmail.com', SHA2('password444', 256)),
    ('Rol', 'Taylor', 'rol.taylor@gmail.com', SHA2('password555', 256));

-- Table to store individual assessments (Homework, Quizzes, Midterm, Final Project)
CREATE TABLE IF NOT EXISTS Assessments (
    assessment_id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT,
    assessment_type ENUM('Homework', 'Quiz', 'Midterm', 'Final Project') NOT NULL,
    assessment_number INT NOT NULL,
    max_score DECIMAL(5, 2) NOT NULL DEFAULT 100,
    weight DECIMAL(5, 2) CHECK (weight >= 0 AND weight <= 1), -- Weight of the assessment (0-1)
    FOREIGN KEY (course_id) REFERENCES Courses(course_id) ON DELETE CASCADE
);

-- Insert sample assessments for each course
INSERT INTO Assessments (course_id, assessment_type, assessment_number, weight)
VALUES
    (1, 'Homework', 1, 0.04), (1, 'Homework', 2, 0.04), (1, 'Homework', 3, 0.04), 
    (1, 'Homework', 4, 0.04), (1, 'Homework', 5, 0.04), (1, 'Quiz', 1, 0.02),
    (1, 'Quiz', 2, 0.02), (1, 'Quiz', 3, 0.02), (1, 'Quiz', 4, 0.02), (1, 'Quiz', 5, 0.02),
    (1, 'Midterm', 1, 0.3), (1, 'Final Project', 1, 0.4);

-- Table to store student scores for each assessment
CREATE TABLE IF NOT EXISTS StudentScores (
    score_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    assessment_id INT,
    score DECIMAL(5, 2) CHECK (score >= 0 AND score <= 100),
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (assessment_id) REFERENCES Assessments(assessment_id) ON DELETE CASCADE
);

-- Insert sample scores for students (Homework, Quizzes, etc.)
INSERT INTO StudentScores (student_id, assessment_id, score)
VALUES
    (1, 1, 85), (1, 2, 90), (1, 3, 78), (1, 4, 82), (1, 5, 88), -- Homework scores for student 1
    (1, 6, 75), (1, 7, 80), (1, 8, 90), (1, 9, 85), (1, 10, 92), -- Quiz scores for student 1
    (1, 11, 86), -- Midterm for student 1
    (1, 12, 91), -- Final Project for student 1
    (2, 1, 70), (2, 2, 74), (2, 3, 79), (2, 4, 85), (2, 5, 90), -- Homework scores for student 2
    (2, 6, 60), (2, 7, 68), (2, 8, 72), (2, 9, 76), (2, 10, 80), -- Quiz scores for student 2
    (2, 11, 78), -- Midterm for student 2
    (2, 12, 85); -- Final Project for student 2

-- Table to store final grades for each student in each course (after calculations)
CREATE TABLE IF NOT EXISTS FinalGrades (
    final_grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    course_id INT,
    final_grade DECIMAL(5, 2) CHECK (final_grade >= 0 AND final_grade <= 100),
    FOREIGN KEY (student_id) REFERENCES Students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES Courses(course_id) ON DELETE CASCADE
);

-- Example calculation: Insert final grade for student 1 in course 1
INSERT INTO FinalGrades (student_id, course_id, final_grade)
VALUES
    (1, 1, 87),
    (2, 1, 80);
