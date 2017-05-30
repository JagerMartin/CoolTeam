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
