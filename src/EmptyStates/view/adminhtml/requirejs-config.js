var config = {
  // Configuration for JavaScript mapping
  map: {
    // Global mapping configuration (* represents all modules)
    "*": {
      // Override the default template path for grid listing
      "ui/template/grid/listing.html": "Maginium_AdminEmptyStates/template/grid/listing.html",

      // Map the 'entityName' module to a specific JavaScript file
      entityName: "Maginium_AdminEmptyStates/js/listing",
    },
  },
};
