$('button[type=submit]').on('click', function(e) {
    var $modalForm = $('#modalForm');
    var $checkboxes = $modalForm.find('input[type="checkbox"]');
    var $todos = $modalForm.find('input[name="selectAll"]');
    var $error = $('#sensorError');

    if ($checkboxes.not($todos).filter(':checked').length === 0) {
        e.preventDefault();
        $error[0].setCustomValidity('Preencha este campo.');
        $error[0].reportValidity();
    } else {
        $error[0].setCustomValidity('');
    }
});