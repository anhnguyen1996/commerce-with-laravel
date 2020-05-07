function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function jsonToListHtml(json) {    
    var categoryArray = json['categories'];    
    categoryArray = JSON.parse(categoryArray);    
    var categoryArrayLength = categoryArray.length;    
    var html = '';
    for (var index = 0; index < categoryArrayLength; index++) {        
        var category = categoryArray[index];
        var categoryHtml = '<tr>';
        categoryHtml += '<td>' + (index + 1) +'</td>';
        categoryHtml += '<td>' + category.describes +'</td>';
        categoryHtml += '<td>' + category.name +'</td>';
        categoryHtml += '<td>' + category.priority_id +'</td>';
        categoryHtml += 
            '<td><div class="dropdown">'+
                '<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">' +
                    'Thay đổi' +
                '</button>' +
                '<div class="dropdown-menu">' +
                    '<a class="dropdown-item" href="http://localhost/admin/category/10/edit">' +
                        '<i class="far fa-edit" aria-hidden="true"></i> Sửa' +
                    '</a>' +
                    '<form id="delete-category-form" action="http://localhost/admin/category/10" method="POST">' +
                        '<input type="hidden" name="_method" value="DELETE">                  <input type="hidden" name="_token" value="7v6C1aZw1t0rHctqx9X5NxCWPEpGjsczCVN1i0G6">' +
                        '<a class="dropdown-item" href="#" onclick="document.getElementById(\'delete-category-form\').submit()"><i class="fa fa-times" aria-hidden="true"></i> Xóa</a>' +
                    '</form>' +
                '</div>' +
            '</div></td>';
        categoryHtml += '</tr>';
        html += categoryHtml;
    }
    return html;
}

$(document).ready(function () {
    $("#sort-list").change(function () {
        var sortListValue = $("#sort-list").val();
        console.log(sortListValue);
        setCookie('sort', sortListValue, 1);
        var formData = new FormData();        
        formData.append('sort', sortListValue);
        $.ajax({
            url: window.location.protocol + '//' + window.location.hostname + '/admin/category/sort',
            data: formData,
            contentType: false,
            processData: false,
            type: 'GET',
            success: function (result) {                                
                $('#category-table-tbody').empty();
                $('#category-table-tbody').append(jsonToListHtml(result));                
            },
            error: function (error) {
                console.log('error');
            }
        });
    });
});

