<?php
// Add new plan to database with user id
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

session_start();
$user_id=$_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {     # block will only be executed when the form is submitted using the POST method -> for security
    // retrieve person data
    $person = Person::getPersonById($user_id);
    
    $firstName = $_POST["firstName"];
    if (empty($firstName)){  
        $firstName=$person->first_name;
    }
    $surname = $_POST["surname"];
    if (empty($surname)){  
        $surname=$person->surname;
    }

    // Get image and upload it to the server
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../img/users/'; 
        // Get the file extension
        $extension = pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . $user_id . '.' . $extension;
        
        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $uploadFile)) {
            // File was successfully uploaded
            $profile_photo = $uploadFile;
        } else {
            // Handle file upload error
            $profile_photo = '../img/users/profile.png';
        }
    } else {
        // Handle file upload error by using a default image
        $profile_photo = '../img/users/profile.png';

    }
    Person::changePersonInfo($firstName,$surname,$profile_photo,$user_id);


    //Check user type and get for each
    if (Person::isCommonUser($user_id)){
        $commonUser= CommonUser::getCommonUserById($user_id);

        $height = $_POST["height"];
        if (empty($height)){  
            $height=$commonUser->height;
        }
        $currentWeight = $_POST["curr_weight"];
        if (empty($currentWeight)){  
            $currentWeight=$commonUser->current_weight;
        }
        $idealWeight = $_POST["ideal_weight"];
        if (empty($idealWeight)){  
            $idealWeight=$commonUser->ideal_weight;
        }
        //change the updated information in the database
        CommonUser::changeUserInfo($user_id,$height,$currentWeight,$idealWeight);

    }elseif(Person::isChef($user_id)){
        $values= Chef::getChefFormation($user_id);
        
        $course_name = $_POST["course_name"];
        if (empty($course_name)){  
            $course_name=$values[1];
        }
        $school_name = $_POST["school_name"];
        if (empty($school_name)){  
            $school_name=$values[2];
        }
        $academic_level=$_POST["academic_level"];
        if (empty($academic_level)){  
            $academic_level=$values[3];
        }
        $graduation_date=$_POST["graduation_date"];
        if (empty($graduation_date)){  
            $graduation_date=$values[0];
        }
        //change the updated information in the database
        Chef::changeChefInfo($user_id,$course_name,$school_name,$academic_level,$graduation_date);

    }elseif(Person::isNutritionist($user_id)){
        $values= Nutritionist::getNutriFormation($user_id);
        
        $course_name = $_POST["course_name"];
        if (empty($course_name)){  
            $course_name=$values[1];
        }
        $school_name = $_POST["school_name"];
        if (empty($school_name)){  
            $school_name=$values[2];
        }
        $academic_level=$_POST["academic_level"];
        if (empty($academic_level)){  
            $academic_level=$values[3];
        }
        $graduation_date=$_POST["graduation_date"];
        if (empty($graduation_date)){  
            $graduation_date=$values[0];
        }
        //change the updated information in the database
        Nutritionist::changeNutriInfo($user_id,$course_name,$school_name,$academic_level,$graduation_date);
    }
    header("Location: ../pages/profile.php");
}




?>