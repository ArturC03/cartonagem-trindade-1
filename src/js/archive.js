$('#submit').on('click', function(e) {
    var mindate = $('#mindate');
    var maxdate = $('#maxdate');
    var mintime = $('#mintime');
    var maxtime = $('#maxtime');

    if (mindate.val() > maxdate.val()) {
        e.preventDefault();
        maxdate[0].setCustomValidity('A data de fim não pode ser anterior à data de início');
        maxdate[0].reportValidity();
    } else {
        maxdate[0].setCustomValidity('');

        if (mintime.val() > maxtime.val()) {
            e.preventDefault();
            maxtime[0].setCustomValidity('A hora de fim não pode ser anterior à hora de início');
            maxtime[0].reportValidity();
        } else {
            maxtime[0].setCustomValidity('');
        }
    }
});

$(document).on('click', 'input[type="checkbox"]', function () {
    var $collapse = $(this).closest('.collapse');
    var $checkboxes = $collapse.find('.collapse-content input[type="checkbox"]');
    var $todos = $collapse.find('input[name="selectAll"]');

    if (!this.checked) {
        $todos.prop("checked", false);
    }

    if ($checkboxes.not($todos).filter(':checked').length === $checkboxes.length - 1 && !$todos.is(":checked") && !$(this).is($todos)) {
        $todos.prop("checked", true);
    }
});

$(document).on('click', 'input[name="selectAll"]', function(){
    var $collapse = $(this).closest('.collapse');
    var $checkboxes = $collapse.find('.collapse-content input[type="checkbox"]');
    var $todos = $collapse.find('input[name="selectAll"]');

    if ($(this).is(":checked")){
        $checkboxes.prop("checked", true);
    } else {
        $checkboxes.prop("checked", false);
    }
});