
// Jquery Datatable
let jquery_datatable = $("#datatable").DataTable({
    responsive: true,
    "order": [[ 0, "DESC" ]]
});


//DISABLE REQUEST
function onDisableButtonClick(id, status) {
    let data = {
        id: id,
        status: status,
        message: status == 1 ? 'Product has been activated successfully!' :
            'Product has been inactivated successfully!'
    }
    config.messages.confirm(disableProduct, data)
}



function disableProduct(data) {
    config.loader.show();
    var formData = new FormData();
    formData.append("id", data.id);
    formData.append("status", data.status);
    formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
    $.ajax({
        url: config.routes.product.status.replace('ID', data.id),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            config.loader.hide();
            config.messages.success(data.message);
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        },
        error: function (response, error) {
            config.loader.hide();
            config.messages.error(config.func.customError(response));
        }
    });
}

//REQUEST FOR PRODUCT
function onRequestButtonClick(id, name, stock) {
    Swal.fire({
        title: 'Request Details',
        html: `<p class="text-start ps-3 small ms-1">There is only ` + stock + " " + name + ` items left in stock.</p>
                <input type="number" id="quantity" class="swal2-input w-75" placeholder="Quantity">
                <textarea id="note" class="swal2-input w-75" placeholder="Note"></textarea>`,
        confirmButtonText: 'Submit',
        focusConfirm: false,
        customClass: {
            title: 'text-muted text-start ps-5',
            htmlContainer: 'mt-0',
        },
        showCancelButton: true,
        preConfirm: () => {
            const quantity = Swal.getPopup().querySelector('#quantity').value
            const description = Swal.getPopup().querySelector('#note').value
            if (!quantity || quantity < 1) {
                Swal.showValidationMessage(`Qauntity is required.`)
            }
            return {
                quantity: quantity,
                description: description
            }
        }
    }).then((result) => {
        if (result.isDismissed) return false;
        config.loader.show();
        var formData = new FormData();
        formData.append("product_id", id);
        formData.append("quantity", result.value.quantity);
        formData.append("note", result.value.description);
        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: config.routes.transactions.request,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                config.loader.hide();
                config.messages.success('Your request has been created successfully.');
                setTimeout(() => {
                    window.location.href = config.routes.transactions.request;
                }, 1500);
            },
            error: function (response, error) {
                config.loader.hide();
                config.messages.error(config.func.customError(response));
            }
        });
    })
}


//GRANT PRODUCT
function onGrantButtonClick(id, name, stock) {
    Swal.fire({
        title: 'Grant Details',
        html: `<p class="text-start ps-3 small ms-1">There is only ` + stock + " " + name + ` items left in stock.</p>
        <input type="number" id="quantity" class="swal2-input w-75" placeholder="Quantity">
        <input type="text" id="recipient" class="swal2-input w-75" placeholder="Recipient">
        <textarea id="note" class="swal2-input w-75" placeholder="Note"></textarea>`,
        confirmButtonText: 'Submit',
        focusConfirm: false,
        customClass: {
            title: 'text-muted text-start ps-5',
            htmlContainer: 'mt-0',
        },
        showCancelButton: true,
        preConfirm: () => {
            const quantity = Swal.getPopup().querySelector('#quantity').value
            const recipient = Swal.getPopup().querySelector('#recipient').value
            const description = Swal.getPopup().querySelector('#note').value
            if (!quantity) {
                Swal.showValidationMessage(`Qauntity is required.`)
            }
            if (quantity > stock) {
                Swal.showValidationMessage(`There is only ` + stock + ` items left in stock.`)
            }
            if (!recipient.length) {
                Swal.showValidationMessage(`Recipient field is required.`)
            }
            return {
                quantity: quantity,
                recipient: recipient,
                description: description
            }
        }
    }).then((result) => {
        if (result.isDismissed) return false;
        config.loader.show();
        var formData = new FormData();
        formData.append("product_id", id);
        formData.append("quantity", result.value.quantity);
        formData.append("recipient", result.value.recipient);
        formData.append("note", result.value.description);
        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: config.routes.transactions.grant,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                config.loader.hide();
                config.messages.success('Your grant has been created successfully.');
                setTimeout(() => {
                    window.location.href = config.routes.transactions.grant;
                }, 1500);
            },
            error: function (response, error) {
                config.loader.hide();
                config.messages.error(config.func.customError(response));
            }
        });
    })
}