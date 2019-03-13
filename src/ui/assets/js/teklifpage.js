
/*
document.addEventListener("DOMContentLoaded", function (event) {
    var _selector = document.querySelector('input[name=checkBox]');
    _selector.addEventListener('change', function (event) {
        if (_selector.checked) {
            alert("asdasd");
        } else {
            alert("asdasd");
        }
    });
});
*/


var gecmisTeklifler = document.getElementById("hiddenTeklifArray").value;
var res = gecmisTeklifler.split(",");
for (let index = 0; index < res.length; index++) {
    var urunid = res[index].split(":")[0];
    var fiyat = res[index].split(":")[1];
    document.getElementById(urunid + "_checkBox").checked=true;
}

function onClickHandler(id) {
    var checkboxValu = document.getElementById(id + "_checkBox").checked;
    
    if (checkboxValu) {
        var person = prompt("Lütfen fiyatı giriniz.", "");
        if (person == null || person == "") {

        } else {
            document.getElementById(id + "_input").value = person;
            document.getElementById("product-" + id).style.backgroundColor = "lightGreen";
            hiddenValueEkle(id,person);
          
        }
    } else {
        document.getElementById("product-" + id).style.backgroundColor = "white";
        var fiyat = document.getElementById(id + "_input").value ;
        document.getElementById(id + "_checkBox").checked=false;
        document.getElementById(id + "_input").value = null;
        hiddenValueCikar(id,fiyat);
    }
    //use this value
}


function hiddenValueEkle(urunid,fiyat){
    document.getElementById("hiddenTeklifArray").value = document.getElementById("hiddenTeklifArray").value +urunid +":"+fiyat+",";
}

function hiddenValueCikar(urunid,fiyat){
    var $result="";
    var urun = urunid+":"+fiyat;
    var res = document.getElementById("hiddenTeklifArray").value.split(",");
    for (let index = 0; index < res.length; index++) {
        if(res[index]==urun){
            
        }else{
            if(res[index]!="")
            $result = $result + res[index] + ",";
        }
    }
    document.getElementById("hiddenTeklifArray").value  = $result ;
}



