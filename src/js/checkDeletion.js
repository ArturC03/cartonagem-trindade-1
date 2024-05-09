$(function() {
    $('td a#delete_group').click(function() {
        return confirm("Tem a certeza que pretende eliminar o grupo?");
    });
    $('td a#delete_exported').click(function() {
        return confirm("Tem a certeza que pretende eliminar o agendamento?");
    });
    $('td a#delete_user').click(function() {
        return confirm("Tem a certeza que pretende eliminar o utilizador?");
    });
});