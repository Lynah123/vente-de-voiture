$(document).ready(function() {
  $('#color').hide();
})

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

//COLLECTIONtYPE

$("#add-product-details").click(function() {
  const index = +$('#widgets-counter').val();
  const tmpl = $('#product_productDetails').data('prototype').replace(/__name__/g, index);
  $('#product_productDetails').append(tmpl);
  $('#widgets-counter').val(index + 1);
  handleDelete();
});

function handleDelete(){
  $('button[data-action="delete"]').click(function() {
      const target = this.dataset.target;
      $(target).remove();
  });
}

function updateCounter() {
  const count = +$('#product_productDetails div.form-group').length;

  $('#widgets-counter').val(count);
}

updateCounter();
handleDelete();


$("#add-product-color").click(function() {
  const index = +$('#widgets-counter-color').val();
  const tmpl = $('#add_color_product_colors').data('prototype').replace(/__name__/g, index);
  $('#add_color_product_colors').append(tmpl);
  $('#widgets-counter-color').val(index + 1);
  handleDeleteColor();
});

function handleDeleteColor(){
  $('button[data-action="delete-color"]').click(function() {
      const target = this.dataset.target;
      $(target).remove();
  });
}

function updateCounterColor() {
  const count = +$('#add_color_product_colors div.form-group').length;

  $('#widgets-counter-color').val(count);
}

updateCounterColor();
handleDeleteColor();

//datatable

$(document).ready(function() {
    $('#table-product').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });
  
    $('#type-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });

    $('#table-category').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });

    $('#table-supllier').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });

    $('#table-carrier').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });
    
    $('#adresse-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });

    $('#order-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });

    $('#color-table').DataTable({
      responsive: true,
      language: {
        url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json',
    },
      border: false,
      scrollX: '100%',
      pageLength: 10,
      scrollCollapse: false,
    });
    
  });