<?php
/*
Plugin Name: Customer Feedback Email
Description: Adds preview and send email buttons to the customer feedback post type.
Version: 1.0
Author: Nitin Sharma
*/

// Add email preview button
function add_email_preview_button() {
    global $post;
    if ( $post->post_type == 'customer-feedback' ) {
        echo '<a href="#" class="button preview-feedback-email" data-post-id="' . $post->ID . '">Preview Email</a>';
        ?>
        <script>
            jQuery(document).ready(function($){
                $("#major-publishing-actions").hide();
                $('.preview-feedback-email').click(function(e) {
                    e.preventDefault();
                    var post_id = $(this).data('post-id');
                    var customerName = $("#acf-field_663db8f6d69fb").val();
                    if(customerName.length===0){
                        alert("Please add customer information.");
                        return false;
                    }
                    var previewSection = $('#preview-email-section');
                    if (previewSection.length === 0) {
                        var data = {
                            'action': 'preview_feedback_email',
                            'post_id': post_id,
                            'customer_name': customerName,
                            'security': '<?php echo wp_create_nonce( "preview_feedback_email_nonce" ); ?>'
                        };
                        $.post(ajaxurl, data, function(response) {
                            var previewSection = $('<div id="preview-email-section"></div>');
                            previewSection.html(response);
                            $('#wpbody-content').append(previewSection);
                            let divElement = document.getElementById('wpbody-content');
                            divElement.scrollIntoView({ behavior: 'smooth', block: 'end' });
                        });
                    }else{
                        previewSection.show();
                    }                    
                });

                //Disabled or hide rating and comment field
                $('[data-name="cf_user_rating"]').hide();
                $('[data-name="cf_comments"]').hide();


            });
        </script>
        <?php
    }
}
add_action( 'post_submitbox_misc_actions', 'add_email_preview_button' );

// Preview email template
add_action( 'wp_ajax_preview_feedback_email', 'preview_feedback_email_callback' );

