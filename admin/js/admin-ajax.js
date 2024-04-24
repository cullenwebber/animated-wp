jQuery(document).ready(function ($) {
	$("#location_type").on("change", function (e) {
		var locationType = $(e.target).val();
		var locationValueLabel = $("#location-value-label");
		$.ajax({
			url: animatedWp.ajax_url,
			type: "POST",
			data: {
				action: "get_location_values",
				location_type: locationType,
			},
			success: function (response) {
				if (response.data) {
					locationValueLabel.html(response.data);
				}
			},
			error: function (error) {
				console.log(error);
			},
		});
	});

	$("#add-animation-btn").on("click", function () {
		var animatedContainer = $("#animation-timeline-container");

		console.log("clicked");
		$.ajax({
			url: animatedWp.ajax_url,
			type: "POST",
			data: {
				action: "add_animation_inputs",
			},
			success: function (response) {
				if (response.data) {
					animatedContainer.append(response.data);
				}
			},
			error: function (error) {
				console.log(error);
			},
		});
	});

	/**
	 * Adds additional input fields to the singular animation timeline for an element
	 *
	 *
	 */
	$("body").on("click", function (event) {
		if (event.target.classList.contains("animation-add")) {
			var animatedInputContainer = $(event.target).parent();

			$.ajax({
				url: animatedWp.ajax_url,
				type: "POST",
				data: {
					action: "add_animated_inputs",
				},
				success: function (response) {
					if (response.data) {
						animatedInputContainer.after(response.data);
					}
				},
				error: function (error) {
					console.log(error);
				},
			});
		}
	});

	/**
	 * IMPORTANT AJAX POST
	 *
	 * Sends the ajax request to save all the animation data
	 *
	 *
	 */
	$("#save-animation-timeline").on("click", function (e) {
		e.preventDefault();

		var container = $(".animated-wp-content-wrapper");
		var subheader = $(".animated-wp-sub-header");

		var inputs = container.find("input").add(subheader.find("input"));

		var emptyInput = false;
		inputs.each(function () {
			var input = $(this);
			if (input.val().trim() === "") {
				input.css("border", "1px solid red");
				if (input.prev(".error-message").length === 0) {
					$(
						'<span class="error-message" style="color: red; display: block; position: absolute; margin-top: 2px; font-size: 10px;">Field value is required</span>'
					).insertAfter(input);
				}
				emptyInput = true;
			} else {
				input.css("border", "");
				input.prev(".error-message").remove();
			}
		});

		if (emptyInput) {
			verify_error_fields();
			return;
		}

		var titleInput = $("#animated-wp-title-input").val();
		var postId = $("#post_id").val();

		//Get the location data
		var locationData = get_location_data();

		//Get the trigger data for the post
		var triggerData = get_trigger_data();

		//Get the animation data for the post
		var animationData = get_animation_data();
		console.log(animationData);

		$.ajax({
			url: animatedWp.ajax_url,
			type: "POST",
			data: {
				action: "save_animation_data",
				title: titleInput,
				postId: postId,
				triggerData: triggerData,
				locationData: locationData,
				animationData: animationData,
			},
			success: function (response) {
				alert(response.data);
			},
			error: function (error) {
				alert(error);
			},
		});
	});

	function verify_error_fields() {
		var container = $(".animated-wp-content-wrapper");
		var subheader = $(".animated-wp-sub-header");

		var inputs = container.find("input").add(subheader.find("input"));

		inputs.on("input", function () {
			var input = $(this);
			if (input.val().trim() !== "") {
				input.css("border", "");
				input.next(".error-message").remove();
			}
		});
	}

	/**
	 * Retrieves the animation location data
	 *
	 *
	 */
	function get_location_data() {
		var locationType = $("#location_type").val();
		var locationValue = $("#location_value").val();

		var locationData = {
			locationType,
			locationValue,
		};

		return locationData;
	}

	/**
	 * Get the trigger information
	 *
	 */
	function get_trigger_data() {
		var triggerType = $(`input[name="trigger-type"]:checked`).val();

		var triggerElement = null;
		var triggerInteraction = null;

		if (triggerType == "element-interaction") {
			triggerElement = $("#trigger-element").val();
			triggerInteraction = $("#trigger-interaction").val();
		}

		var triggerData = {
			triggerType,
			triggerElement,
			triggerInteraction,
		};

		return triggerData;
	}

	/**
	 * Retrieve all the animation container fields
	 *
	 */

	function get_animation_data() {
		var animationsContainer = $(".animation-container");
		var timelines = [];

		animationsContainer.each(function () {
			var animatedState = $(this).find("#animated-state").val();
			var duration = $(this).find("#duration").val();
			var ease = $(this).find("#ease").val();
			var animatedElement = $(this).find("#animated-element").val();
			var animationOffset = $(this).find("#animation-offset").val();
			var animationStagger = $(this).find("#animation-stagger").val();

			var animations = [];

			var $properties = $(this).find('input[name="animated-property"]');
			$properties.each(function (index) {
				var property = $(this).val();
				var value = $(this)
					.closest(".animation-container")
					.find('input[name="animated-value"]')
					.eq(index)
					.val();

				if (property && value) {
					animations.push({
						property: property,
						value: value,
					});
				}
			});

			timelines.push({
				state: animatedState,
				duration: duration,
				ease: ease,
				element: animatedElement,
				animations: animations,
				animationOffset: animationOffset,
				animationStagger: animationStagger,
			});
		});

		return timelines;
	}
});
