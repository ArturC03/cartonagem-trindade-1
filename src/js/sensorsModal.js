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

    if ($(this).is(":checked")){
        $checkboxes.prop("checked", true);
    } else {
        $checkboxes.prop("checked", false);
    }
});

function selectSensors() {
    clearSensorSelection();

    var $modalForm = $('#modalForm');
    var $checkboxes = $modalForm.find('input[type="checkbox"]');

    var selectedSensors = [];
    $checkboxes.each(function() {
        if (this.checked && $(this).attr('name') !== 'selectAll') {
            selectedSensors.push($(this).attr('name'));
        }
    });

    var mainForm = $('#mainForm');
    var checkboxes = mainForm.find('input[type="checkbox"]');

    var strSensors = "";

    selectedSensors.forEach(function(item) {
        var checkbox = checkboxes.filter('[name="' + item + '"]');
        checkbox.prop('checked', true);
    });

    selectedSensors.forEach(function(item) {
        strSensors += item + ', ';
    });

    strSensors = strSensors.slice(0, -2);
    if (strSensors.length === 0) {
        strSensors = "Nenhum sensor selecionado";
    } else {
        $('#sensorsText').attr("placeholder", strSensors);
    }
}

function clearSensorSelection() {
    var $mainForm = $('#mainForm');
    var $checkboxes = $mainForm.find('input[type="checkbox"]');

    $checkboxes.prop('checked', false);
}

selectSensors();