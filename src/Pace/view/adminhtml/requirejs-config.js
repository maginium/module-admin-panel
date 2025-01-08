var config = {
  paths: {
    // Define the alias for the Pace library
    pace: "Maginium_AdminPace/js/pace.min", // Adjust the path as per your directory structure
  },
  shim: {
    // Ensure that Pace is properly initialized as a dependency
    pace: {
      exports: "Pace",
    },
  },
};
