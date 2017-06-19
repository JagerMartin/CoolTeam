/************************************************************
 * Permet de masquer/faire apparaitre les div de la page    *
 * Aprendre à observer en cliquant sur les différents item  *
 * du menu                                                  *
 ************************************************************/
$(document).ready(function(){
    $("#aoquandclick").click(function(){
        $("#collapseAoquand").show();
        $("#collapseAoemporter").hide();
        $("#collapseAocomment").hide();
        $("#ccollapseAonoter").hide();
        $("#collapseAocharte").hide();
        $("#aoTitreH4").show();
        $("#aoTitre2H4").hide();
        $("#aoTitre3H4").hide();
        $("#aoTitre4H4").hide();
        $("#aoTitre5H4").hide();
    });
    $("#aoemporterclick").click(function(){
        $("#collapseAoemporter").show();
        $("#collapseAoquand").hide();
        $("#collapseAocomment").hide();
        $("#collapseAonoter").hide();
        $("#collapseAocharte").hide();
        $("#aoTitreH4").hide();
        $("#aoTitre2H4").show();
        $("#aoTitre3H4").hide();
        $("#aoTitre4H4").hide();
        $("#aoTitre5H4").hide();
    });
    $("#aocommentclick").click(function(){
        $("#collapseAoquand").hide();
        $("#collapseAoemporter").hide();
        $("#collapseAocomment").show();
        $("#collapseAonoter").hide();
        $("#collapseAocharte").hide();
        $("#aoTitreH4").hide();
        $("#aoTitre2H4").hide();
        $("#aoTitre3H4").show();
        $("#aoTitre4H4").hide();
        $("#aoTitre5H4").hide();
    });
    $("#aonoterclick").click(function(){
        $("#collapseAoquand").hide();
        $("#collapseAoemporter").hide();
        $("#collapseAocomment").hide();
        $("#collapseAonoter").show();
        $("#collapseAocharte").hide();
        $("#aoTitreH4").hide();
        $("#aoTitre2H4").hide();
        $("#aoTitre3H4").hide();
        $("#aoTitre4H4").show();
        $("#aoTitre5H4").hide();

    });
    $("#aocharteclick").click(function(){
        $("#collapseAoquand").hide();
        $("#collapseAoemporter").hide();
        $("#collapseAocomment").hide();
        $("#collapseAonoter").hide();
        $("#collapseAocharte").show();
        $("#aoTitreH4").hide();
        $("#aoTitre2H4").hide();
        $("#aoTitre3H4").hide();
        $("#aoTitre4H4").hide();
        $("#aoTitre5H4").show();
    });
    $("#ccmobservclick").click(function(){
        $("#ccmnaturaliste").hide();
        $("#ccmobserv").show();
    });
    $("#ccmnaturalisteclick").click(function(){
        $("#ccmnaturaliste").show();
        $("#ccmobserv").hide();
    });

    /*
        Particularité du la asso et apprendre à observer avec resolution
        d'écran >992px
     */
    if(window.innerWidth>992) {
        $('#collapseAssoButton').detach();
        $('#collapseAsso').removeClass('collapse');
        $('#collapseProgRechButton').detach();
        $('#collapseProgRech').removeClass('collapse');
        $('#collapsePartenaires').detach();
        $('#collapsePart').removeClass('collapse');

        $("#collapseAoquandButton").detach();
        $("#collapseAoemporterButton").detach();
        $("#collapseAocommentButton").detach();
        $("#collapseAonoterButton").detach();
        $("#collapseAocharteButton").detach();

        $("#collapseAoquand").show();
        $("#aoTitre2H4").hide();
        $("#aoTitre3H4").hide();
        $("#aoTitre4H4").hide();
        $("#aoTitre5H4").hide();
    }


});


/********************************************
 * initialize les tooltips pour l'aide dans *
 * l'ajout d'observations (info-bulle)      *
 ********************************************/
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

/****************************************************
 *      Initialisation pour le bouton hamburger     *
 ****************************************************/
$( ".cross" ).hide();
$( ".menu2" ).hide();
$( ".hamburger" ).click(function() {
    $( ".menu2" ).animate({left: "0px", width:"100%"}, function() {
        $( ".hamburger" ).hide();
        $( ".cross" ).show();
        $( ".menu2" ).show()
    });
});

$( ".cross" ).click(function() {
    $( ".menu2" ).animate({left: "355px"}, function() {
    /**$( ".menu2" ).slideToggle( "slow", function() { **/
        $( ".menu2" ).hide();
        $( ".cross" ).hide();
        $( ".hamburger" ).show();
        $( ".menu2").attr('left:','0px')
    });
});




/***************************************************
 * Bouton qui permet de remonter en haut de page   *
 ***************************************************/
Waves.attach('.btn, .btn-floating', ['waves-light']);
Waves.attach('.img-waves a', ['waves-light']);
Waves.attach('.navbar a', ['waves-light']);
Waves.init();

/**************************
 * Pour la homepage     **
 *************************/
