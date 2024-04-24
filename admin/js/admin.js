jQuery(document).ready(function ($) {
	$(".animation-trigger-type").on("change", function (e) {
		var triggerType = $(this).val();

		var elementInteractionElements = $(".element-interaction-show");

		if (triggerType === "page-load") {
			elementInteractionElements.hide();
		} else {
			elementInteractionElements.show();
		}
	});

	/**
	 * Remove animation functionality
	 *
	 */

	$("body").on("click", function (event) {
		if (event.target.classList.contains("animation-add-remove")) {
			var parentContainer = $(event.target).parent().parent();
			parentContainer.remove();
		}
	});
});
