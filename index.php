<?php
// Start the session
session_start();
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width'>
    <title>Welcome</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,400" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>

<script>
    $(function () {
        $('a[href*="#"]:not([href="#"])').click(function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>

<body>
    <div class="nav">
        <a href="login/login.php">
            <div>Login</div>
        </a>
        <a href="search/search.php">
            <div>Search</div>
        </a>
        <a href="register/register.php">
            <div>Register</div>
        </a>
    </div>
    <div class="imgContainer">
        <div class="tag">
            <h1>Mixit</h1>
            <p>Take what you have and make the perfect drink</p>
            <svg id="draw" viewBox="0 0 100 100">
                <circle cx="50" cy="30" r="6" stroke="white" stroke-width="1" fill="none"></circle>
                <polyline fill="none" stroke="white" stroke-width="2" points="10,10 50,40 50,90 30,96 50,95 70,96 50,90" />
                <polyline fill="none" stroke="white" stroke-width="2" points="90,10 50,40" />
            </svg>
        </div>
    </div>
    <div id="about">
        <div class="whatWhy">
            <div class="what">
                <h2>What is this site?</h2>
                <p>This is a site that contains information on hundreds of mixed drinks and all their ingredients. You can search this database of information for all the drinks you can make with only the ingredients you have with you.</p>
            </div>
            <!--
            <div class="what">
                <h2>Instructions</h2>
                <p>
                    In the haves section, type in the ingredients that you have to make a drink. If there are any ingredients that you know you do not want to have in your drink, include them in the don't want section. If you would like to make your search not exclusive to the ingredients that you listed, check the box. This will make it so that all of the drinks that are returned contain the ingredients you have, but they will have others as well. Search by main ingredients, garnishes will show up in the ingredients lists but are not searchable.
                </p>
            </div>
-->
            <div class="why">
                <h2>Why use this site?</h2>
                <p>There are a few other sites out there on the internet that do what we do, but we have done our best to run this site quickly, beautifully and make everything you need right at your finger tips. Our website is free and advertisement free, and always will be. It also lets you create an account to keep a list of drinks you like, but you can search for whatever you want without having to sign in.</p>
            </div>
        </div>
        <h2 class="policiesHeader">Specific Policies</h2>
        <div class="policies">
            <div class="policyBox">
                <h2>About Us</h2>
                <p>We are two college students named Robert Rosenberger and Connor Christensen. This project was created for a course in databases, but we plan to make this a personal project to keep expanding and supporting.</p>
            </div>
            <div class="policyBox">
                <h2>Registration</h2>
                <p>Feel free to sign up if you want, but it is not required to use our site. If you do decide to sign up, you will receive the benefit of being able to keep track of drinks you like and rate ones you have tried before.</p>
            </div>
            <div class="policyBox">
                <h2>Age Policy</h2>
                <p>Since this site only displays the information for a mixed drink, we make no age restrictions on our site. Everyone is welcome! For those under the legal age of alcohol consumption, we have a range of non-alcoholic drinks and fruit smoothies that you can make.</p>
            </div>
            <div class="policyBox">
                <h2>Cookie Policy</h2>
                <p>Sadly, we aren't talking about those delicious little circles of bread and sugar. If you happen to know what a cookie is in the sense of your web browser, rest assured that we know what they are too and we won't use them. Your data belongs to you and we don't keep any of it.</p>
            </div>
            <div class="policyBox">
                <h2>Disclaimer</h2>
                <p>This site contains information on many alcoholic beverages. This is not meant in any way to endorse the consumption of alcohol for anyone under the legal drinking age in his or her country. We do not require any age verification, but that is not implying that this should be used as a tool for underage drinking.</p>
            </div>
            <div class="policyBox">
                <h2>Privacy</h2>
                <p>Your username, password and email are stored our secure database, and your password is encrypted. Even though we own the database, we do not know what your password is. We do not store any personal information about your computer, there is no tracking programs in our site and the site itself is meant to be as secure as possible.</p>
            </div>
            <div class="policyBox">
                <h2>Drink Database</h2>
                <p>The drink database is consitently being updated with drinks as we continue to develop the site.</p>
            </div>
            <div class="policyBox">
                <h2>Email Policy</h2>
                <p>We keep your email simply as a measure for you to reset your password, should you forget it. We will never send you any emails or try and contact you in any way outside of the site.</p>
            </div>
        </div>
    </div>
</body>

</html>