function preview_feedback_email_callback() {
    check_ajax_referer( 'preview_feedback_email_nonce', 'security' );
    
    if ( isset( $_POST['post_id'] ) ) {
        //$post_id = intval( $_POST['post_id'] );

        $currentDate = date('m/d/Y');
        $name = $_POST['customer_name'];

        $email_content = '<!doctype html><html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta charset="utf-8"><meta content="width=device-width" name="viewport"><meta content="IE=edge" http-equiv="X-UA-Compatible"><meta name="x-apple-disable-message-reformatting"><meta content="telephone=no,address=no,email=no,date=no,url=no" name="format-detection"><title>Feedback Template</title><link href="https://fonts.googleapis.com/css?family=Inter:400" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Inter:600" rel="stylesheet" type="text/css"><style>html{margin:0!important;padding:0!important}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}td{vertical-align:top;mso-table-lspace:0!important;mso-table-rspace:0!important}a{text-decoration:none}.stars{display:block;background:url(https://storage.googleapis.com/privacy4cars/static/script/images/Star%203.png);width:32px;background-size:cover;height:32px;border:0;vertical-align:middle;align-items:center}.not-rated{display:block;background:url(https://storage.googleapis.com/privacy4cars/static/script/images/Star%203.png);width:32px;background-size:cover;height:32px;border:0;vertical-align:middle;align-items:center}.stars:hover{background:url(https://storage.googleapis.com/privacy4cars/static/script/images/color%20star.png);background-size:cover}.rated{background:url(https://storage.googleapis.com/privacy4cars/static/script/images/color%20star.png);background-size:cover}img{-ms-interpolation-mode:bicubic}@media only screen and (min-device-width:320px) and (max-device-width:374px){u~div .email-container{min-width:320px!important}}@media only screen and (min-device-width:375px) and (max-device-width:413px){u~div .email-container{min-width:375px!important}}@media only screen and (min-device-width:414px){u~div .email-container{min-width:414px!important}}</style><style>@media only screen and (max-device-width:599px),only screen and (max-width:599px){.eh{height:auto!important}.desktop{display:none!important;height:0!important;margin:0!important;max-height:0!important;overflow:hidden!important;padding:0!important;visibility:hidden!important;width:0!important}.mobile{display:block!important;width:auto!important;height:auto!important;float:none!important}.email-container{width:100%!important;margin:auto!important}.stack-column,.stack-column-center{display:block!important;width:100%!important;max-width:100%!important;direction:ltr!important}.wid-auto{width:auto!important}.table-w-full-mobile{width:100%}.mobile-center{text-align:center}.mobile-center>table{display:inline-block;vertical-align:inherit}.mobile-left{text-align:left}.mobile-left>table{display:inline-block;vertical-align:inherit}.mobile-right{text-align:right}.mobile-right>table{display:inline-block;vertical-align:inherit}}</style></head>';
        $email_content .= '<body width="100%" style="background-color:#e6ebee;margin:0;padding:0!important;mso-line-height-rule:exactly"><div style="background-color:#e6ebee"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" align="center"><table bgcolor="#ffffff" style="margin:0 auto" align="center" id="brick_container" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container"><tr><td width="600"><table cellspacing="0" cellpadding="0" border="0"><tr><td width="600" style="background-color:#fff" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" style="vertical-align:middle;background-color:#0a3a59;padding-left:24px;padding-right:24px" bgcolor="#0a3a59"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="vertical-align:middle" width="205"><img src="https://storage.googleapis.com/privacy4cars/static/script/images/Logoemailp4c.png" width="205" border="0" style="max-width:205px;width:100%;height:auto;display:block"></td><td> </td><td style="vertical-align:middle"><div style="line-height:24px;text-align:right"><span style="color:#667085;font-family:Inter,Arial,sans-serif;font-size:14px;line-height:24px;text-align:right">'.$currentDate.'</span></div></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" align="center" style="vertical-align:middle;background-color:#fff;padding-left:24px;padding-right:24px" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="vertical-align:middle" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" align="center" style="vertical-align:middle"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:middle" align="center"><div style="line-height:15px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:15px;text-align:left">Dear '.$name.',</span></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td style="vertical-align:middle" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><div style="line-height:20px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:20px;text-align:left">When you reach out to our Customer Support Team for assistance, it is our goal to offer you the experience you expect from Privacy4Cars.</span></div></td></tr></table></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td width="100%" align="center" class="TNffW8FkcQIUIB1JPxfleHM1TiY9CI invert-bg" style="background-repeat:no-repeat!important;background-position:center center!important;background-size:cover!important;border-radius:8px;border-collapse:separate!important;padding-left:16px;padding-right:16px" background="https://plugin.markaimg.com/public/9f0a083a/TNffW8FkcQIUIB1JPxfleHM1TiY9CI.png"><div><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td align="center"><div style="line-height:22px;text-align:center"><span style="color:#0a3a59;font-weight:700;font-family:Arial,Arial,sans-serif;font-size:18px;line-height:22px;text-align:center">How satisfied were you with the assistance you received from our Customer Support team?</span></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr><td align="center" style="vertical-align:middle"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td class="stars" style="vertical-align:middle" width="32" align="center"></td><td style="width:8px;min-width:8px" width="8"></td><td class="stars" style="vertical-align:middle" width="32" align="center"></td><td style="width:8px;min-width:8px" width="8"></td><td class="stars" style="vertical-align:middle" width="32" align="center"></td><td style="width:8px;min-width:8px" width="8"></td><td class="stars" style="vertical-align:middle" width="32" align="center"></td><td style="width:8px;min-width:8px" width="8"></td><td class="stars" style="vertical-align:middle" width="32" align="center"></td></tr></table></td></tr></table></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr></table></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td><div style="line-height:20px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:20px;text-align:left">Thank you in advance for your participation and we look forward to your valuable input!</span></div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" style="vertical-align:middle;background-color:#0a3a59;padding-left:24px;padding-right:24px" bgcolor="#0a3a59"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="height:24px" width="444"><div style="line-height:24px;text-align:left"><span style="color:#fff;font-weight:600;font-family:Inter,Arial,sans-serif;font-size:14px;line-height:24px;text-align:left">'.home_url().'</span></div></td><td> </td><td style="vertical-align:middle" width="64"><table cellspacing="0" cellpadding="0" border="0"><tr><td width="64"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="24"><a href="https://www.linkedin.com/company/privacy4cars"><img src="https://storage.googleapis.com/privacy4cars/static/script/images/linkedin%20icon.png" width="24" border="0" style="min-width:24px;width:24px;height:auto;display:block"></a></td><td style="width:16px;min-width:16px" width="16"></td><td width="24"><a href="https://www.youtube.com/@privacy4cars347"><img src="https://storage.googleapis.com/privacy4cars/static/script/images/youtube%20icon.png" width="24" border="0" style="min-width:24px;width:24px;height:auto;display:block"></a></td></tr></table></td></tr></table></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div>';
        $email_content .= '</body></html>';
   
        echo $email_content;

    }
    wp_die();
}


