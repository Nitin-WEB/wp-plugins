<?php
/* Template Name: Feedback form */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Title Tag -->
    <title>User Feedback</title>
    <script> var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';</script>
    <style>
        @font-face {
            font-family: Arial, sans-serif;
            src: url(Arial.ttf);
        }

        :root {
            --primary-color: #0A3A59;
            --secondary-color: #11BCEF;
            --secondary-hover-color: #0EA0CB;
            --tertiary-color: #D87103;
            --lite-color: #BFCAD7;
            --outline-color: rgba(255,255,255,0.3);
            --outline-hover-color: rgba(255,255,255,0.75);
            --dark-color: #000011;
            --black-color: #000000;
            --grey-color: #E6EBEE;
            --white-color: #ffffff;
            --font-family-primary: Arial, sans-serif;
            --font-size-body:16px;
            --font-size-mobile:14px;
        }

        ::placeholder{
            color: var(--outline-color) !important;
        }

        body, header, nav{
            background: var(--primary-color);
        }

        .help_button, .main_heading, .card_button, .text_field, .input_title{
            font-family: var(--font-family-primary);
        }


        /* Navbar Starts Here */

        .main_Nav{
            height: 88px;
            padding: 16px 120px;
        }

        .p4c_logo{
            height: 44px;
        }

        .help_button{
            padding: 4px 16px;
            border-radius: 8px;
            border: 1px solid var(--outline-color);
            color: var(--white-color);
            background: none;
            font-weight: 600;
            font-size: 14px;
            line-height: 24px;
            letter-spacing: 1px;
            text-decoration: none;
        }

        .help_button:hover{
            border: 1px solid var(--outline-hover-color); 
            color: var(--white-color);
            text-decoration: none;
        }

        /* Navbar End Here */

        /* Header Starts Here */

        .header_box{
            display: flex;
            align-items: center;
            justify-content: center;
            background: url(<?php echo THEME_URL; ?>/assets/consumerFeedbackImgs/Background.png);
            background-size: cover;
            background-repeat: no-repeat;
            padding: 0px !important;
            min-height: calc(100vh - 88px);
        }

        .success_icon{
            height: 76px;
        }

        .main_heading{
            font-size: 28px;
            text-align: center;
            font-weight: 600;
            margin-bottom: 0;
            letter-spacing: 1px;
        }

        .rating_card{
            background: var(--primary-color) !important;
            color: var(--white-color);
            max-width: 520px;
            padding: 32px 24px 24px;
            gap: 24px;
            border-radius: 16px !important;
            align-items: center;
            display: none;
        }

        .card_button{
            height: 40px;
            border-radius: 8px;
            background: var(--secondary-color);
            color: var(--white-color);
            border: 0px;
            font-weight: 600;
            font-size: var(--font-size-body);
            letter-spacing: 1px;
        }

        .card_button:hover{
        background: var(--secondary-hover-color);
        }

        hr{
            margin: 0 !important;
            width: 360px;
            border: 1px;
        }

        .row_b{
            margin: 0px !important;
            gap: 24px; 
        }

        .row{
            --bs-gutter-x: none !important;
        }

        .text_field {
            padding: 8px 16px !important;
            color: var(--white-color) !important;
            background-color: var(--primary-color) !important;
            border: 1px solid var(--outline-color) !important;
            border-radius: .5rem !important;
        }

        .stars_col{
            gap: 12px;
            display: flex;
        }

        .row_a{
            gap: 16px;
            display: flex;
        }

        .input_title{
            font-weight: 700;
            font-size: var(--font-size-body);
            letter-spacing: .5px;
        }

        /* Header End Here */


        /* Mobile Responsive Starts Here */

        @media (max-width: 600px) {

            .main_Nav{
                height: 72px;
                padding: 16px;
            }

            .p4c_logo{
                height: 32px;
            }

            .header_box{
                padding: 16px !important;
                    min-height: calc(100vh - 72px);
            }

            hr{
                width: 200px;
                border: 1px;
            }

            .rating_stars{
                height: 32px;
            }

            .main_heading{
                font-size: 21px;
                line-height: 28px;
            }

            .rating_card{
                padding: 24px 16px 16px;
                gap: 16px;
            }

            .input_title{
                font-size: var(--font-size-mobile);
            }

            .row_a{
                gap: 8px;
            }

            .stars_col{
                gap: 8px;
            }

            ::placeholder{
                font-size: var(--font-size-mobile);
            }

            .row_b{
                gap: 16px; 
            }

            .container-fluid{
                padding: 0px !important;
            }

            .col-3{
                width: 30% !important; 
            }

            .text_field {
                padding: 6px 12px !important;
            }
        
        }

        /* Mobile Responsive End Here */
    </style>
