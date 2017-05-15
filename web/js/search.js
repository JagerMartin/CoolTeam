$(document).ready(function() {

    // ================================================
    // UN SEUL CHAMP REMPLIS A LA FOIS DANS LE FORM
    // ================================================

    $('#search_name').keyup(function(){
        $('#search_department').val("");
        $('#search_family').val("");
    });

    $('#search_family').change(function(){
        $('#search_name').val("");
        $('#search_department').val("");
    });

    $('#search_department').change(function(){
        $('#search_name').val("");
        $('#search_family').val("");
    });

});