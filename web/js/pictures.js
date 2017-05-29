// AFFICHAGE DES PHOTOS
$(function () {
    // Ici on attend que le fichier soit sélectionné
    $('.file_input_0, .file_input_1, .file_input_2').on('change', function (e) {
        var inputClass = "";
        if ($(this).hasClass('file_input_0')) {
            inputClass = 'file_input_0';
        } else if ($(this).hasClass('file_input_1')) {
            inputClass = 'file_input_1';
        } else {
            inputClass = 'file_input_2';
        }

        var files = $(this)[0].files;

        if (files.length > 0) {
            var file = files[0],
                $image_preview = $('#image_preview_' + inputClass);
            $image_preview.find('.thumbnail').removeClass('hidden');
            $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
        }
    });

    // Ici Bouton Annuler
    $('#image_preview_file_input_0, #image_preview_file_input_1, #image_preview_file_input_2').find('button[type="button"]').on('click', function (e) {
        e.preventDefault();
        $('.' + $(this).attr('id')).val('');
        $('#image_preview_' + $(this).attr('id')).find('.thumbnail').addClass('hidden');
    });
});