/**
 * Requires jQuery and collapsible module when the DOM is ready.
 *
 * This function initializes collapsible behavior on elements with a specific
 * data attribute and activates collapsible sections with a certain class
 * once the DOM is fully loaded.
 *
 * @param {jQuery} $ The jQuery object.
 */
require(["jquery", "collapsible", "domReady!"], function ($) {
  // Initialize collapsible behavior for elements with the data-role attribute set to "ext-tabs".
  // This makes the selected elements collapsible with specific open/close states and animation.
  $("[data-role=ext-tabs]").collapsible({
    openedState: "_show", // Class to apply when the section is expanded.
    closedState: "_hide", // Class to apply when the section is collapsed.
    collapsible: true, // Allows the element to be collapsed and expanded.
    animate: 200, // Animation duration in milliseconds for collapsing/expanding.
  });

  // Activate collapsible sections that have the class "_active".
  // This automatically opens the sections that are marked as active.
  $(".clean-menu-section-title ._active")
    .closest(".clean-menu-section-title") // Find the closest parent with the title class.
    .collapsible("activate"); // Activate the collapsible behavior to expand the section.
});