// Add "Send Email" button
function add_send_email_button() {
    global $post;
    if ( $post->post_type == 'customer-feedback' ) {

        if ( 'publish' == $post->post_status ) {
            $visibility = 'public';
            $visibility_trans = __('Public');
        } elseif ( !empty( $post->post_password ) ) {
            $visibility = 'password';
            $visibility_trans = __('Password protected');
        } elseif ( $post->post_type == 'customer-feedback' && is_sticky( $post->ID ) ) {
            $visibility = 'public';
            $visibility_trans = __('Public, Sticky');
        } else {
            $post->post_password = '';
            $visibility = 'private';
            $visibility_trans = __('Private');
        } 



        echo '<a href="#" class="button send-feedback-email" data-post-id="' . $post->ID . '">Send Email</a>';
        ?>
        <script type="text/javascript">
            (function($){
                try {
                    $('#post-visibility-display').text('<?php echo $visibility_trans; ?>');
                    $('#hidden-post-visibility').val('<?php echo $visibility; ?>');
                    $('#visibility-radio-<?php echo $visibility; ?>').attr('checked', true);
                    //Adding post ID as title name
                    $("#title-prompt-text").addClass('screen-reader-text');
                    $("#title-prompt-text").text('Case- #<?php echo $post->ID; ?>');
                    $("#title").val('Case- #<?php echo $post->ID; ?>');
                    $("#minor-publishing-actions").hide();
                    
                } catch(err){}
            }) (jQuery);
        </script>

        <script>
            // JavaScript to handle sending email clicks
                jQuery(document).ready(function($) {
                    $('.send-feedback-email').click(function(e) {
                        e.preventDefault();
                        var post_id = $(this).data('post-id');
                        var customerName = $("#acf-field_663db8f6d69fb").val();
                        var customerEmail = $("#acf-field_663db97ea6d2f").val();
                        if(customerName.length===0 || customerEmail.length===0){
                            alert("Please add customer information.");
                            return false;
                        }
                        var data = {
                            'action': 'send_feedback_email',
                            'post_id': post_id,
                            'customer_name': customerName,
                            'customer_email': customerEmail,
                            'security': '<?php echo wp_create_nonce( "send_feedback_email_nonce" ); ?>'
                        };
                        $.post(ajaxurl, data, function(response) {
                            //trigger the publish button
                            $("#publish").trigger("click");
                            alert(response);
                        });
                    });
                });
        </script>
        <?php
    }
}
add_action( 'post_submitbox_misc_actions', 'add_send_email_button' );

// Send email function
add_action( 'wp_ajax_send_feedback_email', 'send_feedback_email_callback' );

