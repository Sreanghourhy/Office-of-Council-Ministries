const trimTrailingSlash = (value = "") => value.replace(/\/+$/, "");

export function getPublicPortalBaseUrl() {
  const configuredBaseUrl = `${import.meta.env.VITE_PUBLIC_PORTAL_URL || ""}`.trim();

  if (configuredBaseUrl.length > 0) {
    return trimTrailingSlash(configuredBaseUrl);
  }

  if (typeof window !== "undefined" && window.location?.origin) {
    return trimTrailingSlash(window.location.origin);
  }

  return "";
}

export function getOfficerPublicCardUrl(recordOrKey) {
  const key =
    typeof recordOrKey === "string" || typeof recordOrKey === "number"
      ? `${recordOrKey}`.trim()
      : `${recordOrKey?.public_key || recordOrKey?.id || ""}`.trim();

  const baseUrl = getPublicPortalBaseUrl();

  return key.length > 0 ? `${baseUrl}/#/officer/card/${key}` : `${baseUrl}/#/officer/card`;
}
