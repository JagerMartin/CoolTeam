// AFFICHAGE DES PHOTOS
$(function () {
    // Ici on attend que le fichier soit sélectionné
    $('.input_file_0, .input_file_1, .input_file_2').on('change', function (e) {
        var inputClass = "";
        if ($(this).hasClass('input_file_0')) {
            inputClass = 'input_file_0';
        } else if ($(this).hasClass('input_file_1')) {
            inputClass = 'input_file_1';
        } else {
            inputClass = 'input_file_2';
        }

        var files = $(this)[0].files;

        if (files.length > 0) {
            var file = files[0],
                $image_preview = $('#image_preview_' + inputClass);
            $image_preview.find('.thumbnail').removeClass('hidden');
            $('.'+inputClass).addClass('hidden');
            $image_preview.find('img').attr('src', window.URL.createObjectURL(file));
        }
    });

    // Ici Bouton Annuler de Add (ajout d'observation)
    $('#image_preview_input_file_0, #image_preview_input_file_1, #image_preview_input_file_2').find('button[type="button"]').on('click', function (e) {
        e.preventDefault(); // Bloque l'action du bouton
        $('.' + $(this).attr('id')).val(''); // Supprime la valeur de la classe qui a le même nom que l'id de this -> ici input_file_x
        $('#image_preview_' + $(this).attr('id')).find('.thumbnail').addClass('hidden'); // On ajoute la classe hidden au div.thumbnail
        $('.' + $(this).attr('id')).removeClass('hidden'); // On supprime la classe hidden à l'input
    });

    // Ici Bouton Supprimer de update (modification d'obervation)
    $('#image_preview_file_0, #image_preview_file_1, #image_preview_file_2').find('button[type="button"]').on('click', function (e) {
        e.preventDefault(); // Bloque l'action du bouton
        $('#image_preview_' + $(this).attr('id')).find('.thumbnail').addClass('hidden'); // On ajoute la classe hidden au div.thumbnail
        $('.' + $(this).attr('id')).removeClass('hidden'); // On supprime la classe hidden à l'input
    });
});