function send_feedback_email_callback() {
    check_ajax_referer( 'send_feedback_email_nonce', 'security' );

    if ( isset( $_POST['post_id'] ) ) {
        $post_id = intval( $_POST['post_id'] );

        $currentDate = date('m/d/Y');
        $name = $_POST['customer_name'];
        $email = $_POST['customer_email'];

        $to = $email;
        $subject = 'Please spare a few seconds to rate your experience with Privacy4Cars support';
        //Encode the URL
        $ratingHTML = '';
        $token = wp_generate_password(32, false); // Generate a random token
        $num_stars = 5;
        $baseURL = home_url() . '/user-feedback?id=' . $post_id;
        // Loop to generate star rating links
        for ($i = $num_stars; $i >= 1; $i--) { 
            $encodedURL = $baseURL . '&r=' . $i . '&t='. $token;
            //$ratingHTML .= '<td width="32" height="32" class="stars" title="'.$i.'star"><a title="'.$i.'star" href="' . $encodedURL . '">&#9733;</a></td>';
            $ratingHTML .= '<td width="32" height="32" class="stars" title="'.$i.'star"><a title="'.$i.'star" href="' . $encodedURL . '">'.$i.'</a></td>';
            // Add spacer column except for the last star
            if ($i <= $num_stars) {
                $ratingHTML .= '<td style="width:8px;min-width:8px" width="8"></td>';
            }
        }

        // Additional processing if needed
        $email_content = '<!DOCTYPE html><html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office"><head><meta charset="utf-8"><meta content="width=device-width" name="viewport"><meta content="IE=edge" http-equiv="X-UA-Compatible"><meta name="x-apple-disable-message-reformatting"><meta content="telephone=no,address=no,email=no,date=no,url=no" name="format-detection"><title>Feedback Template</title><link href="https://fonts.googleapis.com/css?family=Inter:400" rel="stylesheet" type="text/css"><link href="https://fonts.googleapis.com/css?family=Inter:600" rel="stylesheet" type="text/css"><style>html{margin:0!important;padding:0!important}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}td{vertical-align:top;mso-table-lspace:0!important;mso-table-rspace:0!important}a{text-decoration:none}.stars-rating{display:flex;direction:rtl;align-content:center;flex-wrap:wrap;justify-content:center;align-items:center;gap:8px}.stars{display:block;background:url(https://storage.googleapis.com/privacy4cars/static/script/images/Star%203.png);width:32px;background-size:cover;height:32px;border:0;vertical-align:middle;align-items:center}.stars:hover,.stars:hover~.stars{background:url(https://storage.googleapis.com/privacy4cars/static/script/images/color%20star.png);background-size:cover}.stars a{min-width:32px;min-height:32px;display:block;text-align: center;line-height: 36px;vertical-align: middle;color: #11bcef;}img{-ms-interpolation-mode:bicubic}@media only screen and (min-device-width:320px) and (max-device-width:374px){u~div .email-container{min-width:320px!important}}@media only screen and (min-device-width:375px) and (max-device-width:413px){u~div .email-container{min-width:375px!important}}@media only screen and (min-device-width:414px){u~div .email-container{min-width:414px!important}}</style><style>@media only screen and (max-device-width:599px),only screen and (max-width:599px){.eh{height:auto!important}.desktop{display:none!important;height:0!important;margin:0!important;max-height:0!important;overflow:hidden!important;padding:0!important;visibility:hidden!important;width:0!important}.mobile{display:block!important;width:auto!important;height:auto!important;float:none!important}.email-container{width:100%!important;margin:auto!important}.stack-column,.stack-column-center{display:block!important;width:100%!important;max-width:100%!important;direction:ltr!important}.wid-auto{width:auto!important}.table-w-full-mobile{width:100%}.mobile-center{text-align:center}.mobile-center>table{display:inline-block;vertical-align:inherit}.mobile-left{text-align:left}.mobile-left>table{display:inline-block;vertical-align:inherit}.mobile-right{text-align:right}.mobile-right>table{display:inline-block;vertical-align:inherit}}</style></head>';
        $email_content .= '<body width="100%" style="background-color:#e6ebee;margin:0;padding:0!important;mso-line-height-rule:exactly"><div style="background-color:#e6ebee"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" align="center"><table bgcolor="#ffffff" style="margin:0 auto" align="center" id="brick_container" cellspacing="0" cellpadding="0" border="0" width="600" class="email-container"><tr><td width="600"><table cellspacing="0" cellpadding="0" border="0"><tr><td width="600" style="background-color:#fff" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" style="vertical-align:middle;background-color:#0a3a59;padding-left:24px;padding-right:24px" bgcolor="#0a3a59"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="vertical-align:middle" width="205"><img alt="Privacy4Cars" src="https://storage.googleapis.com/privacy4cars/static/script/images/Logoemailp4c.png" width="205" border="0" style="max-width:205px;width:100%;height:auto;display:block"></td><td> </td><td style="vertical-align:middle"><div style="line-height:24px;text-align:right"><span style="color:#667085;font-family:Inter,Arial,sans-serif;font-size:14px;line-height:24px;text-align:right">'.$currentDate.'</span></div></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" align="center" style="vertical-align:middle;background-color:#fff;padding-left:24px;padding-right:24px" bgcolor="#ffffff"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="vertical-align:middle" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" align="center" style="vertical-align:middle"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td style="vertical-align:middle" align="center"><div style="line-height:15px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:15px;text-align:left">Dear '.$name.',</span></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td style="vertical-align:middle" width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="100%"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td><div style="line-height:20px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:20px;text-align:left">When you reach out to our Customer Support Team for assistance, it is our goal to offer you the experience you expect from Privacy4Cars.</span></div></td></tr></table></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td width="100%" align="center" class="TNffW8FkcQIUIB1JPxfleHM1TiY9CI invert-bg" style="background-repeat:no-repeat!important;background-position:center center!important;background-size:cover!important;border-radius:8px;border-collapse:separate!important;padding-left:16px;padding-right:16px" background="https://plugin.markaimg.com/public/9f0a083a/TNffW8FkcQIUIB1JPxfleHM1TiY9CI.png"><div><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td align="center"><div style="line-height:22px;text-align:center"><span style="color:#0a3a59;font-weight:700;font-family:Arial,Arial,sans-serif;font-size:18px;line-height:22px;text-align:center">How satisfied were you with the assistance you received from our Customer Support team?</span></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td align="center"><table cellspacing="0" cellpadding="0" border="0"><tr><td align="center" style="vertical-align:middle"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr class="stars-rating">'.$ratingHTML.'</tr></table></td></tr></table></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr></table></div></td></tr><tr><td height="16" style="height:16px;min-height:16px;line-height:16px"></td></tr><tr><td><div style="line-height:20px;text-align:left"><span style="color:#001;font-family:Arial,Arial,sans-serif;font-size:15px;line-height:20px;text-align:left">Thank you in advance for your participation and we look forward to your valuable input!</span></div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr><tr><td width="100%"><table width="100%" cellspacing="0" cellpadding="0" border="0"><tr><td width="100%" style="vertical-align:middle;background-color:#0a3a59;padding-left:24px;padding-right:24px" bgcolor="#0a3a59"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr><tr><td style="height:24px" width="444"><div style="line-height:24px;text-align:left"><span style="color:#fff;font-weight:600;font-family:Inter,Arial,sans-serif;font-size:14px;line-height:24px;text-align:left"><a style="color:#fff;font-weight:600;font-family:Inter,Arial,sans-serif;font-size:14px;line-height:24px;text-align:left" href="'.home_url().'" target="_blank">'.home_url().'</a></span></div></td><td> </td><td style="vertical-align:middle" width="64"><table cellspacing="0" cellpadding="0" border="0"><tr><td width="64"><table width="100%" border="0" cellpadding="0" cellspacing="0"><tr><td width="24"><a href="https://www.linkedin.com/company/privacy4cars"><img alt="LinkedIn" src="https://storage.googleapis.com/privacy4cars/static/script/images/linkedin%20icon.png" width="24" border="0" style="min-width:24px;width:24px;height:auto;display:block"></a></td><td style="width:16px;min-width:16px" width="16"></td><td width="24"><a href="https://www.youtube.com/@privacy4cars347"><img alt="YouTube" src="https://storage.googleapis.com/privacy4cars/static/script/images/youtube%20icon.png" width="24" border="0" style="min-width:24px;width:24px;height:auto;display:block"></a></td></tr></table></td></tr></table></td></tr><tr><td height="24" style="height:24px;min-height:24px;line-height:24px"></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div>';
        $email_content .= '</body></html>';

        $message = $email_content;
        $headers = array(
            'Content-Type: text/html; charset=UTF-8',
            'From: Privacy4Cars Support <support@privacy4cars.com>',
        );

        //We have added a SMTP plugin to send emails
        $sent = wp_mail( $to, $subject, $message, $headers );

        if ( $sent ) {
            echo 'Email sent successfully! to '. $to;
        } else {
            echo 'Failed to send email!';
        }
    }
    wp_die();
}


