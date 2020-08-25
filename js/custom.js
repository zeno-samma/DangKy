function Logout() {
    window.location.href = '/dang-xuat';
}

function Profile() {
    window.location.href = '/thong-tin-tai-khoan';
}

function EditProfile() {
    window.location.href = '/thay-doi-thong-tin';
}

function Register() {
    window.location.href = '/tao-tai-khoan';
}

function ChangeService(obj) {
    if (obj.value) {
        window.location.href = obj.value;
    }
}

function ChangeIcoinAmount(obj) {
  document.getElementById('exchangeAmount').innerHTML = obj.value;
}

function ChangeWinxuAmount(obj) {
  document.getElementById('exchangeAmount').innerHTML = obj.value * 8 / 10;
}

$(function(){
    var url = window.location.href;
    if (url.indexOf("trang-chu")>-1) {
        $('#trang-chu').attr("class", "act");
    } else {
        $('#span-trang-chu').attr("class", "nativ");
    }
    if (url.indexOf('nap-ssroll')>-1) {
        $('#nap-ssroll').attr("class", "act");
    } else {
        $('#span-nap-ssroll').attr("class", "nativ");
    }
    if (url.indexOf('doi-ssroll')>-1) {
        $('#doi-ssroll').attr("class", "act");
    } else {
        $('#span-doi-ssroll').attr("class", "nativ");
    }
    if (url.indexOf('ho-tro')>-1) {
        $('#ho-tro').attr("class", "act");
    } else {
        $('#span-ho-tro').attr("class", "nativ");
    }
    if (url.indexOf('lien-he')>-1) {
        $('#lien-he').attr("class", "act");
    } else {
        $('#span-lien-he').attr("class", "nativ");
    }
});

