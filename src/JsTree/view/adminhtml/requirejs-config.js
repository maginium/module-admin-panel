/**
 * Configuration file for Magento JS module integration.
 *
 * This configuration defines paths for custom JavaScript libraries and sets up mixins
 * to extend the behavior of existing Magento JS modules.
 */
var config = {
  /**
   * Define custom paths for JavaScript libraries used in the module.
   *
   * These paths allow Magento to locate and load the specified JavaScript files from
   * the correct location within the custom module.
   */
  paths: {
    /**
     * Path for the jstree library.
     *
     * This is used to load the jstree library, which is a tree view plugin,
     * from the `Maginium_AdminJsTree/lib/jstree/jstree.js` file.
     */
    categoryJSTree: "Maginium_AdminJsTree/lib/jstree/jstree",
  },

  /**
   * Configuration for module mixins in Magento.
   *
   * Mixins allow you to modify or extend the behavior of existing JavaScript modules
   * without modifying their original code directly.
   */
  config: {
    /**
     * Define the mixins for Magento JS modules.
     *
     * In this case, we are extending the functionality of the Magento_Catalog's category tree widget.
     */
    mixins: {
      /**
       * The target module being extended.
       *
       * This is the path to the `category-tree` JS module in Magento_Catalog.
       */
      "Magento_Catalog/js/category-tree": {
        /**
         * The mixin module applied to the target module.
         *
         * This mixin will modify or extend the behavior of the `category-tree` module.
         * The path points to the custom mixin file located in the `Maginium_AdminJsTree/js/mixins/`.
         */
        "Maginium_AdminJsTree/js/mixins/category-tree-mixin": true,
      },
    },
  },
};