// AJAX action to save rating to post meta
add_action('wp_ajax_nopriv_save_rating_to_post_meta', 'save_rating_to_post_meta');
add_action('wp_ajax_save_rating_to_post_meta', 'save_rating_to_post_meta');
function save_rating_to_post_meta() {
    check_ajax_referer('save_rating_nonce', 'security');

    if (isset($_POST['post_id'], $_POST['rating'])) {
        $post_id = intval($_POST['post_id']);
        $rating = intval($_POST['rating']);

        //Check if user has already rated or not
        $has_rated = get_post_meta( $post_id, 'cf_user_rating', true );
        if(!empty($has_rated)){
            wp_send_json_error('rated');
        }else{
            // Save rating to post meta
            update_post_meta($post_id, 'cf_user_rating', $rating);
            wp_send_json_success('rating_saved');
        }
        
    } else {
        wp_send_json_error('invalid_data');
    }
}

// Function to handle user feedback comment form submission
function handle_user_feedback_submission() {
    if (isset($_POST['rating'], $_POST['comments'], $_POST['postID'])) {
        $comments = sanitize_text_field($_POST['comments']);
        $post_id = intval($_POST['postID']);

        // Save the feedback (rating and comments) to the post meta
        update_post_meta($post_id, 'cf_comments', $comments);

        // Optionally, redirect to a thank you page
        //wp_redirect(home_url('/thank-you'));
        wp_redirect(home_url());
        exit;
    }
}

// Hook the function to the admin-post action
add_action('admin_post_submit_user_feedback', 'handle_user_feedback_submission');
add_action('admin_post_nopriv_submit_user_feedback', 'handle_user_feedback_submission');

//Remove post row actions in admin from post listing page where post type is 
add_filter( 'post_row_actions', 'customer_feedback_remove_row_actions', 10, 2 );
function customer_feedback_remove_row_actions( $actions, $post )
{
    if ( $post->post_type == 'customer-feedback' ) {
        unset( $actions['edit'] );
        unset( $actions['view'] );
        unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
    }
    return $actions;
}

// Hide the Edit Post Link Start.
add_action( 'admin_footer-edit.php', 'customer_feedback_remove_a_href' );
function customer_feedback_remove_a_href(){
    ?>
        <script type="text/javascript">
            var urlParams = new URLSearchParams(window.location.search);
            var post_type = urlParams.get('post_type');
            if(post_type==='customer-feedback'){
                jQuery('table.wp-list-table a.row-title').contents().unwrap();
            }
        </script>
        <?php
}
// Hide the Edit Post Link End.

