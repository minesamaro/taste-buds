<!DOCTYPE html>

<html lang="en">
<head>
    <title>Add your formation</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      <!-- for device adaptation -->
    <!-- Link your CSS file here -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="register-container">        <!-- for css MUDAR DPS -->
    <h2>Add your formation:</h2>
    <form class="register-form" action="action_formation.php" method="post">

        <div class="form-group">
            <label>Course Name:
                <input type="text" id="course_name" name="course_name" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>School Name:
                <input type="text" id="school_name" name="school_name" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <button type="submit">Add Formation</button>
    </form>
</div>

</body>
</html>