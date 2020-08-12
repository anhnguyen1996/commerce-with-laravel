function jsonToListHtml(json, token = null) {    
    var html = '';

    var productJson = json['products'];
    var categoryJson = json['categories'];
    var statusJson = json['statuses'];
    var priorityJson = json['priorities'];
    var page = json['page'];

    var productRecords = JSON.parse(productJson);
    var categoryRecords = JSON.parse(categoryJson);
    var statusRecords = JSON.parse(statusJson);
    var priorityRecords = JSON.parse(priorityJson);

    var productLength = productRecords.length;    
    var categoryLength = categoryRecords.length;
    var statusLength = statusRecords.length;
    var priorityLength = priorityRecords.length;

    var productIndex = (page - 1) * 10 + 1;
    for(var i = 0; i < productLength; i++) {
        var product = productRecords[i];
        var productHtml = '<tr>';                
        productHtml += '<td>' + productIndex++ + '</td>';
        productHtml += '<td>' + product.name + '</td>';
        productHtml += '<td>' + product.alias + '</td>';
        productHtml += '<td>' + product.price + '</td>';
        productHtml += '<td>' + product.sale_price + '</td>';
        productHtml += '<td>' + product.inventory_quantity + '</td>';

        var productCategoryValue = '';
        for (var categoryPosition = 0; categoryPosition < categoryLength; categoryPosition++) {
            if (product.category_id == categoryRecords[categoryPosition].id) {
                productCategoryValue = categoryRecords[categoryPosition].describes;
            }
        }     
        productHtml += '<td>' + productCategoryValue + '</td>';        

        var productStatusValue = '';
        for (var statusPosition = 0; statusPosition < statusLength; statusPosition++) {
            if (product.product_status_id == statusRecords[statusPosition].id) {
                productStatusValue = statusRecords[statusPosition].describes;
            }
        }        
        productHtml += '<td>' + productStatusValue + '</td>';

        var productPriorityValue = '';
        for (var priorityPosition = 0; priorityPosition < priorityLength; priorityPosition++) {
            if (product.priority_id == priorityRecords[priorityPosition].id) {
                productPriorityValue = priorityRecords[priorityPosition].describes;
            }
        }
        productHtml += '<td>' + productPriorityValue + '</td>';

        productHtml +=
            '<td><div class="dropdown">' +
                '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">' +
                'Thay đổi' +
                '</button>' +
                '<div class="dropdown-menu">' +
                '<a class="dropdown-item" href="http://localhost/admin/product/' + product.id + '/edit">' +
                '<i class="far fa-edit" aria-hidden="true"></i> Sửa' +
                '</a>' +
                '<form id="delete-id-' + product.id + '" action="http://localhost/admin/product/' + product.id + '" method="POST">' +
                '<input type="hidden" name="_method" value="DELETE">' +
                '<input type="hidden" name="_token" value="' + token + '">' +
                '<a class="dropdown-item" onclick="document.getElementById(' + '\'delete-id-' + product.id + '\').submit()">' +
                '<i class="fa fa-times" aria-hidden="true"></i> Xóa</a>' +
                '</form>' +
                '</div>' +
                '</div></td>';         
        productHtml += '</tr>'
        html += productHtml;        
    }    
    return html;
}

function sortListChange() {
    var sortListValue = $("#sort-list").val();
    var orderListValue = $("#order-list").val();
    if (sortListValue != "id") {
        $('#order-form').show();
    } else {
        orderListValue = 'desc';
        $('#order-form').hide();
    }

    console.log(sortListValue);
    console.log(orderListValue);
    var formData = new FormData();
    formData.append('sort', sortListValue);
    formData.append('order', orderListValue);        
    $.ajax({
        url: window.location.protocol + '//' + window.location.hostname
            + '/admin/product/sort/' + sortListValue + '/' + orderListValue,
        data: formData,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function (result) {
            console.log(result);           
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $('#product-table-tbody').empty();            
            $('#product-table-tbody').append(jsonToListHtml(result, csrf_token));
        },
        error: function (error) {
            console.log('error');
        }
    });

}

$(document).ready(function () {
    if ($("#sort-list").val() == 'id') {
        $('#order-form').hide();
    }
           
    $("#sort-list").change(sortListChange);
    $("#order-list").change(sortListChange);

    $("#search-button").click(function () {
        var searchTextValue = $("#search-text").val();
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/product/search/' + searchTextValue;
    });
    $("#search-text").keyup(function(e) {
        if (e.key == "Enter") {
            var searchTextValue = $("#search-text").val();
            window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/product/search/' + searchTextValue;
        }
    });

    $("#delete-search").click(function() {
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/product/search/';
    });
});