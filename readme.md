# jQuery FormSubmit - Effortless AJAX-based form submission

Copyright 2013 Cory LaViska for A Beautiful Site, LLC.

Demo: http://labs.abeautifulsite.net/jquery-formSubmit/demo/

## Overview:
	
This plugin provides a lightweight framework for handling AJAX-based 
form submissions. It allows you to reduce the amount of code it takes 
to process form submissions by automating common tasks such as making 
the form busy, highlighting invalid fields, and handling success/error 
responses.

The plugin uses the form's `action` attribute to determine where the 
form will post to.  It uses the `method` attribute to determine which 
HTTP method to use.

The plugin expects a JSON response from your server with the following 
properties:

		{
			"status": "success",
			"feedback": "<strong>Success!</strong> It worked!",
			"invalid": ["fieldName1", "fieldName2", "fieldName3", ...]
			"data": { [Your JSON data] }
		}

A `status` is required and should always be either "success" or "error", 
meaning the form was accepted or rejected by the server. (Don't confuse 
"error" with an AJAX error, as those are handled differently.)

The `feedback` property is optional. If specified, this should be an 
HTML string that will be injected into any container in your form that has
the `formSubmit-feedback` class. In addition, a class of either 
`formSubmit-success` or `formSubmit-error` will also be applied to these 
containers.

The `invalids` property should be an array of field names that the plugin 
will highlight as invalid. Each invalid field will be assigned a class of 
`formSubmit-invalid`. You can specify additional validation behavior through 
the use of the `showInvalid` and `hideInvalid` callback functions.

The `data` property will be exposed to you through the `data` argument in the 
`success` and `error` callback functions.  This should contain all of the 
additional data that you want to pass back to your app.


## Simple Usage

If you've setup a form with a `formSubmit-feedback` container and you've 
specified styles for `formSubmit-invalid`, then you can handle form 
submissions (including feedback and error highlighting) very easily:

	$('FORM').formSubmit({
		success: function(data) {
			// Do something when the form is accepted
		}
	});

(You technically don't even need to include the `success` callback if you've 
set the form up to display feedback.)


## Advanced Usage

	$('FORM').formSubmit({
		
		before: function(formData) {
			// executes code before the form gets submitted; return false 
			// here to prevent the form from being submitted; formData will 
			// be an object containing all the fields that will be submitted 
			// to the form
		},
		
		success: function(data) {
			// executes when the form is submitted and a `success` 
			// status is returned
		},
		
		error: function(data) {
			// executes when the form is submitted and an `error` 
			// status is returned
		},
		
		ajaxError: function(jqXHR, textStatus, errorThrown) {
			// executes when an XHR error occurs
		},
		
		showInvalid: function() {
			// a function that iterates through each erroneous field as 
			// returned in the `invalid` property. Use $(this) 
			// to reference each field.  Note that all erroneous fields 
			// will always have the `formSubmit-invalid` class applied to 
			// them by default.
			//
			// Example:
			
			$(this).addClass('your-custom-class');
		},
		
		hideInvalid: function() {
			// a function that iterates through each erroneous field 
			// before submit to clear them. This should do the opposite 
			// of showInvalid().  Note that the `formSubmit-invalid` class 
			// will automatically be removed by the plugin.
			//
			// Example:
			
			$(this).removeClass('custom-invalid-class');
		}
		
	});


## Methods

Example

	$('FORM').formSubmit(method, data);

`abort`

aborts the pending XHR request (note that the server may still process the 
request as it was sent! This only aborts it on the client side)

`busy`

returns true if the form is busy, false if the form is not busy

`busy, (true|false)`

sets the form's busy state

`destroy`

releases the form back to its original form and behavior

`disabled (true|false)`

disables/enables form fields

`reset`

resets the form to its original state


## Tips

### URL and Request Type

The plugin uses the form's `action` and `method` attributes to 
determine the URL and the type of request to be sent. The dataType 
that is used will always be JSON.

### Handling Responses

Always return a valid JSON string containing at least a `status` property 
of `success` or `error`:

	{"status":"success"}
	{"status":"error"}

### Feedback

Return a `feedback` property containing HTML to be placed into any container 
in the form with the `formSubmit-feedback` class:

	{"status":"success","feedback":"Login successful"}
	{"status":"error","feedback":"Invalid username or password"}

The plugin will add a `formSubmit-success` or `formSubmit-error` 
class to the container depending on `status`.

### Showing/Hiding Loaders

The form will have a class of `formSubmit-busy` whenever a request is 
processing. This can be used to show/hide loaders via CSS without having 
to it with JavaScript.

### Highlighting invalid fields

When fields contain errors, return an `invalid` property containing an array 
of the erroneous field names. A class of `formSubmit-invalid` will be applied 
to each field in the list.  You can also use the showInvalid/hideInvalid callback 
to apply additional formatting or behaviors.