<?php

add_filter('admin_footer_text', 'custom_admin_footer_text');
function custom_admin_footer_text()
{
    echo 'Premium web od <a href="https://fuze.technology" target="_blank">FUZE Technology</a>';
}

add_action('login_enqueue_scripts', 'fuze_login_logo');
function fuze_login_logo()
{
    ?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url("https://static.fuze.technology/img/logo-color.svg");
            height: 100px;
            width: 320px;
            background-repeat: no-repeat;
            background-size: 100%;
            background-position: center;
        }
    </style>
<?php }

add_filter('login_headerurl', 'fuze_login_logo_url');
function fuze_login_logo_url()
{
    return "https://fuze.technology";
}

add_filter('login_headertitle', 'fuze_login_logo_url_title');
function fuze_login_logo_url_title()
{
    return 'FUZE Technology';
}
