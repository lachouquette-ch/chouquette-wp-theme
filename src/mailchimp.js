(function ($) {
	window.fnames = new Array();
	window.ftypes = new Array();
	fnames[0] = 'EMAIL';
	ftypes[0] = 'email';
	fnames[1] = 'FNAME';
	ftypes[1] = 'text';
	fnames[2] = 'LNAME';
	ftypes[2] = 'text';

	$.extend($.validator.messages, {
		required: "Ce champ est requis.",
		remote: "Veuillez remplir ce champ pour continuer.",
		email: "Veuillez entrer une adresse email valide.",
		url: "Veuillez entrer une URL valide.",
		date: "Veuillez entrer une date valide.",
		dateISO: "Veuillez entrer une date valide (ISO).",
		number: "Veuillez entrer un nombre valide.",
		digits: "Veuillez entrer (seulement) une valeur numérique.",
		creditcard: "Veuillez entrer un numéro de carte de crédit valide.",
		equalTo: "Veuillez entrer une nouvelle fois la même valeur.",
		accept: "Veuillez entrer une valeur avec une extension valide.",
		maxlength: $.validator.format("Veuillez ne pas entrer plus de {0} caractères."),
		minlength: $.validator.format("Veuillez entrer au moins {0} caractères."),
		rangelength: $.validator.format("Veuillez entrer entre {0} et {1} caractères."),
		range: $.validator.format("Veuillez entrer une valeur entre {0} et {1}."),
		max: $.validator.format("Veuillez entrer une valeur inférieure ou égale à {0}."),
		min: $.validator.format("Veuillez entrer une valeur supérieure ou égale à {0}.")
	});
}(jQuery));
var $mcj = jQuery.noConflict(true);