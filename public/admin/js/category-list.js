function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function jsonToListHtml(json, token = null) {    
    var categoryArray = json['categories'];
    var priorityArray = json['priorities'];    
    categoryArray = JSON.parse(categoryArray);
    priorityArray = JSON.parse(priorityArray);        
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
        categoryHtml += '<td>' + (i + 1) +'</td>';
        categoryHtml += '<td>' + category.describes +'</td>';
        categoryHtml += '<td>' + category.name +'</td>';    
        categoryHtml += '<td>' + priorityDescribes +'</td>';
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
                        '<input type="hidden" name="_method" value="DELETE">' +
                        '<input type="hidden" name="_token" value="' + token + '">' +
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
                var token = $('[name="_token"]').val();
                console.log(result);                
                $('#category-table-tbody').empty();
                $('#category-table-tbody').append(jsonToListHtml(result, token));                
            },
            error: function (error) {
                console.log('error');
            }
        });
    });
});

