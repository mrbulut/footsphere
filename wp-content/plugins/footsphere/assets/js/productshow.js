jQuery(function () {
    jQuery("#genelProductDiv").scroll(function () {
        if (jQuery("#genelProductDiv").scrollTop() + jQuery("#genelProductDiv").height() > document.getElementById("genelProductDiv").scrollHeight - 50) {
            jQuery("#loader").show();
            var id = jQuery(".liClass:last").attr('id');
            var pType = jQuery("#hiddenValuetur").val();
            var pList = jQuery("#hiddenValueProductList").val();
            var filtre = jQuery("#hiddenValueFiltre").val();
            jQuery.ajax({
                type: "POST",
                url : "/wp-content/plugins/footsphere/bespoke/implement/bespoke.php",
                data: { "count": id,"plist": pList,"ptype": pType,"filtre": filtre },
                success: function (veri) {

                    console.log(veri);
                   //jQuery(".listeleme").append(veri);
                   // jQuery("#loader").hide();

                }
            });
        }
    });


});


/*

jQuery(function () {
    jQuery("#genelProductDiv").scroll(function () {
        if (jQuery("#genelProductDiv").scrollTop() + jQuery("#genelProductDiv").height() > document.getElementById("genelProductDiv").scrollHeight - 5) {
            jQuery("#loader").show();
            var id = jQuery(".liClass:last").attr('id');
            var pType = jQuery("#hiddenValuetur").val();
            var pList = jQuery("#hiddenValueProductList").val();

            var dataList = 
                    "listCount:"  + id +
                    "pType:" + pType +
                    "pList:" +pList
            ;
            jQuery.ajax({
                type: "POST",
                url : "/wp-content/plugins/footsphere/bespoke/implement/bespoke.php",
                data: { "data": dataList },
                success: function (veri) {
                    console.log(veri);
                }
            });
        }
    });


});
*/