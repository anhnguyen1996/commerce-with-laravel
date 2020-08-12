$(document).ready(function () {
    $("#product-name").keyup(function() {
        var link = convertStringToLink($('#product-name'));        
        $('#product-alias').val(link);
    });
    
    $("#product-form").submit(function () {        
        var productName = $('#product-name');
        var link = $('#product-alias');
        var productPrice = $('#product-price');
        var productSalePrice = $('#product-sale-price');
        var inventoryQuantity = $('#inventory-quantity');
        var productCategory = $('#product-category');
        //var productBrand = $('#product-brand');
        var productStatus = $('#product-status');
        var productPriority = $('#product-priority');
        //var files = $('#product-image')[0].files[0];
        
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
        //var productBrandInputCheck = new InputCheck(productBrand, 'type_id');
        var productStatusInputCheck = new InputCheck(productStatus, 'type_id');
        var productPriorityInputCheck = new InputCheck(productPriority, 'type_id');

        productNameInputCheck.publicSetErrorMessage('productName error');
        linkInputCheck.publicSetErrorMessage('link');
        productPriceInputCheck.publicSetErrorMessage('price');
        productSalePriceInputCheck.publicSetErrorMessage('price');
        inventoryQuantityInputCheck.publicSetErrorMessage('inventory');
        productCategoryInputCheck.publicSetErrorMessage('category');
        //productBrandInputCheck.publicSetErrorMessage('brand');
        productStatusInputCheck.publicSetErrorMessage('status');
        productPriorityInputCheck.publicSetErrorMessage('priority');

        var inputCheckArray = [
            productNameInputCheck,
            linkInputCheck,
            productPriceInputCheck,
            productSalePriceInputCheck,
            inventoryQuantityInputCheck,
            productCategoryInputCheck,
            //productBrandInputCheck,
            productStatusInputCheck,
            productPriorityInputCheck
        ];

        var validForm = false;        
        validForm = checkValidForm(inputCheckArray);

        return validForm;
    });

    $("#button-add-sub-image").click(function() {
        var html = $("#sub-image-pattern").html();        
        $(".sub-image-insert").last().after(html); 
    });  
});

function deleteSubImage(imageId) {
    $.ajax({
        url: window.location.protocol + '//' + window.location.hostname + '/admin/product/sub-image/' + imageId + '/delete',
        data: null,
        type: 'GET',        
        success: function (rs) {
            if (rs == true) {
                $('#sub-image-' + imageId).remove();               
                alert("Xóa thành công!");
            } else {
                alert("Xóa thất bại!");
            }
        },
        error: function (e) {
            console.log(e.status + " - " + e.statusText);            
        }
    });
}