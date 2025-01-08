/**
 * Class representing the Keyboard Shortcuts .
 */
define(["jquery", "hotkeys"], function ($, hotkeys) {
  "use strict";

  /**
   * KeyboardShortcuts class for managing keyboard shortcuts.
   */
  class KeyboardShortcuts {
    /**
     * Creates an instance of KeyboardShortcuts.
     * @param {Object} keyboardShortcuts - The keyboard shortcuts object.
     * @param {string} backendUrl - The backend URL.
     * @param {string} sameUrlMessage - The message to display if the target URL is the same as the current URL.
     */
    constructor(keyboardShortcuts, backendUrl, sameUrlMessage) {
      this.backendUrl = backendUrl;
      this.sameUrlMessage = sameUrlMessage;
      this.keyboardShortcuts = keyboardShortcuts;

      // Resolve potential conflicts with other libraries and assign hotkeys to a variable
      this.hotkey = hotkeys.noConflict();

      // Assign hotkeys to the window object for global access
      window.hotkeys = this.hotkey;

      // Initialize the module (apply custom icons)
      this.init();
    }

    /**
     * Initialize keyboard shortcuts.
     */
    init() {
      if (this.keyboardShortcuts) {
        for (let key in this.keyboardShortcuts) {
          this.mapHotkey(key, this.keyboardShortcuts[key]);
        }
      }
    }

    /**
     * Map a single hotkey to an action.
     * @param {string} key - The key combination.
     * @param {Object} shortcut - The shortcut object containing scope, action, and target.
     */
    mapHotkey(key, shortcut) {
      this.hotkey.setScope(shortcut.scope);

      this.hotkey(key, (event, handler) => {
        const action = shortcut.action.toLowerCase();
        let target = shortcut.target;

        if (action) {
          switch (action) {
            case "navigate":
              this.navigate(target);
              break;
            case "alert":
              this.showAlert(target);
              break;
            default:
              console.warn("Unknown action:", action);
          }
        }
      });
    }

    /**
     * Navigate to the target URL.
     * @param {string} target - The target URL.
     */
    navigate(target) {
      target = this.backendUrl + target;
      if (target !== window.location.href) {
        window.location.href = target;
      } else {
        window?.toaster?.toast("info", this.sameUrlMessage);
      }
    }

    /**
     * Show an alert with the target message.
     * @param {string} target - The target message.
     */
    showAlert(target) {
      alert(target);
    }
  }

  // Return the KeyboardShortcuts class for module use
  return KeyboardShortcuts;
});
