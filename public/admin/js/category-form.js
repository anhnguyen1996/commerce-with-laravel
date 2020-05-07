$(document).ready(function () {
    $("#category-describes").change(function() {
        convertStringToLink($('#category-describes'));
    });

    $("#create-category-form").submit(function () {
        var categoryDescribes = $('#category-describes');
        var categoryName = $('#category-name');        
        var categoryPriority = $('#category-priority');
        
        var categoryDescribesInputCheck = new InputCheck(categoryDescribes, 'name');
        var categoryNameInputCheck = new InputCheck(categoryName, 'link');
        var categoryPriorityInputCheck = new InputCheck(categoryPriority, 'type_id');        
        
        categoryDescribesInputCheck.publicSetErrorMessage('Tên danh mục hợp lệ bao gồm các ký tự chữ và ký tự số!');
        categoryNameInputCheck.publicSetErrorMessage('Đường link không hợp lệ!');
        categoryPriorityInputCheck.publicSetErrorMessage('Độ ưu tiên không hợp lệ!')        
        
        var inputCheckArray = [
            categoryDescribesInputCheck,
            categoryNameInputCheck,
            categoryPriorityInputCheck
        ];

        var validForm = false;
        validForm = checkValidForm(inputCheckArray);              
        if (validForm == true) {
            // var formData = new FormData();                        
            // formData.append('categoryName', categoryName.val());
            // formData.append('categoryDescribes', categoryDescribes.val());
            // formData.append('categoryPriority', categoryPriority.val());            

            // $.ajax({
            //     url: window.location.protocol + '//' + window.location.hostname + '/admin/category/create',
            //     data: formData,
            //     type: 'POST',
            //     contentType: false,
            //     processData: false,
            //     success: function (rs) {
            //         console.log('AJAX:' + rs);
            //         if (rs == '1') {
            //             alert('Them thanh cong');
            //             window.location.href = window.location.protocol +
            //                 '//' + window.location.hostname + '/admin/category';
            //         } else {
            //             alert('Them that bai');
            //         }
            //     },
            //     error: function (e) {
            //         console.log(e.status + " - " + e.statusText);
            //         //$(".content-grids").html(e.responseText);
            //     }

            // });
            return true;
        }
        return false;
    });

    $("#edit-category-form").submit(function () {
        var categoryDescribes = $('#category-describes');
        var categoryName = $('#category-name');        
        var categoryPriority = $('#category-priority');
        
        var categoryDescribesInputCheck = new InputCheck(categoryDescribes, 'name');
        var categoryNameInputCheck = new InputCheck(categoryName, 'link');
        var categoryPriorityInputCheck = new InputCheck(categoryPriority, 'type_id');        
        
        categoryDescribesInputCheck.publicSetErrorMessage('Tên danh mục hợp lệ bao gồm các ký tự chữ và ký tự số!');
        categoryNameInputCheck.publicSetErrorMessage('Đường link không hợp lệ!');
        categoryPriorityInputCheck.publicSetErrorMessage('Độ ưu tiên không hợp lệ!')        
        
        var inputCheckArray = [
            categoryDescribesInputCheck,
            categoryNameInputCheck,
            categoryPriorityInputCheck
        ];

        var validForm = false;
        validForm = checkValidForm(inputCheckArray);              
        if (validForm == true) {            
            return true;
        }
        return false;
    });

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    
});