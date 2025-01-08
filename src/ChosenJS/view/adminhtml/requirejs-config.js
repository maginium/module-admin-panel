/**
 * Configuration object for RequireJS.
 * Defines paths and dependencies for the Chosen.js library and related scripts.
 */
var config = {
  /**
   * Paths configuration for RequireJS.
   * Maps module names to their respective file paths.
   */
  paths: {
    // Path to the Chosen.js library script
    chosenJS: "Maginium_AdminChosenJS/js/chosen",

    // Path to the Chosen.js prototype extensions script
    chosenProtoJS: "Maginium_AdminChosenJS/js/chosen.proto",

    // Path to the system configuration script related to Chosen.js
    systemConfigChosenJs: "Maginium_AdminChosenJS/js/system-config-chosen",
  },

  /**
   * Shim configuration for non-AMD (Asynchronous Module Definition) libraries.
   * Defines module dependencies and initialization order.
   */
  shim: {
    // Chosen.proto.js depends on the Prototype.js library
    chosenProtoJS: {
      deps: ["prototype"], // Ensures Prototype.js is loaded before Chosen.proto.js
    },
  },
};
