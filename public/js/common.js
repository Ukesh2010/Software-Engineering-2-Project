
jQuery.validator.addMethod("alphanumeric", function(value, element) {
    return this.optional(element) || /^[a-zA-Z]+$/.test(value);
}, "Field contains illegal characters.");

function blockUI(){
$.blockUI({ 
 css: { 
            border: 'none', 
            padding: '5px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        },

message: '<img src="images/ajax-loader.gif" /> Processing. . .' });}

function addAlert(message) {
    $('#error').html(
        '<div class="alert alert-danger fade in">' +
        '<button type="button" class="close" data-dismiss="alert">' +
        '&times;</button><Strong>Error! </Strong>' + message + '</div>'
    );
}

function errorCallBack() {
    alert("Error! There was an internal error accessing the database.");
 
}

function handleAjaxCall(url, type, data, async, successCallBack, failCallBack,showLoading) {
    if(showLoading != false){
        blockUI();
    }

    $.ajax({
        url: url,
        type: type,
        data: data,
        async: async,  
        success: function (result) {
            successCallBack(result);
        },
        error: function () {
            $.unblockUI();
            failCallBack();
        }, complete: function () {
            $.unblockUI();
        }
    });
}
function sanitize (unsafe_str) {
    return unsafe_str
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/\"/g, '&quot;')
      .replace(/\'/g, '&#39;'); // '&apos;' is not valid HTML 4
}
function checkVal(data){
    if(data == undefined){
        return '';
    }
    return data;
}
function checkObj(data){
    if(data !== undefined){
        return true;
    }else{
        return false;
    }
}

