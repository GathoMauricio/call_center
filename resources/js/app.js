require('./bootstrap');
window.deleteSale = sale_id => {
    if(confirm("Eliminar registro")){
        window.location = $("#txt_delete_sale_route").val()
        +'/'+sale_id
        +'/?_method=DELETE&_token='
        +$("meta[name=csrf-token]").prop('content');
    }
};