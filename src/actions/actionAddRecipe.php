<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted
    
    // Retrieve form data
    $name = $_POST['name'];
    $preparationTime = $_POST['preparationTime'];
    $difficulty = $_POST['difficulty'];
    $numberOfServings = $_POST['numberOfServings'];
    $preparationMethod = $_POST['preparationMethod'];

    
    
    // Handle the file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'path/to/upload/directory/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
            // File was successfully uploaded
        } else {
            // Handle file upload error
        }
    }

    // Perform database insert or any other necessary actions
    // Insert the form data into your database or perform other processing
    
    // Redirect to a success page or handle the response accordingly
    header('Location: success.php');
    exit;
}

