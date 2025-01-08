/**
 * Class representing the configuration icons module.
 *
 * This module applies custom icons to configuration tabs based on the provided
 * configuration data. It uses jQuery to manipulate DOM elements and apply the
 * icons to the respective elements.
 */
define("prototype", ["jquery"], function ($) {
  "use strict";

  // Check if the body class is 'adminhtml-system_config-edit'
  if ($("body").hasClass("adminhtml-system_config-edit")) {
    /**
     * Class to handle the free method cutoff cost relation functionality.
     * Binds events to elements related to the free method and manages their behavior.
     */
    var FreeModel = Class.create();
    FreeModel.prototype = {
      /**
       * Initializes the FreeModel instance and binds relevant methods.
       */
      initialize: function () {
        this.reload = false;
        this.bindFreeMethodCutoffCostRelation();
      },

      /**
       * Binds the change event to all free method elements, triggering updates
       * for the related cutoff cost fields.
       * @param {string} [parentId] - The ID of the parent element to filter the free method elements.
       */
      bindFreeMethodCutoffCostRelation: function (parentId) {
        // If parentId is provided, filter free method elements within it
        var freeMethodElements = parentId ? $("#" + parentId + " .free-method") : $(".free-method");

        freeMethodElements.each(function (index, element) {
          // Attach change event to each free method element
          $(element).on("change", this.checkFreeMethod.bind(this));
          this.initFreeMethod(element);
        });
      },

      /**
       * Initializes the free method by enabling/disabling the related cutoff cost field.
       * @param {HTMLElement} element - The free method element.
       */
      initFreeMethod: function (element) {
        if (element && element.id) {
          var cutoffElement = $("#" + element.id.replace(/free_method/, "cutoff_cost"));
          if (cutoffElement) {
            cutoffElement.prop("disabled", element.value === "");
          }
        }
      },

      /**
       * Event handler to check and update the status of the cutoff cost field based on the free method value.
       * @param {Event} event - The event triggered by changing the free method element.
       */
      checkFreeMethod: function (event) {
        var freeMethodElement = $(event.target);
        if (freeMethodElement && freeMethodElement.attr("id")) {
          var cutoffElement = $("#" + freeMethodElement.attr("id").replace(/free_method/, "cutoff_cost"));
          if (cutoffElement) {
            cutoffElement.prop("disabled", freeMethodElement.val() === "");
          }
        }
      },
    };

    // Initialize the FreeModel instance
    var freeMethod = new FreeModel();

    /**
     * Class to handle the country-region relation functionality.
     * Manages the relationship between country and region fields, including loading regions dynamically.
     */
    var OriginModel = Class.create();
    OriginModel.prototype = {
      /**
       * Initializes the OriginModel instance, setting up necessary properties.
       */
      initialize: function () {
        this.reload = false;
        this.loader = new varienLoader(true);
        this.regionsUrl = "<?= $block->escapeJs($block->escapeUrl($block->getUrl('directory/json/countryRegion'))) ?>";
        this.bindCountryRegionRelation();
      },

      /**
       * Binds the change event to country elements to reload the corresponding region fields.
       * @param {string} [parentId] - The ID of the parent element to filter country elements.
       */
      bindCountryRegionRelation: function (parentId) {
        var countryElements = parentId ? $("#" + parentId + " .countries") : $(".countries");

        countryElements.each(function (index, element) {
          // Attach change event to each country element
          $(element).on("change", this.reloadRegionField.bind(this));
          this.initRegionField(element);

          // Handle inheritance option
          var inheritElement = $("#" + element.id + "_inherit");
          if (inheritElement.length) {
            inheritElement.on("change", this.enableRegionZip.bind(this));
          }
        });
      },

      /**
       * Enables or disables the region and zip fields based on the selected country.
       * @param {Event} event - The event triggered when the inheritance checkbox is changed.
       */
      enableRegionZip: function (event) {
        this.reload = true;
        var countryElement = $(event.target);
        if (countryElement && countryElement.attr("id") && !countryElement.prop("checked")) {
          var regionElement = $("#" + countryElement.attr("id").replace(/country_id/, "region_id"));
          var zipElement = $("#" + countryElement.attr("id").replace(/country_id/, "postcode"));
          regionElement.prop("checked", false);
          zipElement.prop("checked", false);
        }
      },

      /**
       * Initializes the region field based on the selected country.
       * @param {HTMLElement} element - The country element.
       */
      initRegionField: function (element) {
        var countryElement = $(element);
        if (countryElement && countryElement.attr("id")) {
          var regionElement = $("#" + countryElement.attr("id").replace(/country_id/, "region_id"));
          if (regionElement) {
            this.regionElement = regionElement;
            if (countryElement.val()) {
              var url = this.regionsUrl + "parent/" + countryElement.val();
              this.loader.load(url, {}, this.refreshRegionField.bind(this));
            } else {
              this.clearRegionField(this.regionElement.prop("disabled"));
            }
          }
        }
      },

      /**
       * Reloads the region field when the country selection changes.
       * @param {Event} event - The event triggered by changing the country element.
       */
      reloadRegionField: function (event) {
        this.reload = true;
        var countryElement = $(event.target);
        if (countryElement && countryElement.attr("id")) {
          var regionElement = $("#" + countryElement.attr("id").replace(/country_id/, "region_id"));
          if (regionElement) {
            this.regionElement = regionElement;
            if (countryElement.val()) {
              var url = this.regionsUrl + "parent/" + countryElement.val();
              this.loader.load(url, {}, this.refreshRegionField.bind(this));
            } else {
              this.clearRegionField(this.regionElement.prop("disabled"));
            }
          }
        }
      },

      /**
       * Updates the region field with the new options fetched from the server.
       * @param {string} serverResponse - The response from the server containing region data.
       */
      refreshRegionField: function (serverResponse) {
        if (serverResponse) {
          var data = JSON.parse(serverResponse);
          var value = this.regionElement.val();
          var disabled = this.regionElement.prop("disabled");

          if (data.length) {
            var select = $("<select>", {
              name: this.regionElement.attr("name"),
              title: this.regionElement.attr("title"),
              id: this.regionElement.attr("id"),
              class: "required-entry select",
            });

            if (disabled) {
              select.prop("disabled", true);
            }

            data.forEach(function (item) {
              if (item.label) {
                var option = $("<option>", {
                  value: item.value,
                  text: item.label,
                });
                if (value && (value === item.value || value === item.label)) {
                  option.prop("selected", true);
                }
                select.append(option);
              }
            });

            this.regionElement.replaceWith(select);
            this.regionElement = select[0];

            new Chosen(this.regionElement, { width: "100%" });

            // Observing attribute changes and updating chosen options
            var observer = new MutationObserver(function (mutations) {
              mutations.forEach(function (mutation) {
                if (mutation.type === "attributes") {
                  $(this.regionElement).trigger("chosen:updated");
                }
              });
            });

            observer.observe(this.regionElement, {
              subtree: true,
              childList: true,
              attributes: true,
            });
          } else if (this.reload) {
            this.clearRegionField(disabled);
          }
        }
      },

      /**
       * Clears the region field and replaces it with an input field.
       * @param {boolean} disabled - Whether the field should be disabled.
       */
      clearRegionField: function (disabled) {
        var text = $("<input>", {
          type: "text",
          name: this.regionElement.name,
          title: this.regionElement.title,
          id: this.regionElement.id,
          class: "input-text",
          disabled: disabled,
        });

        this.regionElement.replaceWith(text);
        this.regionElement = text[0];
      },
    };

    // Initialize the OriginModel instance
    new OriginModel();

    /**
     * Class representing the per-page selection logic for product listing pages.
     *
     * This module allows toggling between different list modes (grid, list, or grid-list),
     * and dynamically shows or hides the corresponding per-page selection options.
     * It uses jQuery-style event listeners for DOM manipulations.
     */
    var perPageModel = Class.create();

    /**
     * Constructor for perPageModel.
     * Initializes elements for list mode selection and per-page options, and sets up event listeners.
     */
    perPageModel.prototype = {
      initialize: function () {
        // Get DOM elements for per-page selection options.
        this.listModeElement = $("catalog_frontend_list_mode");

        // Check if the listModeElement exists before proceeding.
        if (this.listModeElement) {
          this.gridValuesElement = $("catalog_frontend_grid_per_page_values");
          this.listValuesElement = $("catalog_frontend_list_per_page_values");
          this.listElement = $("catalog_frontend_list_per_page");
          this.gridElement = $("catalog_frontend_grid_per_page");

          // Arrays to store the available options for grid and list modes.
          this.gridOptions = [];
          this.listOptions = [];

          // Refresh the per-page select options based on the selected mode.
          this.refreshPerPageSelect();

          // Bind change event to the list mode dropdown to trigger per-page select refresh.
          this.bindListModeChange();
        }
      },

      /**
       * Binds the change event on the list mode dropdown to the refreshPerPageSelect method.
       */
      bindListModeChange: function () {
        // Observe change event on the listModeElement to refresh the per-page selection.
        Event.observe(this.listModeElement, "change", this.refreshPerPageSelect.bind(this));
      },

      /**
       * Refreshes the per-page select options based on the current list mode selection.
       * Toggles visibility of the grid and list options accordingly.
       */
      refreshPerPageSelect: function () {
        // Check the value of the list mode element and show/hide relevant per-page options.
        if (this.listModeElement.value != "") {
          // Hide/show options based on the selected mode (grid, list, or grid-list).
          if (this.listModeElement.value == "grid") {
            this.listElement.up(1).hide();
            this.listValuesElement.up(1).hide();

            this.gridElement.up(1).show();
            this.gridValuesElement.up(1).show();
          } else if (this.listModeElement.value == "grid-list" || this.listModeElement.value == "list-grid") {
            this.listElement.up(1).show();
            this.listValuesElement.up(1).show();

            this.gridElement.up(1).show();
            this.gridValuesElement.up(1).show();
          } else if (this.listModeElement.value == "list") {
            this.listElement.up(1).show();
            this.listValuesElement.up(1).show();

            this.gridElement.up(1).hide();
            this.gridValuesElement.up(1).hide();
          }
        }
      },
    };

    // Initialize the perPageModel instance.
    perPageSelect = new perPageModel();

    /**
     * Function to display hint elements on mouseover and hide them on mouseout.
     * This function observes hint elements and toggles their visibility when hovered.
     */
    function showHint() {
      // Select all hint elements and add event listeners for showing/hiding on hover.
      $$(".hint").each(function (element) {
        // Show the hint when mouse enters the element.
        Event.observe(element, "mouseover", function () {
          element.down().show();
        });

        // Hide the hint when mouse leaves the element.
        Event.observe(element, "mouseout", function () {
          element.down().hide();
        });
      });
    }

    // Bind the showHint function to the window load event to ensure hints are shown on page load.
    Event.observe(window, "load", showHint);
  }
});
