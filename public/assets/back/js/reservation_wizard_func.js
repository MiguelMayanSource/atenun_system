	jQuery(function ($) {
		"use strict";
		$("#wizard_container").wizard({
			stepsWrapper: "#wrapped",
			submit: ".submit",
			beforeSelect: function (event, state) {
				if (!state.isMovingForward)
					return true;
				    var inputs = $(this).wizard('state').step.find(':input');
				    return !inputs.length || !!inputs.valid();
			}
		}).validate({
			errorPlacement: function (error, element) {
			}
		});
		$("#progressbar").progressbar();
		$("#wizard_container").wizard({
			afterSelect: function (event, state) {
				$("#progressbar").progressbar("value", state.percentComplete);
				$("#location").text("(" + state.stepsComplete + "/" + state.stepsPossible + ")");
			}
		});
	});