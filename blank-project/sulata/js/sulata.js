//make two cols equal
function suEqualCols(col1, col2) {
    return false;
    if ($("#" + col1)) {
        col1Height = $("#" + col1).height();
        c1h = col1Height + "px";

    }
    if ($("#" + col2)) {
        col2Height = $("#" + col2).height();
        c2h = col2Height + "px";
    }
    if (col1Height > col2Height) {
        $("#" + col2).height(c1h);
    } else {
        $("#" + col1).height(c2h);
    }
    //to enable this function, remove or comment the 'return false;' line below
    return false;
    var ua = navigator.userAgent.toLowerCase();
    //Check if not mobile
    if (!((ua.search("ios") > -1) || (ua.search("ipad") > -1) || (ua.search("ipod") > -1) || (ua.search("iphone") > -1) || (ua.search("android") > -1) || (ua.search("blackberry") > -1) || (ua.search("nokia") > -1))) {

        if ($("#" + col1)) {
            col1Height = $("#" + col1).height();
            c1h = col1Height + "px";

        }
        if ($("#" + col2)) {
            col2Height = $("#" + col2).height();
            c2h = col2Height + "px";
        }
        if (col1Height > col2Height) {
            $("#" + col2).height(c1h);
        } else {
            $("#" + col1).height(c2h);
        }

    }
}
//Keep session live
function suStayAlive(url) {
    $.post(url);
}
//Reset all form
function suReset() {
    for (i = 0; i <= document.forms.length - 1; i++) {
        if (document.forms[i]) {
            document.forms[i].reset();
        }
    }
}
//Redirect
function suRedirect(url) {
    parent.window.location.href = url;
}

////To reload a dropdown
//function suReload(ele,url,sql){
//    $('#'+ele).load(url+'?q='+sql);
//}

//Disable submit button
function suToggleButton(arg) {
    if (arg == 1) {
        if (parent.$('#suForm')) {
            parent.$("#suForm").submit(function(event) {
                if (parent.$('#Submit')) {
                    parent.$("#Submit").val("Processing..");
                    parent.$("#Submit").css("cursor", "default");
                    parent.$("#Submit").attr("disabled", true);
                }
            });
        }
    } else {
        if (parent.$('#suForm')) {
            if (parent.$('#Submit')) {
                parent.$("#Submit").val("Submit");
                parent.$("#Submit").css("cursor", "Pointer");
                parent.$("#Submit").attr("disabled", false);
            }
        }
    }
}
//Reload dropdown
function suReload(ele, url, tbl, f1, f2) {
    url = url + 'reload.php';
    $('#' + ele).load(url + '?tbl=' + tbl + '&f1=' + f1 + '&f2=' + f2);
}
//Reload dropdown
function suReload2(ele, url, tbl, f1, f2, tblb, f1b, f2b, id) {
    url = url + 'reload.php';
    $('#' + ele).load(url + '?type=chk&tbl=' + tbl + '&f1=' + f1 + '&f2=' + f2 + '&tblb=' + tblb + '&f1b=' + f1b + '&f2b=' + f2b + '&id=' + id);
}
//Search dropdown
//Sample code
//<input type="text" id="realtxt" onKeyUp="suSearchCombo(this.id,'mediafile__Category')">
function suSearchCombo(searchBox, searchCombo) {
    var input = document.getElementById(searchBox).value.toLowerCase();
    var output = document.getElementById(searchCombo).options;
    for (var i = 0; i < output.length; i++) {
        if (output[i].text.indexOf(input) >= 0) {
            output[i].selected = true;
        }
        if (document.getElementById(searchBox).value == '') {
            output[0].selected = true;
        }
    }
}

//Delete row and confirm
function delRecord(arg, warning) {
    c = confirm(warning);
    if (c == false) {
        return false;

    } else {
        //alert 
        $(arg).parent().parent().remove();
        return true;
    }
}