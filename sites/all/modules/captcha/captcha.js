// $Id: captcha.js,v 1.2.2.1 2010/11/16 21:20:01 soxofaan Exp $

// JavaScript behaviors for the CAPTCHA admin page
Drupal.behaviors.captchaAdmin = function (context) {
	
	// Add onclick handler to checkbox for adding a CAPTCHA description
	// so that the textfields for the CAPTCHA description are hidden
	// when no description should be added.
	$("#edit-captcha-add-captcha-description").click(function() {
		if ($("#edit-captcha-add-captcha-description").is(":checked")) {
			// Show the CAPTCHA description textfield(s).
			$("#edit-captcha-description-wrapper").show("slow");
		}
		else {
			// Hide the CAPTCHA description textfield(s).
			$("#edit-captcha-description-wrapper").hide("slow");
		}
	});
	// Hide the CAPTCHA description textfields if option is disabled on page load.
	if (!$("#edit-captcha-add-captcha-description").is(":checked")) {
		$("#edit-captcha-description-wrapper").hide();
	}

};
