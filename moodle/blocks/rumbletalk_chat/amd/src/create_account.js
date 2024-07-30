// define(['jquery', 'block_rumbletalk_chat/ajaxcalls'], 
//     function($, ajax){

//     return {
//         init: function(data){
//             console.log(data.email);
//             alert("Email: " + data.email + ", Password: " + data.password);
//             var email = data.email;
//             var password = data.password;
//             var ajaxx = require("block_rumbletalk_chat/ajaxcalls");
//             var ajax2 = new ajaxx();
//             ajax2.account_create(email, password);
//         }
//     }

// });

import DynamicForm from 'core_form/dynamicform';
// ...

// Initialize the form - pass the container element and the form class name.
const dynamicForm = new DynamicForm(document.querySelector('#create_account_result'), 'core_user\\form\\private_files');
// By default the form is removed from the DOM after it is submitted, you may want to change this behavior:
dynamicForm.addEventListener(dynamicForm.events.FORM_SUBMITTED, (e) => {
    e.preventDefault();
    const response = e.detail;
    console.log(response);
    // It is recommended to reload the form after submission because the elements may change.
    // This will also remove previous submission errors. You will need to pass the same arguments to the form
    // that you passed when you rendered the form on the page.
    dynamicForm.load({arg1: 'val1'});
});
// Similar listener can be added for the FORM_CANCELLED event.