function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function jsonToListHtml(json, token = null) {
    var categoryArray = json['categories'];
    var priorityArray = json['priorities'];
    var page = json['page'];        
    categoryArray = JSON.parse(categoryArray);
    priorityArray = JSON.parse(priorityArray);
    page = JSON.parse(page);    
    var categoryArrayLength = categoryArray.length;
    var priorityArrayLength = priorityArray.length;
    var html = '';    
    for (var i = 0; i < categoryArrayLength; i++) {
        var category = categoryArray[i];

        var priorityDescribes = null;
        for (var j = 0; j < priorityArrayLength; j++) {
            if (priorityArray[j].id == category.priority_id) {
                priorityDescribes = priorityArray[j].describes;
            }
        }        
        var categoryHtml = '<tr>';
        categoryHtml += '<td>' + (i + 1) + '</td>';
        categoryHtml += '<td>' + category.describes + '</td>';
        categoryHtml += '<td>' + category.name + '</td>';
        categoryHtml += '<td>' + priorityDescribes + '</td>';

        if (category.parent_describes == null) {
            category.parent_describes = '';
        }
        categoryHtml += '<td>' + category.parent_describes + '</td>';
        
        var visible = null;
        if (category.visible == true) {
            visible = 'Hiện';
        } else {
            visible = 'Ẩn';
        }
        categoryHtml += '<td>' + visible + '</td>';

        categoryHtml +=
            '<td><div class="dropdown">' +
            '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">' +
            'Thay đổi' +
            '</button>' +
            '<div class="dropdown-menu">' +
            '<a class="dropdown-item" href="http://localhost/admin/category/' + category.id + '/edit">' +
            '<i class="far fa-edit" aria-hidden="true"></i> Sửa' +
            '</a>' +
            '<form id="delete-id-' + category.id + '" action="http://localhost/admin/category/' + category.id + '" method="POST">' +
            '<input type="hidden" name="_method" value="DELETE">' +
            '<input type="hidden" name="_token" value="' + token + '">' +
            '<a class="dropdown-item" onclick="document.getElementById(' + '\'delete-id-' + category.id + '\').submit()">' +
            '<i class="fa fa-times" aria-hidden="true"></i> Xóa</a>' +
            '</form>' +
            '</div>' +
            '</div></td>';
        categoryHtml += '</tr>';
        html += categoryHtml;
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
            + '/admin/category/sort/' + sortListValue + '/' + orderListValue,
        data: formData,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function (result) {
            console.log(result);           
            var csrf_token = $('meta[name="csrf-token"]').attr('content');
            $('#category-table-tbody').empty();            
            $('#category-table-tbody').append(jsonToListHtml(result, csrf_token));
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
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/category/search/' + searchTextValue;
    });
    $("#search-text").keyup(function(e) {
        if (e.key == "Enter") {
            var searchTextValue = $("#search-text").val();
            window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/category/search/' + searchTextValue;
        }
    });

    $("#delete-search").click(function() {
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/admin/category/search/';
    });
});

