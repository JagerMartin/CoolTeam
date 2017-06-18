/************************************************************
 * Permet de masquer/faire apparaitre les div de la page    *
 * Aprendre à observer en cliquant sur les différents item  *
 * du menu                                                  *
 ************************************************************/
$(document).ready(function(){
    $("#aoemporterclick").click(function(){
        $("#aoemporter").show();
        $("#aoquand").hide();
        $("#aocomment").hide();
        $("#aonoter").hide();
        $("#aocharte").hide();
    });
    $("#aoquandclick").click(function(){
        $("#aoquand").show();
        $("#aoemporter").hide();
        $("#aocomment").hide();
        $("#aonoter").hide();
        $("#aocharte").hide();
    });
    $("#aocommentclick").click(function(){
        $("#aoquand").hide();
        $("#aoemporter").hide();
        $("#aocomment").show();
        $("#aonoter").hide();
        $("#aocharte").hide();
    });
    $("#aonoterclick").click(function(){
        $("#aoquand").hide();
        $("#aoemporter").hide();
        $("#aocomment").hide();
        $("#aonoter").show();
        $("#aocharte").hide();
    });
    $("#aocharteclick").click(function(){
        $("#aoquand").hide();
        $("#aoemporter").hide();
        $("#aocomment").hide();
        $("#aonoter").hide();
        $("#aocharte").show();
    });

    $("#ccmobservclick").click(function(){
        $("#ccmnaturaliste").hide();
        $("#ccmobserv").show();
    });
    $("#ccmnaturalisteclick").click(function(){
        $("#ccmnaturaliste").show();
        $("#ccmobserv").hide();
    });

});

/********************************************
 * initialize les tooltips pour l'aide dans *
 * l'ajout d'observations (info-bulle)      *
 ********************************************/
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
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
//Carousel Header
$('#myCarousel1, #myCarousel2').carousel({
    interval: 10000
});
//Animation cercle
new WOW().init();
/**********/
/*compteur*/
/*********/
$(document).ready(function(){
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
            if(curval<=observerCount-1){
                $('#counter').text(curval+1);
            }
            if(curval1<=150-1){
                $('#counter1').text(curval1+1);
            }
            if(curval2<=3000-10){
                $('#counter2').text(curval2+10);
            }
            if(curval3<=245-1){
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

