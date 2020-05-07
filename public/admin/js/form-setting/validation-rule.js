class ValidationRule {

    protectedCheckInput(type, value) {
        console.log('before'+value);
        var valid = false;
        var pattern = null;
        switch (type) {
            case 'name':
                pattern = /^[a-zA-Z][a-zA-Z0-9\ ]+$/g;
                if (value.search(pattern) == 0) {
                    valid = true;
                }
                break;
            case 'link':
                pattern = /^[^\W_]+(\-[^\W_]+)*$/g;
                if (value.search(pattern) == 0) {
                    valid = true;
                }
                break;
            case 'price':
                pattern = /^[1-2]?[0-9]{1,9}$/g;
                if (value.search(pattern) == 0) {
                    valid = true;
                }
                break;
            case 'inventory':
                pattern = /^[1-2]?[0-9]{1,9}$/g;
                if (value.search(pattern) == 0) {
                    valid = true;
                }
                break;
            case 'type_id':
                pattern = /^[1-2]?[0-9]{1,9}$/g;
                if (value.search(pattern) == 0) {
                    valid = true;
                }
                break;
            default:
                valid = false;
                break;
        }
        console.log('checkInputValue:' + value);
        console.log('checkInputValid:' + valid);
        return valid;
    }
}