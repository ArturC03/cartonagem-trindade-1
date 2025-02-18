$(document).ready(function() {
    // Função para carregar a lista de sensores ao carregar a página
    function loadSensorList(grupo) {
        $.ajax({
            type: 'POST',
            url: 'atualizar_sensores.php',
            data: { grupo: grupo },
            success: function(response) {
                $('.sensor-update').html(response);
            }
        });
    }

    // Carregar a lista de sensores quando a página for carregada
    loadSensorList($('select[name="grupo"]').val());

    // Lidar com a mudança na seleção de grupo
    $('select[name="grupo"]').change(function() {
        var selectedGrupo = $(this).val();
        $("#todos").prop("checked", false);
        loadSensorList(selectedGrupo);
    });

    
    $(document).on('click', 'input[type="checkbox"]', function () {
        if (!this.checked) {
            $("#todos").prop("checked", false);
        }
        
        if ($('input[type="checkbox"]:not(#todos):checked').length == $('input[type="checkbox"]').length - 1 && !$("#todos").is(":checked") && $(this).attr("id") != "todos") {
            $("#todos").prop("checked", true);
        }
    });

    $(document).on('click', "#todos", function(){
        if ($(this).is(":checked")){
            $(".checkbox").prop("checked", true);
        } else {
            $(".checkbox").prop("checked", false);
        }
    });

    $('#periodo').change(function() {
        var inputHora = $('#hora');
        inputHora.prop('disabled', this.value != 'ONCE');
    });
});