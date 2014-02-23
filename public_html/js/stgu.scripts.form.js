/**
 * Generic function to be called prior to form submission, 
 * to be overriden in controller-specific JS files or where applicable
 */
function beforeSubmit(arr, $form, options){
//	//clears all messages
//	$('form.stguForm').clearMessages('', {animate : false});
	//clears all tootltips
//	$('form.stguForm').validationEngine('hideAll');
};

/**
 * Generic function to be called when errors in the submission return, 
 * to be overriden in controller-specific JS files or where applicable
 */
function formError(){
	// show error notification
	var notificationOptions = {
			autoClose: false, 
			classes: ['red-gradient'],
			hPos: 'center'
		}
	var text = "generic error"; // $('#genericFormError').attr('title');
	alert(text);
};
/**
 * Generic function to be called when the submission returns successfully, 
 * to be overriden in controller-specific JS files or where applicable
 */
function formSuccess(data){
	if(data && data.responseStatus === 0 && data.messages && data.messages.message){
		alert("Error: " + data.messages.message);
	}
	else if(data && data.responseStatus === 1 && data.messages && data.messages.message){
		alert("Success: " + data.messages.message);
	}
};

$(function($){
	$('form.stguForm').validationEngine({
							promptPosition : "centerRight",
							binded		   : false,
							onValidationComplete: function(form, status) {
								if ($('.button[type="submit"]', form).hasClass('disabled')) {
									return false;
								}
								return status;
							}
						})
					  .ajaxForm({
							data : {
								spformat : true
							},
						  	dataType 	 : 'json',
							beforeSubmit : beforeSubmit,
							error		 : formError,
							success		 : formSuccess,
							beforeSend: function() {
								$('.button[type="submit"]').addClass('disabled');
							},
							complete: function() {
								$('.button[type="submit"]').removeClass('disabled');
							}
					  	});
});