function downFunc() {
    if(document.getElementById("dashboard_quick_press").className=="postbox"){
        document.getElementById("dashboard_quick_press").className = "postbox closed";
    }
    else{
        document.getElementById("dashboard_quick_press").className = "postbox";
    }
}
