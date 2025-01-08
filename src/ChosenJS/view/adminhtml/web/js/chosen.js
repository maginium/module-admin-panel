/**
 * Class representing the configuration icons module.
 *
 * This module applies custom icons to configuration tabs based on the provided
 * configuration data. It uses jQuery to manipulate DOM elements and apply the
 * icons to the respective elements.
 */
define("prototype", "chosenProtoJS", ["jquery"], function ($) {
  "use strict";

  // Show loader until Chosen library is fully loaded and initialized
  var loader = $("<div class='loader'></div>");

  // Append the loader to the body
  $("body").append(loader);

  /**
   * Creates a Chosen dropdown for a given select element.
   * This function modifies the select element, ensuring it has a default "Please select" option and applies Chosen.js styling.
   * It also sets up a MutationObserver to handle dynamic changes to the select element.
   *
   * @param {HTMLElement} element - The select element to enhance with Chosen.js.
   */
  function createChosen(element) {
    var plzSel = 0;

    // Loop through child nodes to check for an empty option, and set a default "Please select" option if necessary.
    element.childNodes.forEach(function (opt, index) {
      if (opt.value == "") {
        plzSel = 1;
        if (opt.innerHTML.trim() == "") {
          // Set default text if it's empty
          opt.innerHTML = "Please select";
        }
      }
    });

    // If no default option is found, insert one at the top of the select element
    if (plzSel == 0) {
      element.insert({
        top: new Element("option", {
          value: "",
        }).update("Please select"), // Default text for the dropdown
      });
    }

    // Set the width of the dropdown element
    var elwidth = element.getWidth();
    if (elwidth <= 0) {
      // Set width to 100% if the width is 0
      elwidth = "100%";
    } else {
      // Convert to pixels if width is available
      elwidth = elwidth + "px";
    }

    // Initialize Chosen.js for the element with the computed width
    new Chosen(element, {
      width: elwidth,
    });

    // Dynamically enable/disable Chosen dropdowns when attributes or style change
    var observer = new MutationObserver(function (mutations) {
      mutations.forEach(function (mutation) {
        // Trigger Chosen.js update
        Event.fire(element, "chosen:updated");
        if (mutation.type == "attributes") {
          if (mutation.attributeName == "style") {
            // Hide element if style attribute changes
            element.hide();
          }
        }
      });
    });

    // Observe changes in the select element's subtree, child nodes, and attributes
    observer.observe(element, {
      subtree: true,
      childList: true,
      attributes: true,
    });

    // Remove the loader once Chosen.js is initialized
    loader.remove();
  }

  // Check and create Chosen dropdowns for email template select elements
  $$(".adminhtml-email_template-edit .admin__control-select").each(function (element) {
    var selId = element.identify();
    if (!$("#" + selId).next(".chosen-container").length) {
      // Apply Chosen to select element if not already initialized
      createChosen(element);
    }
  });

  // Check and create Chosen dropdowns for select elements inside table wrappers
  $(document).ready(function () {
    setTimeout(function () {
      $$(".admin__control-table-wrapper select").each(function (element) {
        var selId = element.identify();
        if (!$("#" + selId).next(".chosen-container").length) {
          // Apply Chosen to select element if not already initialized
          createChosen(element);
        }
      });

      // Delay to allow DOM elements to load
    }, 200);
  });

  // Check and create Chosen dropdowns for additional attributes select elements
  $$("#algoliasearch_products_products_product_additional_attributes .action-add").each(function (element) {
    element.observe("click", function () {
      setTimeout(function () {
        $$("#algoliasearch_products_products_product_additional_attributes .select").each(function (element) {
          var selId = element.identify();
          if (!$("#" + selId).next(".chosen-container").length) {
            // Apply Chosen to select element if not already initialized
            createChosen(element);
          }
        });

        // Delay for dynamic content to be rendered
      }, 100);
    });
  });

  // Create Chosen dropdowns for existing additional attributes select elements
  $$("#algoliasearch_products_products_product_additional_attributes .select").each(function (element) {
    // Apply Chosen to existing select elements
    createChosen(element);
  });

  // Check and create Chosen dropdowns for custom ranking product attributes select elements
  $$("#algoliasearch_products_products_custom_ranking_product_attributes .action-add").each(function (element) {
    element.observe("click", function () {
      setTimeout(function () {
        $$("#algoliasearch_products_products_custom_ranking_product_attributes .select").each(function (element) {
          var selId = element.identify();
          if (!$("#" + selId).next(".chosen-container").length) {
            // Apply Chosen to select element if not already initialized
            createChosen(element);
          }
        });

        // Delay for dynamic content to be rendered
      }, 100);
    });
  });

  // Create Chosen dropdowns for existing custom ranking product attributes select elements
  $$("#algoliasearch_products_products_custom_ranking_product_attributes .select").each(function (element) {
    // Apply Chosen to existing select elements
    createChosen(element);
  });
});
