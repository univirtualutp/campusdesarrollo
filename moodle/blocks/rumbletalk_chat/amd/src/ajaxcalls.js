define(['jquery', 'core/notification','core/ajax'],
       function($, notification, ajax) {

    function Ajaxcall() {
        this.value = "ajax ok";
    };
    
    Ajaxcall.prototype.account_create = function(email, password) {

        var promises = ajax.call([{
            methodname: 'create_account_external',
            args: {email: email, password: password},
            //done: console.log("ajax done"),
            fail: notification.exception
        }]);
        promises[0].then(function(data) {
            console.log("These are ajax. Email: " + email + ", Password: " + password); //data contains webservice answer
        });
    };    
    
    return Ajaxcall;
});
    