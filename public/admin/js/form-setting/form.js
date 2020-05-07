class InputCheck extends ValidationRule {

    constructor(inputElement, checkType) {
        super();
        this.inputElement = inputElement;
        this.checkType = checkType;
        this.errorMessage = '';
        this.valid = false;
    }

    publicSetErrorMessage(errorMessage) {
        this.errorMessage = errorMessage;
    }

    publicCheckValid() {
        /*
        Tránh việc check giá trị có dấu khiến trả về kể quả sai ví dụ tên: Sản phẩm A1 => false
        Nên phải chuyển chuỗi có dấu thành chuỗi không dấu trước khi check
        */
        var inputValue = this.inputElement.val();
        console.log('value:' + inputValue);
        if (typeof inputValue == 'string' && this.checkType != 'link') {
            inputValue = changeToNormalString(inputValue);
        }

        this.valid = super.protectedCheckInput(this.checkType, inputValue);
        return this.valid;
    }

    publicDisplayError() {
        if (this.valid == false) {
            var parentElement = this.inputElement.parent();
            
            //parentElement.find('.alert').remove();
            parentElement.append(
                '<div class="alert alert-danger alert-dismissible fade show">'
                + '<button type="button" class="close" data-dismiss="alert">&times;</button>'
                + '<strong>Lỗi!</strong> '
                + this.errorMessage
                + '</div>'
            );
        }
    }
}

function checkValidForm(inputCheckArray) {

    var validForm = false;
    var inputCheckArrayLength = inputCheckArray.length;
    var countValid = 0;
    for (var i = 0; i < inputCheckArrayLength; i++) {
        inputCheckArray[i].inputElement.parent().find('.alert').remove();
        if (inputCheckArray[i].publicCheckValid() == true) {
            countValid++;
        } else {
            inputCheckArray[i].publicDisplayError();
        }
    }

    //if all inputCheck is true  = inputCheck Array Length
    if (countValid == inputCheckArrayLength) {
        validForm = true;
    }
    console.log('ALL VALID FLAG:' + validForm);
    return validForm;
}

function convertStringToLink(element) {   

    var value = element.val();    
    value = changeToNormalString(value);
    value = value.replace(/\ /g, '-');
    $('#product-link').val(value);
    $('#category-name').val(value);
    return value;
}

function changeToNormalString(str) {
    
    str = str.toLowerCase();
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    if (str.search(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g) != -1) {
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'|\"|\&|\#|\[|\]|~|\$|_|`|-|{|}|\||\\/g, " ");

        /*
        Biến chuỗi thành rỗng để kết quá không hợp lệ
        vì nếu khách hàng nhập nhiều ký tự đặc biệt mà chuỗi vẫn thành hợp lệ thì không hợp lý
        */
        str = "";
    }
    str = str.replace(/ + /g, " ");
    str = str.trim();
    return str;
}