/**
 * Configuration object for RequireJS.
 * Defines paths and dependencies for password toggle.
 */
var config = {
  map: {
    "*": {
      passwordToggle: "Maginium_AdminPassword/js/password-toggle",
    },
  },
  shim: {
    "Maginium_AdminPassword/js/password-toggle": {
      deps: ["jquery"],
    },
  },
};
