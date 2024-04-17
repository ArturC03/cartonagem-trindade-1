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

const draggable = new Draggable.Draggable(document.querySelectorAll('.draggable'), {
    draggable: '.draggable',
    handle: '.handle',
    delay: 200,
    onEnd: function () {
        this.trigger('dragged');
    }
});

const dropzone = new Draggable.Droppable(document.querySelectorAll('.dropzone'), {
    dropzone: '.dropzone',
    draggable: '.draggable',
    delay: 200,
    onDrop: function () {
        this.trigger('dropped');
    }
});

dropzone.on('dropped', function () {
    console.log('Dropped');
});

draggable.on('dragged', function () {
    console.log('Dragged');
});