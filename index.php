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
     <div class="wrapper">
        <a class="search" href="search/search.php">
            <div>Search</div>
        </a>
        <div id="middle">
            <div class="headline">
                <div class="contents">
                    <h1>Mixit</h1>
                    <p>Take what you have and make the perfect drink</p>
                </div>
            </div>
            <div class="signIn">
                <a href="login/login.php">
                    <div class="box">
                        Login
                    </div>
                </a>
                <a href="register/register.php">
                    <div class="box">
                        Register
                    </div>
                </a>
            </div>
            <div class="more">
                <a href="#about">Learn More</a>
            </div>
        </div>
    </div>
    <div id="about">
        <div class="whatWhy">
            <div class="what">
                <h2>What is this site?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cupiditate dolores at eius architecto est quasi animi cum. Quaerat ipsam alias sunt quia. Sint, aspernatur repellendus sunt minus facilis! Ut, eligendi!</p>
            </div>
            <div class="why">
                <h2>Why use this site?</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa suscipit eligendi inventore? Magnam ipsum eveniet velit delectus iusto voluptate provident, animi! Atque error assumenda blanditiis quidem dolore rerum quibusdam vel!</p>
            </div>
        </div>
        <h2 class="policiesHeader">Specific Policies</h2>
        <div class="policies">
            <div class="policyBox">
                <h2>About Us</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A quos consequatur libero, eveniet, nemo magnam asperiores doloribus earum porro tenetur ea quod amet. Fugiat vero totam, earum dolorem voluptatem. Et!</p>
            </div>
            <div class="policyBox">
                <h2>Registration</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum minima ab recusandae dolores inventore tempore maxime esse, est architecto porro nesciunt excepturi repellat voluptate. Rem odit quo, labore soluta ea.</p>
            </div>
            <div class="policyBox">
                <h2>Age Policy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias tenetur numquam corrupti voluptatem nam enim rerum nisi delectus eveniet, recusandae repudiandae, obcaecati reiciendis est error. Facilis totam minima, sapiente accusantium!</p>
            </div>
            <div class="policyBox">
                <h2>Cookie Policy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit fugiat totam id rerum fugit natus excepturi, repudiandae eius, libero aperiam? Blanditiis exercitationem tempora eos nemo facilis voluptatibus delectus quia sit.</p>
            </div>
            <div class="policyBox">
                <h2>Disclaimer</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nemo praesentium ipsa vel blanditiis veritatis, illum, debitis incidunt rerum quaerat tenetur! Similique consequatur voluptate ipsam ab quis nesciunt mollitia voluptatum corporis.</p>
            </div>
            <div class="policyBox">
                <h2>Privacy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint tempore, odit laborum at, natus similique quaerat beatae voluptate cumque voluptatum in nihil, ad quod esse velit exercitationem veritatis tempora perferendis!</p>
            </div>
            <div class="policyBox">
                <h2>Drink Database</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur soluta animi aspernatur amet cupiditate impedit suscipit maxime sint non dignissimos. Iste fuga aperiam culpa dolore eum error optio adipisci iusto.</p>
            </div>
            <div class="policyBox">
                <h2>Email Policy</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet laboriosam, assumenda provident. Commodi qui tempora maxime necessitatibus error odit libero nulla fugit obcaecati repudiandae. Fuga, architecto pariatur accusantium praesentium perferendis?</p>
            </div>
        </div>
    </div>
</body>

</html>