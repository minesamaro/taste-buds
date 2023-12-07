<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="icon" href="../img/favicon.icon">
        <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
        <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    </head>
    <body>
        <header>
            <div class="header__logo">
                <a href="../" id="title">Taste Buds</a>
            </div>
            <div class="header__nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
            <div id="login-signup">
            <a href="#login">Log in</a>
            <!-- <a href="#logout">Log out</a> -->
            <a href="#signin">Sign in</a>
            </div>
        </header>
        <section id="profile">
            <h1><a href="#">My profile</a></h1>
            <form>
                <label>
                    Username <input type="text" name="username">
                </label>
                <label>
                    Name <input type="text" name="name">
                </label>
                <label>
                    Surname <input type="text" name="surname">
                </label>
                <label>
                    Mail <input type="text" name="mail">
                </label>
                <label>
                    Birth date <input type="text" name="birthdate">
                </label>
                <label>
                    Gender <input type="text" name="gender">
                </label>
                <label>
                    Course name <input type="text" name="coursename">
                </label>
                <label>
                    School name <input type="text" name="schoolname">
                </label>
                <label>
                    Academic level <input type="text" name="academiclevel">
                </label>
                <label>
                    Graduation date <input type="text" name="graduationdate">
                </label>
                <input type="submit" value="Change Profile">
                
            </form>

        </section>
        <section id="img">
            <img src="profile.png" alt="">
            <a href="#changePassword">Change Password</a>


        </section>


    </body>

</html>