// Import stylů na zpracování do Webpacku
import "../scss/app.scss";

// jQuery WordPress fix
import * as $ from 'jquery';

window['jQuery'] = window['$'] = $;

import 'bootstrap';
import AOS from 'aos';
import './modernizr-custom.js'


$(document).ready(function () {
    AOS.init();

    if (window.matchMedia('(max-width: 960px)').matches) {
        $(".dropdown-toggle").dropdown();
    }


    $(".dropdown-toggle").click(function () {
        if (window.matchMedia('(max-width: 960px)').matches) {

            if($(this).attr("href") == "#")
                $(this).hide();
                
            if ($(this).hasClass("clicked")) {
                    window.location.href = $(this).attr("href");
            } else {
                $(this).before('<button class="btn-back">Zpět</button>');

                $(this).addClass("clicked");

                $(".header-nav .nav-link").not(".clicked").each(function () {
                    $(this).toggleClass("d-none");
                });

                $(".btn-back").click(function () {
                    $(".header-nav .nav-link").not(".clicked").each(function () {
                        $(this).toggleClass("d-none");
                    });

                    $(this).parent().find('.dropdown-toggle').dropdown('toggle').removeClass("show clicked");
                    $(this).parent().find('.dropdown-toggle').show();
                    $(this).remove();
                });
            }
        }
    });


    /*
    if (window.matchMedia('(min-width: 961px)').matches) {
        $(".dropdown-toggle").click(function () {

            $(".dropdown-toggle").not(this).each(function () {
                $(this).removeClass("show");
                $(this).siblings("ul").removeClass("show");
            });

            $(this).each(function () {
                if ((this).hasClass("show")) {
                    $(this).removeClass("show");
                } else {
                    $(this).addClass("show");
                }


                if ((this).siblings("ul").hasClass("show")) {
                    $(this).siblings("ul").removeClass("show");
                } else {
                    $(this).siblings("ul").addClass("show");
                }
            });

        })
    }
    */

    $('#cookies button').click(function () {
        var date = new Date();
        date.setFullYear(date.getFullYear() + 10);
        document.cookie = 'cookiesAccepted=1; path=/; expires=' + date.toGMTString();
        $("#cookies").fadeOut();
    });
});


