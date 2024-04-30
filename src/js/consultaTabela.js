var offset = -1;
var tableBody;
var flag = false;

function load_data() {
    $('div:has(.loading)').removeClass("hidden");
    setTimeout(function() {
        $.ajax({
            url: "backend/load_data.php",
            method: 'POST',
            data: { offset: offset == -1 ? $('#table_body table > tbody > tr').length : offset,
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
                                <td>${new Date(row["date"]).toLocaleDateString('en-GB')}</td>
                                <td>${row["time"]}</td>
                                <td>${String(row["temperature"]).replace(/^0+/, '')}</td>
                                <td>${String(row["humidity"]).replace(/^0+/, '')}</td>
                                <td>${String(row["pressure"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eCO2"]).replace(/^0+/, '')}</td>
                                <td>${String(row["eTVOC"]).replace(/^0+/, '')}</td>
                            </tr>
                        `;
                        $('#table_body table > tbody').append(newRow);
                    });
                } else {
                    flag = true;
                    tableBody.off('scroll');
                }
            },
            complete: function() {
                $('div:has(.loading)').addClass("hidden");
            }
        })
    }, 800)
}

function sendToCSV() {
    $('div:has(.loading)').addClass("hidden");
    setTimeout(function() {
        $.ajax({
            url: "obter_CSV.php",
            method: 'POST',
            data: { sql: document.getElementById('sql2').textContent},
            dataType: 'json',
            error: err => {
                console.log(err)
            },
            complete: function () {
                document.location.href = "download/dados.csv";
                $('div:has(.loading)').addClass("hidden");
            }
        })
    }, 800)
}

function sendToJSON() {
    $('div:has(.loading)').addClass("hidden");
    setTimeout(function() {
        $.ajax({
            url: "obter_JSON.php",
            method: 'POST',
            data: { sql: document.getElementById('sql2').textContent},
            dataType: 'json',
            error: err => {
                console.log(err)
            },
            complete: function () {
                var link = document.createElement('a');
                link.href = "download/dados.json";
                link.download = "dados.json";
                link.click();
                link.remove();
                $('div:has(.loading)').addClass("hidden");
            }
        })
    }, 800)
}

$(function() {
    if (!flag) {
        tableBody = $('#table_body');
        load_data();
        $("#table_body").scroll(function() {
            var scrollHeight = tableBody[0].scrollHeight;
            var _scrolled = tableBody.scrollTop() + tableBody.innerHeight();

            if (scrollHeight - _scrolled <= 0.1 * scrollHeight) {
                if ($('div:has(.loading)').is(':visible') == false){
                    load_data();
                }
            }
        });  
    }

    $("#column").on("change", function() {
        offset = -1;
        $('#order').val("0");
        $('#table_body table > tbody').empty();

        switch (this.value) {
            case "":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY date, hour ASC";
                break;
            case "0":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY id_sensor DESC";
                break;
            case "1":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY temperature DESC";
                break;
            case "2":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY humidity DESC";
                break;
            case "3":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY pressure DESC";
                break;
            case "4":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY eCO2 DESC";
                break;
            case "5":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ORDER BY")) + "ORDER BY eTVOC DESC";
                break;
        }

        if (this.value != "") {
            document.getElementById('order').classList.remove('hidden');
        } else {
            document.getElementById('order').classList.add('hidden');
        }

        load_data();
    });

    $("#order").on("change", function() {
        offset = -1;
        $('#table_body table > tbody').empty();

        switch (this.value) {
            case "0":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("ASC")) + "DESC";
                break;
            case "1":
                document.getElementById('sql').textContent = document.getElementById('sql').textContent.substring(0, document.getElementById('sql').textContent.indexOf("DESC")) + "ASC";
                break;
        }

        load_data();
    });
});