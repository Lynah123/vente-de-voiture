
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
    
    
  });