<?php 
require_once(__DIR__ . '/../database/person.class.php');

function Profile(){ ?>
    <section id="profile">
            <h1><a href="#">My profile</a></h1>
            <div>
                <p>Username</p>
                <p>andreiaaaa</p>
                <p>Name</p>
                <p>Andreia</p>
                <p>Surname</p>
                <p>Silva</p>
                <p>mail</p>
                <p>andreia@gmail.com</p>
                <p>Birth date</p>
                <p>10/07/2000</p>
                <p>gender</p>
                <p>female</p>
                <p>height</p>
                <p>1.65</p>
                <p>weight</p>
                <p>78</p>
                <p>ideal weight</p>
                <p>70</p>
            </div>

        </section>
        <section id="img">
            <img src="profile.png" alt="">
            <a href="#changePassword">Change Password</a>
        </section>
<?php
}
?>