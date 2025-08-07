<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=student_hub', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== Current Semester Information ===\n\n";
    
    // Check semesters data
    echo "All Semesters:\n";
    $stmt = $pdo->query('SELECT * FROM semesters ORDER BY start_date DESC');
    $semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($semesters as $semester) {
        $current = $semester['is_current'] ? ' (CURRENT)' : '';
        echo "- ID: {$semester['id']}, Name: {$semester['name']}, Code: {$semester['code']}{$current}\n";
        echo "  Start: {$semester['start_date']}, End: {$semester['end_date']}\n";
    }
    
    // Check current faculty assignments  
    echo "\n\nCurrent Faculty Course Assignments:\n";
    $stmt = $pdo->query('SELECT fca.*, u.name as faculty_name, c.course_code, c.course_name 
                         FROM faculty_course_assignments fca 
                         JOIN users u ON fca.faculty_id = u.id 
                         JOIN courses c ON fca.course_id = c.id 
                         ORDER BY fca.created_at DESC');
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($assignments) > 0) {
        foreach ($assignments as $assignment) {
            echo "- {$assignment['faculty_name']} assigned to {$assignment['course_code']}: {$assignment['course_name']}\n";
            echo "  Semester: {$assignment['semester']}, Year: {$assignment['academic_year']}, Type: {$assignment['semester_type']}\n";
        }
    } else {
        echo "No faculty assignments found.\n";
    }
    
    // Check student course enrollments
    echo "\n\nStudent Course Enrollments:\n";
    $stmt = $pdo->query('SELECT sc.*, u.name as student_name, c.course_code, c.course_name 
                         FROM student_courses sc 
                         JOIN users u ON sc.user_id = u.id 
                         JOIN courses c ON sc.course_id = c.id 
                         LIMIT 10');
    $studentCourses = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($studentCourses) > 0) {
        foreach ($studentCourses as $sc) {
            echo "- {$sc['student_name']} enrolled in {$sc['course_code']}: {$sc['course_name']}\n";
            echo "  Status: {$sc['status']}, Semester: {$sc['semester_taken']}, Year: {$sc['year_taken']}\n";
        }
    } else {
        echo "No student enrollments found.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

?>
