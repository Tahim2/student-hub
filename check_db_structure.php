<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=student_hub', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Current Database Structure ===\n\n";
    
    // Check courses table
    echo "Courses:\n";
    $stmt = $pdo->query('SELECT id, course_code, course_name, semester FROM courses LIMIT 10');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['course_code']}: {$row['course_name']} (Semester: {$row['semester']})\n";
    }
    
    echo "\n\nFaculty Course Assignments:\n";
    $stmt = $pdo->query('SELECT * FROM faculty_course_assignments LIMIT 5');
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($assignments) > 0) {
        foreach ($assignments as $assignment) {
            echo "- Faculty ID: {$assignment['faculty_id']}, Course ID: {$assignment['course_id']}, Semester: {$assignment['semester']}\n";
        }
    } else {
        echo "No assignments found.\n";
    }
    
    echo "\n\nStudent Courses:\n";
    $stmt = $pdo->query('SELECT * FROM student_courses WHERE semester = "Summer 2025" LIMIT 5');
    $studentCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($studentCourses) > 0) {
        foreach ($studentCourses as $sc) {
            echo "- Student ID: {$sc['student_id']}, Course ID: {$sc['course_id']}, Semester: {$sc['semester']}\n";
        }
    } else {
        echo "No student courses found for Summer 2025.\n";
    }
    
    // Check tables structure
    echo "\n\nTable Structures:\n";
    
    echo "\nfaculty_course_assignments table:\n";
    $stmt = $pdo->query('DESCRIBE faculty_course_assignments');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']} ({$row['Type']})\n";
    }
    
    echo "\nstudent_courses table:\n";
    $stmt = $pdo->query('DESCRIBE student_courses');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']} ({$row['Type']})\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
