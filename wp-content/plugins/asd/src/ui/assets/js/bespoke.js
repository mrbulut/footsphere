function cevir(tabid) {
  
    if (tabid == 0) {
        document.getElementById("ayakkabiTab_tab").className = "vc_tta-tab vc_active";
        document.getElementById("terlikTab_tab").className = "vc_tta-tab";
        document.getElementById("#ayakkabiPaneli_panel").className = "vc_tta-panel vc_active";
        document.getElementById("#terlikPaneli_panel").className = "vc_tta-panel";

    } else {
        document.getElementById("ayakkabiTab_tab").className = "vc_tta-tab";
        document.getElementById("terlikTab_tab").className = "vc_tta-tab vc_active";
        document.getElementById("#ayakkabiPaneli_panel").className = "vc_tta-panel";
        document.getElementById("#terlikPaneli_panel").className = "vc_tta-panel vc_active";
    }

}	

