require('./bootstrap');
$(document).ready(function() {
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
    if (confirm("Eliminar registro")) {
        window.location = $("#txt_delete_user_route").val() +
            '/' + user_id +
            '/?_method=DELETE&_token=' +
            $("meta[name=csrf-token]").prop('content');
    }
};