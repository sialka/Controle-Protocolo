//console.log("contact_me.js");

$(function() {    
    
    $("#protocolo_form input,#protocolo_form textarea").jqBootstrapValidation({
        preventSubmit: true,
        submitError: function($form, event, errors) {
            // additional error messages or events            
        },
        submitSuccess: function($form, event) {            
        },
        filter: function() {            
            return $(this).is(":visible");
        },
    });

    

    $("a[data-toggle=\"tab\"]").click(function(e) {
        
        e.preventDefault();
        $(this).tab("show");
    });
});

/*
// When clicking on Full hide fail/success boxes
$('#usuario').focus(function() {
    $('#success').html('');
});
*/