//Add Custom posts columns
add_filter( 'manage_customer-feedback_posts_columns', 'set_custom_edit_feedback_columns' );
add_action( 'manage_customer-feedback_posts_custom_column' , 'custom_feedback_column', 10, 2 );

function enqueue_admin_bootstrap() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    
    // Enqueue Bootstrap JS
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_admin_bootstrap');

function set_custom_edit_feedback_columns($columns) {
    //unset( $columns['author'] );
    $columns['case_date'] = __( 'Date', 'your_text_domain' );
    $columns['customer_name'] = __( 'Customer Name', 'your_text_domain' );
    $columns['customer_email'] = __( 'Customer Email', 'your_text_domain' );
    $columns['customer_handled'] = __( 'Case Handled By', 'your_text_domain' );
    $columns['customer_message'] = __( 'Comments', 'your_text_domain' );
    $columns['rating'] = __( 'Ratings', 'your_text_domain' );
    $columns['title'] = __( 'Cases', 'your_text_domain' );

    return $columns;
}

function custom_feedback_column( $column, $post_id ) {
    switch ( $column ) {

        case 'case_date' :
            echo get_the_date(); 
            break;

        case 'customer_name' :
            echo get_post_meta( $post_id , 'cf_user_name' , true ); 
            break;

        case 'customer_email' :
            echo get_post_meta( $post_id , 'cf_user_email' , true ); 
            break;

        case 'customer_handled' :
            echo get_post_meta( $post_id , 'cf_case_handled_by' , true ); 
            break;

        case 'customer_message' :
            $contents = get_post_meta( $post_id , 'cf_comments' , true );
            echo '<a href="#view_'.$post_id.'" data-toggle="collapse">View Comment</a><div id="view_'.$post_id.'" class="collapse">'.$contents.'</div>';        
            break;

        case 'rating' :
            echo get_post_meta( $post_id , 'cf_user_rating' , true ); 
            break;
    }
}

// Add the export button
function add_export_button() {
    $screen = get_current_screen();
    if ($screen->post_type == 'customer-feedback') { 
        ?>
        <div style="float: inline-end; margin-top: 0px; margin-bottom: 8px;">
            <a href="<?php echo add_query_arg('export_csv', '1'); ?>" class="button button-primary"><?php _e('Export', 'your_text_domain'); ?></a>
        </div>
        <?php
    }
}
add_action('restrict_manage_posts', 'add_export_button');

// Handle the export request
function export_custom_post_to_csv() {
    if (isset($_GET['export_csv'])) {
        if (!current_user_can('manage_options')) {
            return;
        }

        $args = array(
            'post_type' => 'customer-feedback', // Replace with your custom post type
            'post_status' => 'private',
            'posts_per_page' => -1,
        );

        $posts = get_posts($args);

        if ($posts) {
            ob_start();
            $current_date = date('Y-m-d');
            $filename = "customer_feedback_report_{$current_date}.csv";
            header('Content-Type: text/csv; charset=utf-8');
            header("Content-Disposition: attachment; filename={$filename}");

            $output = fopen('php://output', 'w');
            fputcsv($output, array('Date', 'Customer Name', 'Customer Email', 'Case Handled By', 'Comments', 'Ratings', 'Case'));

            foreach ($posts as $post) {
                $post_meta = get_post_meta($post->ID);
                $data = array(
                    get_the_date('', $post->ID),
                    isset($post_meta['cf_user_name'][0]) ? $post_meta['cf_user_name'][0] : '',
                    isset($post_meta['cf_user_email'][0]) ? $post_meta['cf_user_email'][0] : '',
                    isset($post_meta['cf_case_handled_by'][0]) ? $post_meta['cf_case_handled_by'][0] : '',
                    isset($post_meta['cf_comments'][0]) ? $post_meta['cf_comments'][0] : '',
                    isset($post_meta['cf_user_rating'][0]) ? $post_meta['cf_user_rating'][0] : '',
                    get_the_title($post->ID)
                );
                fputcsv($output, $data);
            }

            fclose($output);
            ob_end_flush();
            exit;
        }
    } 
}
add_action('admin_init', 'export_custom_post_to_csv');


// Add submenu ratings under customer-feedback parent menu
add_action('admin_menu', 'add_ratings_submenu');
function add_ratings_submenu() {
    add_submenu_page(
        'edit.php?post_type=customer-feedback',  // Parent slug
        'Ratings',                               // Page title
        'Ratings',                               // Menu title
        'manage_options',                        // Capability
        'ratings',                               // Menu slug
        'display_ratings_page'                   // Callback function
    );
}