</head>
<body>

    <!-- Navbar Start -->
<nav class="navbar navbar-expand-lg main_Nav">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img class="p4c_logo" src="<?php echo THEME_URL; ?>/assets/consumerFeedbackImgs/P4c_logo.svg" alt="Privacy4cars Logo"></a>
        <a href="<?php echo home_url('/contact-us'); ?>" class="help_button">Help
        </a>
        </div>
</nav>
<!-- Navbar end -->

<!-- Header Start -->
<header>
    <div class="header_box">
        <div class="card rating_card">
            <div class="row row_a">
                <img class="success_icon" src="<?php echo THEME_URL; ?>/assets/consumerFeedbackImgs/success_icon.svg" alt="Success Icon">
                <h1 class="main_heading">Thank you for your participation and we look forward to your valuable input!</h1>
            </div>
            <hr />
            <form class="form-horizontal" id="ratingForm" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="submit_user_feedback">
                <input type="hidden" name="postID" id="postID">
                <input type="hidden" name="rating" id="rating">
                <div class="row row_b">
                    <div class="row">
                        <div class="col-3 input_title">Rating:</div>                        
                        <div class="col stars_col">
                            <?php
                            // Get the rating value from the URL parameter
                            $rating = isset($_GET['r']) ? intval($_GET['r']) : 0;
                            
                            // Loop through 5 stars and display them
                            for ($i = 1; $i <= 5; $i++) {
                                // Determine whether to display a filled or unfilled star based on the rating
                                $star_src = ($i <= $rating) ? 'Star filled.svg' : 'Star unfill.svg';
                                // Output the image tag for the star
                                echo '<img class="rating_stars" src="' . THEME_URL . '/assets/consumerFeedbackImgs/' . $star_src . '" alt="Rating Star">';
                            }


                            
                            ?>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-3 input_title">Comment:</div>
                        <div class="col">
                            <div class="input-group">
                            <textarea maxlength="1000" class="form-control text_field" id="comments" name="comments" aria-label="With textarea" placeholder="Optional Feedback"></textarea>
                        </div>
                        <small id="charCount">0 / 1000</small>
                    </div>
                    </div>
                    <button type="submit" class="card_button" id="comments_form_button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</header>
<!-- Header End -->

 <!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

            isFormValid();

            var urlParams = new URLSearchParams(window.location.search);
            var postID = urlParams.get('id');
            var rating = urlParams.get('r');
            
            // Set values of hidden fields
            document.getElementById('postID').value = postID;
            document.getElementById('rating').value = rating;

            if (rating && postID) {
                // AJAX request to save rating to post meta
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'save_rating_to_post_meta',
                        post_id: postID,
                        rating: rating,
                        security: '<?php echo wp_create_nonce( "save_rating_nonce" ); ?>'
                    },
                    success: function(response) {
                        if(response.data==='rated'){
                            console.log("You have already rated!");
                            $("#ratingForm").hide();
                            $("hr").hide();
                            $(".main_heading").text("You have already rated!");
                        }
                        if(response.data==='rating_saved'){
                            console.log("Rating Saved successfully!");
                        }
                        document.querySelector(".rating_card").style.display = 'flex';
                        //$(".rating_card").show();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving rating: ' + error);
                    }
                });
            }
    });
    function isFormValid(){
        var textarea = document.getElementById("comments");
        var charCount = document.getElementById("charCount");
        var form = document.getElementById("ratingForm");

        textarea.addEventListener("input", function() {
            var length = textarea.value.length;
            charCount.textContent = length + " / 1000";

            if (length > 1000) {
                textarea.value = textarea.value.substring(0, 1000);
                charCount.textContent = "1000 / 1000";
            }
        });

        form.addEventListener("submit", function(event) {
            if (textarea.value.length > 1000) {
                event.preventDefault();
                alert("Comment cannot exceed 1000 characters.");
            }
        });
    }
</script>
</body>
</html>
