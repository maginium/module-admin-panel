/**
 * Converts a layout name into a clean, normalized entity name.
 * @param {string} nameInLayout - The input layout name to convert.
 * @returns {string} The normalized entity name.
 */
function getEntityName(nameInLayout) {
  // First replace "newslettrer" with "newsletter"
  let entityName = nameInLayout.replace("newslettrer", "newsletter");

  // Replace underscores (_) with dashes (-)
  entityName = entityName.replace(/_/g, "-");

  // Remove unwanted substrings
  entityName = entityName.replace(/(adminhtml|block|columnSet|grid|container|system|view|columns|edit|tab|admin)/g, "");

  // Replace dots (.) with dashes (-)
  entityName = entityName.replace(/\./g, "-");

  // Replace multiple consecutive dashes with a single dash
  entityName = entityName.replace(/-+/g, "-");

  // Trim leading and trailing dashes
  entityName = entityName.replace(/^-|-$/g, "");

  // Convert to lowercase
  entityName = entityName.toLowerCase();

  // Split the entityName into parts
  let parts = entityName.split("-");

  // Deduplicate parts
  let deduplicatedParts = [];
  let seenParts = {}; // Use an object to track seen parts

  for (let part of parts) {
    if (!seenParts[part]) {
      // Check if the part hasn't been seen
      deduplicatedParts.push(part);
      seenParts[part] = true; // Mark this part as seen
    }
  }

  // Join the deduplicated parts with dashes
  entityName = deduplicatedParts.join("-");

  return entityName;
}