function display_ratings_page() {
    ?>
    <style>
        .supportListing {
            position: fixed;
            top: 15%;
            left: 23%;
            padding-top: 10%;
        }
        .supportListing .modal-body{
            max-height: 350px;
        }
        .supportListing .modal-title{
            font-size: 24px;
            font-weight: normal;
        }
        .supportListing .modal-body .table tbody td{
            font-size: 14px;
        }
    </style>
    <div class="container-fluid">
        <h2>Ratings:</h2>
  
        <?php
        // Custom code to calculate and display average ratings
        global $wpdb;

        //total feedback sent
        $total_feedback_sent_p4c = 0;
        $total_feedback_sent_result = $wpdb->get_results("SELECT count(*) as total_feedback_sent_p4c_count
        FROM wp_posts WHERE wp_posts.post_type='customer-feedback' AND wp_posts.post_status='private'");
        if($total_feedback_sent_result){
            $total_feedback_sent_p4c = $total_feedback_sent_result[0]->total_feedback_sent_p4c_count;
        }

        // total feedback received
        $total_feedback_received_p4c = 0;
        $total_feedback_received_result = $wpdb->get_results("SELECT count(*) as total_feedback_received_p4c_count
        FROM wp_posts INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id 
        WHERE wp_posts.post_type='customer-feedback' AND wp_posts.post_status='private'
        AND wp_postmeta.meta_key IN ('cf_user_rating')
        AND wp_postmeta.meta_value != ''");
        if($total_feedback_received_result){
            $total_feedback_received_p4c = $total_feedback_received_result[0]->total_feedback_received_p4c_count;
        }

        // Average rating
        $rating = $wpdb->get_results("SELECT AVG(CAST(meta_value AS UNSIGNED)) AS average_rating
        FROM wp_postmeta 
        INNER JOIN wp_posts ON wp_postmeta.post_id = wp_posts.ID 
        WHERE wp_posts.post_type = 'customer-feedback' 
          AND wp_posts.post_status = 'private'
          AND wp_postmeta.meta_key = 'cf_user_rating'
          AND wp_postmeta.meta_value != ''");
          if($rating){
            $average_rating = $rating[0]->average_rating;
          }
        ?>
        <ul class="list-group">
            <li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
            <strong>Total Feedback Sent</strong>
            <span class="badge badge-primary badge-pill"><?php echo $total_feedback_sent_p4c; ?></span>
            </li>
            <li class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
            <strong>Total Feedback Received</strong>
            <span class="badge badge-primary badge-pill"><?php echo $total_feedback_received_p4c; ?></span>
            </li>
            <li class="list-group-item list-group-item-info d-flex justify-content-between align-items-center">
            <strong>Average Rating</strong>
            <span class="badge badge-primary badge-pill"><?php echo round($average_rating, 2); ?></span>
            </li>
        </ul> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><strong>Support Person</strong></th>
                    <th><strong>Total Feedback Sent</strong></th>
                    <th><strong>Total Feedback Received</strong></th>
                    <th><strong>Average Rating</strong></th>
                </tr>
            </thead>
            <?php
                $TeamNames = [
                    'Anvesh', 'Arnab', 'Dhananjay Aher', 'Harpreet Singh', 
                    'Nagendrababu', 'Neha', 'Omer', 'Ruchitha', 
                    'Venkata', 'Vimala'
                ];

            ?>
            <tbody>
                <?php foreach ($TeamNames as $name): ?>
                <tr>
                    <td><?php echo htmlspecialchars($name); ?></td>
                    <td><?php echo get_total_feedback_sent($name); ?></td>
                    <?php $nameAfterSpaceRemoved = str_replace(' ', '', $name); ?>
                    <td><?php echo '<a href="#" data-toggle="modal" data-target="#open'.$nameAfterSpaceRemoved.'Modal">'. get_total_feedback_received($name) .'</a>'; ?></td>
                    <td><?php echo get_average_rating($name); ?></td>
                </tr>                
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
                    <!-- Modal Template -->
                    <?php foreach ($TeamNames as $name): ?>
                        <?php $nameAfterSpaceRemoved = str_replace(' ', '', $name); ?>
                        <div class="modal supportListing fade" id="<?php echo 'open'.$nameAfterSpaceRemoved.'Modal'; ?>">
                            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Total Feedback Sent by: <?php echo $name; ?></h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Case No.</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Ratings</th>
                                                <th>Comments</th>
                                            </tr>
                                        </thead>                                    
                                    <tbody>
                                    <?php $feedbacks = get_feedback_details($name); 
                                    if (empty($feedbacks)): ?>
                                        <tr>
                                            <td colspan="5">No Records found!</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($feedbacks as $feedback): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($feedback->case_no); ?></td>
                                                <td><?php echo htmlspecialchars($feedback->customer_name); ?></td>
                                                <td><?php echo htmlspecialchars($feedback->customer_email); ?></td>
                                                <td><?php echo htmlspecialchars($feedback->ratings); ?></td>
                                                <td style="overflow-wrap: anywhere;"><?php echo htmlspecialchars($feedback->comments); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                    </table>
                                </div>                               

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
    <?php
}

function get_total_feedback_sent($supportTeamName){
    global $wpdb;
    $total_feedback_sent_ = 0;
    $query = "SELECT count(*) as total_feedback_sent_
    FROM wp_posts INNER JOIN wp_postmeta ON wp_posts.ID = wp_postmeta.post_id
    WHERE wp_posts.post_type='customer-feedback' AND wp_posts.post_status='private'
    AND wp_postmeta.meta_key IN ('cf_case_handled_by')
    AND wp_postmeta.meta_value = '".$supportTeamName."'";
    $feedback_sent_result_ = $wpdb->get_results($query);
    if($feedback_sent_result_){
        $total_feedback_sent_ = $feedback_sent_result_[0]->total_feedback_sent_;
    }
    return $total_feedback_sent_;
}
function get_total_feedback_received($supportTeamName){
    global $wpdb;
    $total_feedback_received_ = 0;
    $query = "SELECT COUNT(*) AS total_feedback_received_
    FROM wp_posts 
    INNER JOIN wp_postmeta AS meta1 ON wp_posts.ID = meta1.post_id
    INNER JOIN wp_postmeta AS meta2 ON wp_posts.ID = meta2.post_id
    WHERE wp_posts.post_type = 'customer-feedback' 
      AND wp_posts.post_status = 'private'
      AND meta1.meta_key = 'cf_case_handled_by'
      AND meta1.meta_value = '".$supportTeamName."'
      AND meta2.meta_key = 'cf_user_rating'
      AND meta2.meta_value != ''";
    $feedback_received_result_ = $wpdb->get_results($query);
    if($feedback_received_result_){
        $total_feedback_received_ = $feedback_received_result_[0]->total_feedback_received_;
    }
    return $total_feedback_received_;
}

function get_average_rating($supportTeamName){
    global $wpdb;
    $final_average_rating = 0;
    $query = "SELECT AVG(CAST(meta2.meta_value AS UNSIGNED)) AS average_rating
    FROM wp_posts 
    INNER JOIN wp_postmeta AS meta1 ON wp_posts.ID = meta1.post_id
    INNER JOIN wp_postmeta AS meta2 ON wp_posts.ID = meta2.post_id
    WHERE wp_posts.post_type = 'customer-feedback' 
      AND wp_posts.post_status = 'private'
      AND meta1.meta_key = 'cf_case_handled_by'
      AND meta1.meta_value = '".$supportTeamName."'
      AND meta2.meta_key = 'cf_user_rating'
      AND meta2.meta_value != ''";
    $avg_rating_result_ = $wpdb->get_results($query);
    if($avg_rating_result_){
        $final_average_rating = round($avg_rating_result_[0]->average_rating, 2);
    }
    return $final_average_rating;
}

function get_feedback_details($supportTeamName) {
    global $wpdb;
    $query = $wpdb->prepare(
        "SELECT DISTINCT
        wp_posts.ID AS case_no,
        meta1.meta_value AS customer_name,
        meta2.meta_value AS customer_email,
        meta3.meta_value AS ratings,
        meta4.meta_value AS comments
    FROM 
        wp_posts
    INNER JOIN 
       wp_postmeta ON wp_posts.ID = wp_postmeta.post_id 
    INNER JOIN 
        wp_postmeta AS meta1 ON wp_posts.ID = meta1.post_id AND meta1.meta_key = 'cf_user_name'
    INNER JOIN 
        wp_postmeta AS meta2 ON wp_posts.ID = meta2.post_id AND meta2.meta_key = 'cf_user_email'
    INNER JOIN 
        wp_postmeta AS meta3 ON wp_posts.ID = meta3.post_id AND meta3.meta_key = 'cf_user_rating'
    INNER JOIN 
        wp_postmeta AS meta4 ON wp_posts.ID = meta4.post_id AND meta4.meta_key = 'cf_comments'
    INNER JOIN 
        wp_postmeta AS meta5 ON wp_posts.ID = meta5.post_id
    WHERE 
        wp_posts.post_type = 'customer-feedback' AND wp_posts.post_status = 'private'
        AND meta5.meta_key = 'cf_case_handled_by'
        AND meta5.meta_value = '".$supportTeamName."'
        AND meta3.meta_value != ''",
    );
    return $wpdb->get_results($query);
}