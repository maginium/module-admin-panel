/**
 * Class representing the Password toggle module.
 */
define(["jquery"], function ($) {
  "use strict";

  /**
   * PasswordToggle class for adding show/hide password toggle functionality to password input fields.
   */
  class PasswordToggle {
    /**
     * Creates an instance of PasswordToggle.
     * @param {string} inputSelector - The selector for password input fields.
     * @param {string} toggleSelector - The selector for the toggle icon element.
     */
    constructor(inputSelector, toggleSelector) {
      // jQuery collection of password input fields
      this.passwordInput = $(inputSelector);

      // Selector for the toggle icon element
      this.toggleSelector = toggleSelector;

      // Initialize the password toggle functionality
      this.init();
    }

    /**
     * Initialize the password toggle functionality.
     * Adds toggle icons and attaches toggle event.
     */
    init() {
      this.addToggleIcons(); // Method to add toggle icons next to password input fields
      this.attachToggleEvent(); // Method to attach click event to toggle icons
    }

    /**
     * Add toggle icons next to password input fields.
     */
    addToggleIcons() {
      // Iterate over each password input field
      this.passwordInput.each(function () {
        // Check if the parent element has the class 'value'
        const isValueParent = $(this).parent().hasClass("value");

        // Construct the icon element
        const iconElement = `<em toggle="#${this.id}" class="password-toggle icon ni ni-eye-fill field-icon"></em>`;

        // Append the icon element either inside or after the parent based on the class
        if (isValueParent) {
          $(this).parent().after(`<div class="use-default">${iconElement}</div>`);
        } else {
          $(this).parent().append(iconElement);
        }
      });
    }

    /**
     * Attach click event to the toggle icons.
     * Toggles the visibility of password input fields.
     */
    attachToggleEvent() {
      const self = this;
      // Attach click event to the document, delegated to the toggleSelector
      $(document).on("click", this.toggleSelector, function () {
        // Find the common parent element of the toggle icon and the password input field
        const commonParent = $(this).parent().parent();

        // Find the password input field within the common parent
        const input = commonParent.find("input[type='password'], input[type='text']");

        // Toggle the input type between text and password
        const currentType = input.prop("type");
        input.prop("type", currentType === "password" ? "text" : "password");

        // Toggle the icon class for visual feedback
        $(this).toggleClass("ni-eye-fill ni-eye-off-fill");
      });
    }
  }

  // Return the PasswordToggle class for module use
  return PasswordToggle;
});
