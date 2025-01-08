/**
 * Class representing the configuration icons module.
 *
 * This module applies custom icons to configuration tabs based on the provided
 * configuration data. It uses vanilla JavaScript for DOM manipulation and applies the
 * icons to the respective elements.
 */
define("configIcons", ["jquery"], function ($) {
  "use strict";

  /**
   * Creates a new ConfigIcons instance.
   *
   * The constructor initializes the module by storing the provided configuration
   * data and calling the initialization method.
   *
   * @constructor
   * @param {Object} configData - The configuration data containing icons information for each config tab.
   *        Each entry in the `configData` should contain the `id`, `icon`, `position`, and `family` properties.
   */
  class ConfigIcons {
    constructor(configData) {
      // Store the configuration data provided during initialization
      this.configData = configData;

      // Initialize the module (apply custom icons)
      this.init();
    }

    /**
     * Initializes the ConfigIcons module by applying custom icons to config tabs.
     *
     * This method is called during the instantiation of the ConfigIcons class.
     * It sets up the module by applying custom icons to the configuration tabs.
     */
    init() {
      // Apply custom icons to the config tabs
      this.apply();
    }

    /**
     * Applies custom icons to config tabs based on the configuration data.
     *
     * This method iterates over each item in the `configData` object and applies
     * a custom icon to the respective DOM elements that match the specified `itemClass`.
     */
    apply() {
      // Iterate through each config icon entry in the configuration data
      $.each(this.configData, (key, icon) => {
        // Validate icon configuration
        if (this.isValidIcon(icon)) {
          // Determine the font family based on the 'family' property or the icon prefix
          let fontFamily = icon.family || ConfigIcons.getFontFamily(icon.icon);

          // Find the target element with class `icon.id`, and then target .title strong
          const element = this.getElement(icon.id);

          if (element) {
            this.addIconToElement(element, icon);
          }
        }
      });
    }

    /**
     * Validates if the icon configuration is valid.
     *
     * @param {Object} icon - The icon configuration object.
     * @returns {boolean} True if the icon configuration is valid, otherwise false.
     */
    isValidIcon(icon) {
      return icon.icon && icon.icon !== "false";
    }

    /**
     * Finds the target DOM element for the given icon ID.
     *
     * @param {string} id - The class ID used to locate the element.
     * @returns {Element|null} The target element, or null if not found.
     */
    getElement(id) {
      const element = document.querySelector("." + id + " .title strong");
      return element || null;
    }

    /**
     * Adds the custom icon to the specified DOM element based on the icon configuration.
     *
     * @param {Element} element - The target DOM element to which the icon is added.
     * @param {Object} icon - The icon configuration object.
     */
    addIconToElement(element, icon) {
      switch (icon.position) {
        case "before":
        case "after":
          // Apply CSS rule for before or after
          this.addIconWithCSS(element, icon, icon.position);
          break;

        default:
          // Apply the icon as an <i> element
          this.createAndPrependIcon(element, icon);
          break;
      }
    }

    /**
     * Creates a new <i> element and prepends it to the given element.
     *
     * @param {Element} element - The target DOM element.
     * @param {Object} icon - The icon configuration.
     */
    createAndPrependIcon(element, icon) {
      // Create a new <i> element
      const newIcon = document.createElement("i");

      // Add each class in icon.icon (split by spaces) to the <i> element
      icon.icon.split(" ").forEach((className) => {
        newIcon.classList.add(className);
      });

      // Prepend the new icon to the <strong> element
      element.prepend(newIcon);

      // Add the 'hide_original_icon' class to the <strong> element
      element.classList.add("hide_original_icon");
    }

    /**
     * Adds the icon using CSS :before or :after pseudo-elements.
     *
     * @param {Element} element - The target DOM element.
     * @param {Object} icon - The icon configuration.
     * @param {string} position - The position ("before" or "after").
     */
    addIconWithCSS(element, icon, position) {
      // Prepare the icon's font-family and icon content
      const fontFamily = icon.family || ConfigIcons.getFontFamily(icon.icon);
      const iconContent = `"\\${icon.icon}"`; // Add a backslash before the icon content

      // Inject custom CSS for the icon
      const style = document.createElement("style");
      style.innerHTML = `
                .${icon.id} .title strong::${position} {
                    font-family: ${fontFamily};
                    content: ${iconContent};
                }
            `;

      document.head.appendChild(style);
    }

    /**
     * Determines the appropriate font-family based on the icon prefix.
     *
     * @param {string} icon - The icon class name.
     * @returns {string} The determined font-family.
     */
    static getFontFamily(icon) {
      if (icon.startsWith("ni")) {
        // NioIcons font family
        return "NioIcon";
      } else if (icon.startsWith("fa") || icon.startsWith("fas")) {
        // Font Awesome font family
        return "FontAwesome";
      } else if (icon.startsWith("mdi")) {
        // Material Design Icons font family
        return "MaterialDesignIcons";
      }

      // Default to inherit if no specific family is identified
      return "inherit";
    }
  }

  // Return the ConfigIcons class for use in other parts of the application
  return ConfigIcons;
});
