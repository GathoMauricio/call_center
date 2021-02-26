require('./bootstrap');
$(document).ready(function() {
    $("#reasign_account_form").on('submit', e => {
        e.preventDefault();
        $.ajax({
            'type': $("#reasign_account_form").prop('method'),
            'url': $("#reasign_account_form").prop('action'),
            'data': $("#reasign_account_form").serialize(),
            'success': data => {
                $("#small_operator_assigned_" + data.assignment_id).text('Asignado a: ' + data.operator);
                $("#reasign_account_modal").modal('hide');
                alert(data.message);
            },
            error: err => console.log(err)
        });
    });
    $("#form_store_account_follow").on('submit', e => {
        e.preventDefault();
        const body = $("#txt_body_account_follow").val();
        if (body.length > 0) {
            $.ajax({
                type: "POST",
                url: $("#form_store_account_follow").prop('action'),
                data: $("#form_store_account_follow").serialize(),
                success: data => {
                    $("#followBox").html('');
                    let html = ``;
                    let counter = 0;
                    $.each(data, (index, item) => {
                        counter++;
                        html += `
                        <div class="comment-item">
                            <label class="font-weight-bold">
                                ${item.user}
                            </label>
                            <br>
                            <small class="font-weight-bold" style="color: #5499C7">${item.codification}</small>
                            <br>
                                ${item.body}
                            <br>
                            <span class="font-weight-bold float-right">
                                ${item.date}
                            </span>
                            <br>
                        </div><br>
                        `;
                    });
                    $("#followBox").html(html);
                    $("#followBox").animate({ scrollTop: $(document).height() * 10000 },
                        500
                    );
                    $("#txt_body_account_follow").val('');
                    const id = $("#txt_account_follow_store").val();
                    $("#span_count_follows_" + id).text(counter);
                },
                error: err => console.log(err)
            });
        }
    });
});

window.openAccountFollows = account_id => {
    const url = $("#txt_index_account_follow").val();
    $("#txt_account_follow_store").val(account_id);
    $.ajax({
        type: 'GET',
        url: url,
        data: { account_id: account_id },
        success: data => {
            let html = ``;
            $.each(data, (index, item) => {
                html += `
                <div class="comment-item">
                    <label class="font-weight-bold">
                        ${item.user}
                    </label>
                    <br>
                    <small class="font-weight-bold" style="color: #5499C7">${item.codification}</small>
                    <br>
                        ${item.body}
                    <br>
                    <span class="font-weight-bold float-right">
                        ${item.date}
                    </span>
                    <br>
                </div><br>
                `;
            });
            $("#followBox").html(html);
            $("#followBox").animate({ scrollTop: $(document).height() * 10000 },
                500
            );
            $("#account_follow_modal").modal();
        },
        error: err => {
            console.log(err);
        }
    });
}
window.deleteSale = sale_id => {
    if (confirm("Eliminar registro")) {
        window.location = $("#txt_delete_sale_route").val() +
            '/' + sale_id +
            '/?_method=DELETE&_token=' +
            $("meta[name=csrf-token]").prop('content');
    }
};
window.deleteUser = user_id => {
    if (confirm("ALTO: Si elimina por completo al usuario se eliminarán las cuentas asignadas a este también, le recomendamos editar al usuario para reasignar las cuentas a otros operadores y solo desactivar el acceso al usuario.\n¿Realmente desea eliminar el registro por completo?")) {
        window.location = $("#txt_delete_user_route").val() +
            '/' + user_id +
            '/?_method=DELETE&_token=' +
            $("meta[name=csrf-token]").prop('content');
    }
};
window.archiveUser = status => {
    if (status == 'archived') {
        alert("TIP: Antes de archivar a un usuario le recomendamos reasignar las cuentas que crea convenientes de lo contrario las cuentas restantes se rapartirán entre los demás operadores.");
    }
};
window.exportTableToExcel = (tableID, filename = '') => {
    let downloadLink;
    let dataType = 'application/vnd.ms-excel';
    let tableSelect = document.getElementById(tableID);
    let tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    filename = filename ? filename + '.xls' : 'excel_data.xls';
    downloadLink = document.createElement("a");
    document.body.appendChild(downloadLink);
    if (navigator.msSaveOrOpenBlob) {
        let blob = new Blob(['ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
        downloadLink.download = filename;
        downloadLink.click();
    }
}

window.showTblTotalRegisters = () => {
    $("#tablesTotalRegisters").css('display', 'block');
    $("#tablesNewRegisters").css('display', 'none');
    $("#tablesRepitedRegisters").css('display', 'none');
    $("#tablesAssignedRegisters").css('display', 'none');
};
window.showTblNewRegisters = () => {
    $("#tablesTotalRegisters").css('display', 'none');
    $("#tablesNewRegisters").css('display', 'block');
    $("#tablesRepitedRegisters").css('display', 'none');
    $("#tablesAssignedRegisters").css('display', 'none');
};
window.showTblRepitedRegisters = () => {
    $("#tablesTotalRegisters").css('display', 'none');
    $("#tablesNewRegisters").css('display', 'none');
    $("#tablesRepitedRegisters").css('display', 'block');
    $("#tablesAssignedRegisters").css('display', 'none');
};
window.showTblAssignedRegisters = () => {
    $("#tablesTotalRegisters").css('display', 'none');
    $("#tablesNewRegisters").css('display', 'none');
    $("#tablesRepitedRegisters").css('display', 'none');
    $("#tablesAssignedRegisters").css('display', 'block');
};
window.reasignAccount = assignment_id => {
    const route = $("#txt_reasign_edit_route").val();
    $.ajax({
        'type': 'GET',
        'url': route,
        'data': {
            assignment_id: assignment_id
        },
        success: data => {
            let options = ``;
            $.each(data.operators, (index, operator) => {
                if (data.actual_user_id == operator.id) {
                    options += `<option value="${ operator.id }" selected>${ operator.name } ${ operator.middle_name } ${ operator.last_name }</option>`;
                } else {
                    options += `<option value="${ operator.id }">${ operator.name } ${ operator.middle_name } ${ operator.last_name }</option>`;
                }
            });
            //cbo_reasign_account_user
            $("#txt_reasign_edit_id").val(data.assignment_id);
            $("#cbo_reasign_account_user").html(options);
            $("#reasign_account_modal").modal();
        },
        error: err => console.log(err)
    });
};