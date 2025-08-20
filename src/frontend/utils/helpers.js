export const parseMetadata = (metadataString) => {
  if (!metadataString) return {};
  
  try {
    return JSON.parse(metadataString);
  } catch (e) {
    console.error('Failed to parse metadata:', e);
    return {};
  }
};