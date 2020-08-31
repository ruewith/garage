$(document).ready(function() {
    new WOW().init();

    let firstname = document.getElementById("client_firstname");
    let lastname = document.getElementById("client_lastname");
    let phone = document.getElementById("client_phone");
    let mileage = document.getElementById("mileage");

    if (firstname) {
        let firstnameMask = new IMask(firstname, {
            mask: /^([а-яё]+|[А-ЯЁ]+)$/i
        });
    }
    if (lastname) {
        let lastnameMask = new IMask(lastname, {
            mask: /^([а-яё]+|[А-ЯЁ]+)$/i
        });
    }

    if (phone) {
        let phoneMask = new IMask(phone, {
            mask: "+{7}(000)000-00-00"
        });
    }

    if (mileage) {
        let mileageMask = new IMask(mileage, {
            mask: Number,
            min: 0,
            max: 1000000,
        });
    }
});
