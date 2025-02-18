var offset = -1;
var tableBody;
var flag = false;

function load_data() {
    $('.loader').removeClass("d-none");
    setTimeout(function() {
        $.ajax({
            url: "load_data.php",
            method: 'POST',
            data: { offset: offset == -1 ? $('.table-body table > tbody > tr').length : offset,
                    sql: document.getElementById('sql').textContent
                },
            dataType: 'json',
            error: err => {
                console.log(err)
            },
            success: function(resp) {
                offset = resp['offset'];
                if (resp['sql'].length > 0) {
                    Object.keys(resp['sql']).forEach(k => {
                        const row = resp['sql'][k];
                        const newRow = `
                            <tr>  
                                <td>${row["id_sensor"]}</td>
                                <td>${row["hour"]}</td>
                                <td>${row["date"]}</td>
                                <td>${String(row["temperature"]).replace(/^0+/, '')}</td>
                                <td>${String(row["humidity"]).replace(/^0+/, '')}</td>
                                <td>${String(row["pressure"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eCO2"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eTVOC"]).replace(/^0+/, '')}</td>
                            </tr>
                        `;
                        $('.table_body table > tbody').append(newRow);
                    });
                } else {
                    flag = true;
                    tableBody.off('scroll');
                }
            },
            complete: function() {
                $('.loader').addClass("d-none");
            }
        })
    }, 800)
}
$(function() {
    if (!flag) {
        tableBody = $('.table_body');
        load_data();
        $("#table_body").scroll(function() {
            var scrollHeight = tableBody[0].scrollHeight;
            var _scrolled = tableBody.scrollTop() + tableBody.innerHeight();

            if (scrollHeight - _scrolled <= 0.1 * scrollHeight) {
                if ($('.loader').is(':visible') == false){
                    load_data();
                }
            }
        });  
    }
});

function sendToCSV() {
    $('.loader').removeClass("d-none");
    setTimeout(function() {
        $.ajax({
            url: "obterCSV.php",
            method: 'POST',
            data: { sql: document.getElementById('sql2').textContent},
            dataType: 'json',
            error: err => {
                console.log(err)
            },
            complete: function () {
                document.location.href = "download/dados.csv";
                $('.loader').addClass("d-none");
            }
        })
    }, 800)
}