
            var menuOpacity = "0.9";
            // <![CDATA[
//

            var menuToggled = false;


            $("#btn-menu").click(
                function() {
                    if(!menuToggled) {
                        $("body").css({"overflow":"hidden"});
                        var degrees = 45;
                        $(".btn-menu-row:nth-child(2)").css({"opacity": "0"});
                        $(".btn-menu-row:first-child").css({'-webkit-transform' : 'rotate('+ degrees +'deg)',
                        '-moz-transform' : 'rotate('+ degrees +'deg)',
                        '-ms-transform' : 'rotate('+ degrees +'deg)',
                        'transform' : 'rotate('+ degrees +'deg)'});

                        $(".btn-menu-row:first-child").css({
                            "margin-bottom": "-8px"
                        });


                        $(".btn-menu-row:last-child").css({'-webkit-transform' : 'rotate(-'+ degrees +'deg)',
                        '-moz-transform' : 'rotate(-'+ degrees +'deg)',
                        '-ms-transform' : 'rotate(-'+ degrees +'deg)',
                        'transform' : 'rotate(-'+ degrees +'deg)'});
                        menuToggled = true;
                        $("#nav-main").addClass("active");
                    }
                    else {
                        $("body").css({"overflow":"visible"});
                        $(".btn-menu-row:nth-child(2)").css({"opacity": "1"});
                        $(".btn-menu-row:first-child").css({'-webkit-transform' : 'rotate(0deg)',
                        '-moz-transform' : 'rotate(0deg)',
                        '-ms-transform' : 'rotate(0deg)',
                        'transform' : 'rotate(0deg)'});

                        $(".btn-menu-row:first-child").css({
                            "margin-bottom": "4px"
                        });

                        $(".btn-menu-row:last-child").css({'-webkit-transform' : 'rotate(0deg)',
                        '-moz-transform' : 'rotate(0deg)',
                        '-ms-transform' : 'rotate(0deg)',
                        'transform' : 'rotate(0deg)'});
                        menuToggled = false;
                        $("#nav-main").removeClass("active");
                    }
                }
            );
            $("#nav-main").on('touchmove', function(e)
            {
                if (menuToggled)
                {
                    e.preventDefault();
                }
            });
            $(".submenu-toggle").click(function(e) {
                e.preventDefault();
                $(this).parent().find("ul").slideToggle();
            });
