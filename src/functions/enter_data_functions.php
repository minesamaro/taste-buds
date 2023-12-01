<?php


# MEMBER REGISTRATION ------------------------------------------------------------------------------------------------
# send inputs to database
function insertAccount($username, $first_name, $surname, $email, $password, $birth_date, $gender, $occupation) {    

    # try...catch for handling errors
    try {

        #start transaction to the database
        global $db;
        $db->beginTransaction();

        # insert Person - using post variables from forms (note that the id is automatically set with autoincremental)
        $stmt = $db->prepare('INSERT INTO Person (username,first_name,surname,email,password,birth_date,gender) VALUES (?,?,?,?,?,?,?)');
        $stmt->execute(array($username, $first_name, $surname, $email, hash('sha256', $password), $birth_date, $gender));

        # get the new member id (the last person inserted in current session)
        $personId = $db->lastInsertId();

        # insert occupation selected to corresponding class (chef, nutritionist or common user)
        switch ($occupation) {
           case 'chef':
                $stmtChef = $db->prepare('INSERT INTO Chef (chef_id) VALUES (?)');
                $stmtChef->execute(array($personId));
                break;
            case 'nutritionist':
                $stmtNutritionist = $db->prepare('INSERT INTO Nutritionist (id) VALUES (?)');
                $stmtNutritionist->execute(array($personId));
            break;
            case 'common_user':
                $stmtCommonUser = $db->prepare('INSERT INTO CommonUser (id) VALUES (?)');
                $stmtCommonUser->execute(array($personId));
                break;
        }

        # permanentely store the changes to the database
        $db->commit();

        $_SESSION['user_id'] = $personId;
        $_SESSION['occupation'] = $occupation;       
               
    # activated if any error happens
    } catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}



# ADD FORMATION -------------------------------------------------------------------------------------------
function addFormation($user_id, $course_name, $school_name, $occupation) {
    global $db;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    try {
        $db->beginTransaction();

        switch ($occupation) {
            case 'chef':
                $stmt = $db->prepare('INSERT INTO ChefFormation (course_name, school_name, chef_id) VALUES (?,?,?)');
                break;
            case 'nutritionist':
                $stmt = $db->prepare('INSERT INTO NutritionistFormation (course_name, school_name, nutritionist_id) VALUES (?,?,?)');
                break;
        }
            
        $stmt->execute(array($course_name, $school_name, $user_id));
    
        $db->commit();
    
    }
  
    catch (Exception $e) {
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
} 
    

# ADD COMMON USER ----------------------------------------------------------------------------------------------
function addCommonUser($id, $height, $currentWeight, $idealWeight) {
    global $db;
    $stmt = $db->prepare('INSERT INTO CommonUser (id, height, current_weight, ideal_weight) VALUES (?, ?, ?, ?)');
    $stmt->execute(array($id, $height, $currentWeight, $idealWeight));
}
 

# ADD HEALTH GOAL ----------------------------------------------------------------------------------------------
function addHealthGoal($id, $health_goal) {
    global $db;
    $stmt = $db->prepare('INSERT INTO UserHealthGoal (user_id, health_goal_name) VALUES (?, ?)');
    $stmt->execute(array($id, $health_goal));    
}

?>