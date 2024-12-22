<?php
function get_assignments_by_course($course_id) {
    global $db;
    if ($course_id) {
        // If course_id is provided, use it in the query
        $query = 'SELECT A.ID, A.Description, C.courseName 
                  FROM assignments A 
                  LEFT JOIN courses C ON A.courseID = C.courseID 
                  WHERE A.courseID = :course_id 
                  ORDER BY A.ID';
        $statement = $db->prepare($query);
        // Bind the course_id only if it is used in the query
        $statement->bindValue(':course_id', $course_id);
    } else {
        // If no course_id is provided, do not use :course_id in the query
        $query = 'SELECT A.ID, A.Description, C.courseName 
                  FROM assignments A 
                  LEFT JOIN courses C ON A.courseID = C.courseID 
                  ORDER BY C.courseID';
        $statement = $db->prepare($query);
    }
    
    // Execute the statement
    $statement->execute();
    
    // Fetch the results
    $assignments = $statement->fetchAll();
    
    // Close the cursor to release the connection to the server
    $statement->closeCursor();
    
    return $assignments;
}


function delete_assignment($assignment_id) {
    global $db;
    $query = 'DELETE FROM assignments WHERE ID = :assign_id';
    $statement = $db -> prepare($query);
    $statement -> bindValue(':assign_id', $assignment_id);
    $statement -> execute();
    $statement -> closeCursor();
}

function add_assignment($course_id, $description) {
    global $db;
    $query = 'INSERT INTO assignments (Description, courseId) VALUES (:descr, :courseID)';
    $statement = $db -> prepare($query);
    $statement -> bindValue(':descr', $description);
    $statement -> bindValue(':courseID', $course_id);
    $statement -> execute();
    $statement -> closeCursor();
}
?>