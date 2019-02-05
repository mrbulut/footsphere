
function openForm(urunid, boyut) {



    document.getElementById("hiddenValueEdit").value = urunid;
    document.getElementById("editForm").style.display = "block";
    document.getElementById("dashboard-widgets").style.display = "none";
    document.getElementById("deleteForm").style.display = "none";
    document.getElementById("openClick").style.display = "none";
    document.getElementById("wpfooter").style.display = "none";

    formDoldurEdit(urunid, boyut);
    


}
function newForm(urunid, kAdi) {

    setCookie("messageUserID", urunid);

    document.getElementById("teklifBaslik").innerHTML = kAdi;
    document.getElementById("hiddenValueNew").value = urunid;
    document.getElementById("newForm").style.display = "block";
    document.getElementById("dashboard-widgets").style.display = "none";
    document.getElementById("deleteForm").style.display = "none";
    document.getElementById("openClick").style.display = "none";
    document.getElementById("wpfooter").style.display = "none";



}

function openClick(id, boyut) {

    document.getElementById("istekNo").value = boyut;
    document.getElementById("hiddenValueRequestID").value = boyut;

    document.getElementById("wpfooter").style.display = "none";


    document.getElementById("newForm").style.display = "block";

    document.getElementById("hiddenValueNew").value = id;
    document.getElementById("openClick").style.display = "block";
    document.getElementById("editForm").style.display = "none";
    document.getElementById("dashboard-widgets").style.display = "none";
    document.getElementById("deleteForm").style.display = "none";

}

function closeForm() {
    document.getElementById("dashboard-widgets").style.display = "block";
    document.getElementById("editForm").style.display = "none";
    document.getElementById("deleteForm").style.display = "none";
    document.getElementById("openClick").style.display = "none";
    document.getElementById("newForm").style.display = "none";
    document.getElementById("wpfooter").style.display = "none";


}

function deleteForm(urunid, boyut) {

    document.getElementById("hiddenValueDelete").value = urunid;
    document.getElementById("deleteForm").style.display = "block";
    document.getElementById("dashboard-widgets").style.display = "none";
    document.getElementById("editForm").style.display = "none";
    document.getElementById("openClick").style.display = "none";
    document.getElementById("wpfooter").style.display = "none";

    formDoldurDelete(urunid, boyut);

}

function formDoldurDelete(urunid, boyut) {

    var i = 0;

    for (i = 3; i < boyut - 1; i++) {

        document.getElementById((i - 2) + "_rows_D").value = document.getElementById(urunid + "_" + i).innerHTML;


    }

}

function formDoldurEdit(urunid, boyut) {

    var i = 0;

    for (i = 3; i < boyut - 1; i++) {

        document.getElementById((i - 2) + "_rows").value = document.getElementById(urunid + "_" + i).innerHTML;


    }

}
function setCookie(name, value) {

    var expires;
    var date = new Date();
    date.setTime(date.getTime() + (3330));
    expires = expires + date.toGMTString();
    document.cookie = name + "=" + value + expires + "; path=/";
}



