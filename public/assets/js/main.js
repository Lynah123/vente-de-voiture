
//AFFICHAGE SOUS MENU SUR LE DROPDOWN EN SURVOLE
$(document).ready(function(){
    // Activer le dropdown Bootstrap
    $('.dropdown-toggle').dropdown();

    // Ajouter l'effet de survol pour afficher et masquer automatiquement le sous-menu
    $('.nav-item.dropdown').hover(
        function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(300);
        },
        function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(300);
        }
    );
});

//collectiontype

$("#add-type").click(function() {
    const index = +$('#widgets-counter').val();

    const tmpl = $('#brand_types').data('prototype').replace(/__name__/g, index);
    
    $('#brand_types').append(tmpl);

    $('#widgets-counter').val(index + 1);

    handleDeleteType();
});

function handleDeleteType(){
    $('button[data-action="delete-type"]').click(function() {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounterType() {
    const count = +$('#brand_types div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounterType();
handleDeleteType();

$("#add-category").click(function() {
    const index = +$('#widgets-counter').val();

    const tmpl = $('#brand_categories').data('prototype').replace(/__name__/g, index);
    
    $('#brand_categories').append(tmpl);

    $('#widgets-counter').val(index + 1);

    handleDeleteCategory();
});

function handleDeleteCategory(){
    $('button[data-action="delete-category"]').click(function() {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounterCategory() {
    const count = +$('#brand_categories div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounterCategory();
handleDeleteCategory();