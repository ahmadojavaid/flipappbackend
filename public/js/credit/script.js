$(function() {

    var owner = $('#owner');
    var cardNumber = $('#cardNumber');
    var cardNumberField = $('#card-number-field');
    var CVV = $("#cvv");
    var mastercard = $("#mastercard");
    var confirmButton = $('#confirm-purchase');
    var visa = $("#visa");
    var amex = $("#amex");

    // Use the payform library to format and validate
    // the payment fields.

    cardNumber.payform('formatCardNumber');
    CVV.payform('formatCardCVC');


    cardNumber.keyup(function() {

        amex.removeClass('transparent');
        visa.removeClass('transparent');
        mastercard.removeClass('transparent');

        if ($.payform.validateCardNumber(cardNumber.val()) == false) {
            cardNumberField.addClass('has-error');
        } else {
            cardNumberField.removeClass('has-error');
            cardNumberField.addClass('has-success');
        }

        if ($.payform.parseCardType(cardNumber.val()) == 'visa') {
            mastercard.addClass('transparent');
            amex.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'amex') {
            mastercard.addClass('transparent');
            visa.addClass('transparent');
        } else if ($.payform.parseCardType(cardNumber.val()) == 'mastercard') {
            amex.addClass('transparent');
            visa.addClass('transparent');
        }
    });

    confirmButton.click(function(e) {

        e.preventDefault();

        var isCardValid = $.payform.validateCardNumber(cardNumber.val());
        var isCvvValid = $.payform.validateCardCVC(CVV.val());

         if(owner.val().length < 5){
            Swal.fire({
            title: 'Please Enter the Owner Name (minmum character is 5 )',
            text: '',
            type: 'warning', 
            cancelButtonText: 'Ok',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
          });
        } else if (!isCardValid) {
            Swal.fire({
            title: 'Wrong Card Number.',
            text: '',
            type: 'warning', 
            cancelButtonText: 'Ok',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
          });
        } else if (!isCvvValid) {
            Swal.fire({
            title: 'Please Enter CVV and minimum length is 3',
            text: '',
            type: 'warning', 
            cancelButtonText: 'Ok',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
          });
        } else {
            $("#fomr_s").submit();
        }
    });
});
