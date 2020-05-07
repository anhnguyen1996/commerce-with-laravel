$(document).ready(function () {

    $("#add-product-form").submit(function () {
        var productName = $('#product-name');
        var link = $('#product-link');
        var productPrice = $('#product-price');
        var productSalePrice = $('#product-sale-price');
        var inventoryQuantity = $('#inventory-quantity');
        var productCategory = $('#product-category');
        var productBrand = $('#product-brand');
        var productStatus = $('#product-status');
        var productPriority = $('#product-priority');
        var files = $('#fileInput')[0].files[0];
        
        //Non check CKEDITOR value
        var descriptionValue = CKEDITOR.instances.description.getData();
        var contentValue = CKEDITOR.instances.content.getData();

        console.log('Description:' + descriptionValue);
        console.log('Content:' + contentValue);

        var productNameInputCheck = new InputCheck(productName, 'name');
        var linkInputCheck = new InputCheck(link, 'link');
        var productPriceInputCheck = new InputCheck(productPrice, 'price');
        var productSalePriceInputCheck = new InputCheck(productSalePrice, 'price');
        var inventoryQuantityInputCheck = new InputCheck(inventoryQuantity, 'inventory');
        var productCategoryInputCheck = new InputCheck(productCategory, 'type_id');
        var productBrandInputCheck = new InputCheck(productBrand, 'type_id');
        var productStatusInputCheck = new InputCheck(productStatus, 'type_id');
        var productPriorityInputCheck = new InputCheck(productPriority, 'type_id');

        productNameInputCheck.publicSetErrorMessage('productName error');
        linkInputCheck.publicSetErrorMessage('link');
        productPriceInputCheck.publicSetErrorMessage('price');
        productSalePriceInputCheck.publicSetErrorMessage('price');
        inventoryQuantityInputCheck.publicSetErrorMessage('inventory');
        productCategoryInputCheck.publicSetErrorMessage('category');
        productBrandInputCheck.publicSetErrorMessage('brand');
        productStatusInputCheck.publicSetErrorMessage('status');
        productPriorityInputCheck.publicSetErrorMessage('priority');

        var inputCheckArray = [
            productNameInputCheck,
            linkInputCheck,
            productPriceInputCheck,
            productSalePriceInputCheck,
            inventoryQuantityInputCheck,
            productCategoryInputCheck,
            productBrandInputCheck,
            productStatusInputCheck,
            productPriorityInputCheck
        ];

        var validForm = false;
        validForm = checkValidForm(inputCheckArray);

        if (validForm == true) {
            var formData = new FormData();                        
            formData.append('productName', productName.val());
            formData.append('link', link.val());
            formData.append('fileInput',files);
            formData.append('productPrice', productPrice.val());
            formData.append('productSalePrice', productSalePrice.val());
            formData.append('inventoryQuantity', inventoryQuantity.val());
            formData.append('productCategory', productCategory.val());
            formData.append('productBrand', productBrand.val());
            formData.append('productStatus', productStatus.val());
            formData.append('productPriority', productPriority.val());
            formData.append('description', descriptionValue);
            formData.append('content', contentValue);

            $.ajax({
                url: window.location.protocol + '//' + window.location.hostname + '/admin/product/insert',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (rs) {
                    console.log('AJAX:' + rs);
                    if (rs == '1') {
                        alert('Them thanh cong');
                        window.location.href = window.location.protocol +
                            '//' + window.location.hostname + '/admin/product';
                    } else {
                        alert('Them that bai');
                    }
                },
                error: function (e) {
                    console.log(e.status + " - " + e.statusText);
                    //$(".content-grids").html(e.responseText);
                }

            });
        }
        return false;
    });

    $("#update-product-form").submit(function () {
        var id = $('#product-id');
        var productName = $('#product-name');
        var link = $('#product-link');
        var productPrice = $('#product-price');
        var productSalePrice = $('#product-sale-price');
        var inventoryQuantity = $('#inventory-quantity');
        var productCategory = $('#product-category');
        var productBrand = $('#product-brand');
        var productStatus = $('#product-status');
        var productPriority = $('#product-priority');
        var files = $('#fileInput')[0].files[0];

        //Non check CKEDITOR value
        var descriptionValue = CKEDITOR.instances.description.getData();
        var contentValue = CKEDITOR.instances.content.getData();

        console.log('Description:' + descriptionValue);
        console.log('Content:' + contentValue);

        var productNameInputCheck = new InputCheck(productName, 'name');
        var linkInputCheck = new InputCheck(link, 'link');
        var productPriceInputCheck = new InputCheck(productPrice, 'price');
        var productSalePriceInputCheck = new InputCheck(productSalePrice, 'price');
        var inventoryQuantityInputCheck = new InputCheck(inventoryQuantity, 'inventory');
        var productCategoryInputCheck = new InputCheck(productCategory, 'type_id');
        var productBrandInputCheck = new InputCheck(productBrand, 'type_id');
        var productStatusInputCheck = new InputCheck(productStatus, 'type_id');
        var productPriorityInputCheck = new InputCheck(productPriority, 'type_id');

        productNameInputCheck.publicSetErrorMessage('productName error');
        linkInputCheck.publicSetErrorMessage('link');
        productPriceInputCheck.publicSetErrorMessage('price');
        productSalePriceInputCheck.publicSetErrorMessage('price');
        inventoryQuantityInputCheck.publicSetErrorMessage('inventory');
        productCategoryInputCheck.publicSetErrorMessage('category');
        productBrandInputCheck.publicSetErrorMessage('brand');
        productStatusInputCheck.publicSetErrorMessage('status');
        productPriorityInputCheck.publicSetErrorMessage('priority');

        var inputCheckArray = [
            productNameInputCheck,
            linkInputCheck,
            productPriceInputCheck,
            productSalePriceInputCheck,
            inventoryQuantityInputCheck,
            productCategoryInputCheck,
            productBrandInputCheck,
            productStatusInputCheck,
            productPriorityInputCheck
        ];

        var validForm = false;
        validForm = checkValidForm(inputCheckArray);

        if (validForm == true) {
            var formData = new FormData();
            formData.append('id', id.val());                     
            formData.append('productName', productName.val());
            formData.append('link', link.val());
            formData.append('fileInput',files);
            formData.append('productPrice', productPrice.val());
            formData.append('productSalePrice', productSalePrice.val());
            formData.append('inventoryQuantity', inventoryQuantity.val());
            formData.append('productCategory', productCategory.val());
            formData.append('productBrand', productBrand.val());
            formData.append('productStatus', productStatus.val());
            formData.append('productPriority', productPriority.val());
            formData.append('description', descriptionValue);
            formData.append('content', contentValue);
            $.ajax({
                url: window.location.protocol + '//' + window.location.hostname + '/admin/product/update',
                data: formData,
                type: 'POST',
                contentType: false,
                processData: false,
                success: function (rs) {
                    console.log('AJAX:' + rs);
                    if (rs == '1') {
                        alert('Sửa đổi thành công');
                        window.location.href = window.location.protocol +
                            '//' + window.location.hostname + '/admin/product';
                    } else {
                        alert('Sửa đổi thất bại');
                    }
                },
                error: function (e) {
                    console.log(e.status + " - " + e.statusText);
                    //$(".content-grids").html(e.responseText);
                }

            });
        }
        return false;
    });

    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
});