//Menu BIRDYGO
$(document).ready(function() {
    if(window.innerWidth<769) {
        $("#divbuttonMobile").hover(function() {
            $(".margeImageMobileB").animate({ marginLeft: "0"  }, 400 );
            $("#itembirdygoMobile").show(400);
            $("#divbuttonMobile").animate({ marginLeft: "-1px"  }, 400 );
            $('#arrowbirdygoMobile').removeClass('fa fa-arrow-circle-right').addClass('fa fa-arrow-circle-left')
        }, function() {
            $("#divbuttonMobile").click(function() {
                $(".margeImageMobileB").animate({ marginLeft: "55%"  }, 400 );
                $("#itembirdygoMobile").hide(400);
                $("#divbuttonMobile").animate({ marginLeft: "-1px"  }, 400 );
                $('#arrowbirdygoMobile').removeClass('fa fa-arrow-circle-left arrowbirdygoMobile').addClass('fa fa-arrow-circle-right arrowbirdygoMobile')
            });
        });
    }
    if(window.innerWidth<992) {
        $("#divbutton2").hover(function() {
            $(".margeImageB2").animate({ marginLeft: "0px"  }, 400 );
            $("#itembirdygo2").animate({ marginLeft: "0"  }, 400 );
            $("#divbutton2").animate({ marginLeft: "-1px"  }, 400 );
            $('#arrowbirdygo2').removeClass('fa fa-arrow-circle-right').addClass('fa fa-arrow-circle-left')
        }, function() {
            $("#divbutton2").click(function() {
                $(".margeImageB2").animate({ marginLeft: "40%"  }, 400 );
                $("#itembirdygo2").animate({ marginLeft: "-40%"  }, 400 );
                $("#divbutton2").animate({ marginLeft: "-1px"  }, 400 );
                $('#arrowbirdygo2').removeClass('fa fa-arrow-circle-left arrowbirdygo2').addClass('fa fa-arrow-circle-right arrowbirdygo2')
            });
        });
    }
    if(window.innerWidth>992) {
            $("#divbutton2").hover(function() {
                $(".margeImageB2").animate({ marginLeft: "0"  }, 400 );
                $("#itembirdygo2").animate({ marginLeft: "0"  }, 400 );
                $("#divbutton2").animate({ marginLeft: "1px"  }, 400 );
                $('#arrowbirdygo2').removeClass('fa fa-arrow-circle-right').addClass('fa fa-arrow-circle-left')
            }, function() {
                $("#divbutton2").click(function() {
                    $(".margeImageB2").animate({ marginLeft: "40%" }, 400 );
                    $("#itembirdygo2").animate({ marginLeft: "-40%" }, 400 );
                    $("#divbutton2").animate({ marginLeft: "-1px"  }, 400 );
                    $('#arrowbirdygo2').removeClass('fa fa-arrow-circle-left arrowbirdygo2').addClass('fa fa-arrow-circle-right arrowbirdygo2')
                });
            });
        }
});


//Carousel Header
$('#myCarousel1, #myCarousel2').carousel({
    interval: 25000
});
//Animation cercle
new WOW().init();
/**********/
/*compteur*/
/*********/
$(document).ready(function(){
    var observerCount = $('#cpteObserv').data('res');
    var naturalistCount = $('#cpteNaturaliste').data('res');
    var specieCount = $('#cpteEspeces').data('res');
    var observationCount = $('#cpteObservations').data('res');

    $(".bhide").click(function(){
        $(".hideObj").slideDown();
        $(this).hide(); //.attr()
        return false;
    });
    $(".bhide2").click(function(){
        $(".container.hideObj2").slideDown();
        $(this).hide(); // .attr()
        return false;
    });
    $('.heart').mouseover(function(){
        $(this).find('i').removeClass('fa-heart-o').addClass('fa-heart');
    }).mouseout(function(){
        $(this).find('i').removeClass('fa-heart').addClass('fa-heart-o');
    });
    function sdf_FTS(_number,_decimal,_separator)
    {
        var decimal=(typeof(_decimal)!='undefined')?_decimal:2;
        var separator=(typeof(_separator)!='undefined')?_separator:'';
        var r=parseFloat(_number)
        var exp10=Math.pow(10,decimal);
        r=Math.round(r*exp10)/exp10;
        rr=Number(r).toFixed(decimal).toString().split('.');
        b=rr[0].replace(/(\d{1,3}(?=(\d{3})+(?:\.\d|\b)))/g,"\$1"+separator);
        r=(rr[1]?b+'.'+rr[1]:b);
        return r;
    }
    setTimeout(function(){
        $('#counter').text('0');
        $('#counter1').text('0');
        $('#counter2').text('0');
        $('#counter3').text('0');
        setInterval(function(){
            var curval=parseInt($('#counter').text());
            var curval1=parseInt($('#counter1').text().replace(' ',''));
            var curval2=parseInt($('#counter2').text());
            var curval3=parseInt($('#counter3').text());
            if(curval<=200-1){
                $('#counter').text(curval+1);
            }
            if(curval1<=naturalistCount-1){
                $('#counter1').text(curval1+1);
            }
            if(curval2<=specieCount-10){
                $('#counter2').text(curval2+10);
            }
            if(curval3<=observationCount-1){
                $('#counter3').text(curval3+1);
            }
        }, 2);
    }, 500);
});

/*********************
 *     Newsletter    *
 *********************/
$(function(){
    // Modal newsletter cachée par défaut
    $('#newsletterModal').modal({ show: false});

    // TTT AJAX form newsletter
    $("body").on("submit", "#newsletterForm", function(e){
        e.preventDefault();
        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: $(this).serialize()
        })
            .done(function (data, textStatus, errorThrown) {
                if (data['title'] !== 'undefined' && data['body'] !== 'undefined') {
                    $('#newsletterModalTitle').html(data['title']);
                    $('#newsletterModalBody').html(data['body']);
                    $('#newsletterModal').modal('show');
                    $('#input_newsletter').val("");
                } else {
                    alert(errorThrown);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            });
    });

});

