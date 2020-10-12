<?php
    require_once("./includes/session.php");
    require_once("includes/loader.php");
    require_once("./includes/connection.php");
    require_once("./includes/header.php");
    require_once("./includes/nav.php");
?>
    <div class = "about">
        <div class = "about_box_1">
            <div class = "img">
                <img src = "./public/Rajarshi_Saha.jpg" alt = "error"/>
            </div>
            <div class ="info">
                <h4><b>Name:</b> <span>Rajarshi Saha</span></h4>
                <h4><b>Current Role:</b> <span>Student (B.Tech)</span></h4>
                <h4><b>Place:</b> <span>Kolkata</span></h4>
            </div>
        </div>
        <div class = "about_box_2">
            <h1>About Me</h1>
            <p>
                My name is Rajarshi Saha. I'am your Developer.
                This site has been made using <b>PHP</b> using the <b>MVC</b> model and <b>MYSQL</b> for the database.
                The styling of the front end has been done in pure <b>CSS</b> by me in house without the use of any frameworks like
                Bootstrap.
                I'am a B.Tech Student living in Kolkata and an aspriring Web Developer.
                Currently i know the
                <br>
                <b>MERN stack (NODE JS, EXPRESS, REACT and MONGODB)</b>,
                <br> 
                prodedural <b>PHP</b> with <b>MYSQL</b> and is hoping to expand my knowledge 
                by learning <b>OOP PHP</b> so as to implement the <b>MVC</b> Model.
                Hope you had a good experience using this site.
            </p>
        </div>
    </div>
<?php
    require_once("./includes/footer.php");
?>