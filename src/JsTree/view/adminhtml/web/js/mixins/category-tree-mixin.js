/**
 * Module to extend the functionality of category tree widget in Magento.
 *
 * This module defines a mixin that adds custom functionality to the category tree widget,
 * specifically enabling the dots theme for the tree.
 *
 * @module Maginium_CategoryTreeWidget
 * @requires jquery
 */
define(["jquery"], function ($) {
  "use strict";

  /**
   * Mixin to extend the category tree widget functionality.
   *
   * This mixin modifies the `_create` method of the widget to enable the "dots" theme for the tree.
   * The theme provides visual dots for tree nodes.
   *
   * @mixin CategoryTreeWidgetMixin
   */
  var CategoryTreeWidgetMixin = {
    /**
     * Override the `_create` method of the category tree widget.
     *
     * This method is executed when the widget is created, and here we enable the "dots" theme for the tree.
     * This adds a visual style to the tree nodes (dots representing nodes).
     *
     * @function _create
     */
    _create: function () {
      // Set the tree's theme to have dots for the nodes
      this.options.tree.themes.dots = true;

      // Call the parent class's `_create` method to ensure default behavior is maintained
      this._super();
    },
  };

  /**
   * Create and initialize the custom category tree widget.
   *
   * This function enhances the target widget by applying the `CategoryTreeWidgetMixin`,
   * which customizes the tree's appearance and behavior.
   *
   * @function
   * @param {Object} targetWidget - The widget to be enhanced with custom functionality.
   * @returns {Object} - The enhanced category tree widget.
   */
  return function (targetWidget) {
    // Define the custom widget with the applied mixin
    $.widget("mage.categoryTree", targetWidget, CategoryTreeWidgetMixin);

    // Return the customized category tree widget
    return $.mage.categoryTree;
  };
});
