<!DOCTYPE html>

<html lang="en">
<head>
    <title>Add personal details and goals:</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      <!-- for device adaptation -->
    <!-- Link your CSS file here -->
    <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="register-container">        <!-- for css MUDAR DPS -->
    <h2>Add your formation:</h2>
    <form class="register-form" action="action_common_user.php" method="post">

        <div class="form-group">
            <label>Height (m):
                <input type="n" id="height" name="height" value="1.60" min="0" max="3" step="0.05" required>      
            </label>
        </div>

        <div class="form-group">
            <label>Current Weight (kg):
                <input type="n" id="current_weight" name="current_weight" value="60" min="0" max="600" step="1" required>        
            </label>
        </div>

        <div class="form-group">
            <label>Ideal Weight (kg):
                <input type="n" id="ideal_weight" name="ideal_weight" value="60" min="0" max="600" step="1" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Primary Health Goal:
               <select name="health_goal">
                <option value="overall_health">Overall Health</option>
                <option value="weight_loss">Weight Loss</option>
                <option value="boosted_immunity">Boosted Immunity</option>
                <option value="stress_reduction">Stress Reduction</option>
                <option value="improved_sleep">Improved Sleep</option>
                <option value="digestive_health">Digestive Health</option>
                </select>
            </label>
        </div>

        <button type="submit">Save</button>
    </form>
</div>

</body>
</html>