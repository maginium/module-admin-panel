/**
 * Configuration object for RequireJS.
 * Defines paths and dependencies for modules used in the application.
 */
var config = {
  map: {
    "*": {
      // Map the hotkeys module to its file path
      hotkeys: "Maginium_AdminKeyboardShortcuts/js/hotkeys.min",
      // Map the keyboardShortcuts module to its file path
      keyboardShortcuts: "Maginium_AdminKeyboardShortcuts/js/keyboard-shortcuts",
    },
  },
  shim: {
    // Define dependencies for the keyboardShortcuts module
    "Maginium_AdminKeyboardShortcuts/js/keyboard-shortcuts": {
      deps: ["jquery", "hotkeys"],
    },
  },
};
