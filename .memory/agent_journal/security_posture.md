# Security Posture

## Findings & Technical Debt

### External Telemetry
* **Issue:** Freemius API pings are being sent externally.
* **Context:** Part of the core Freemius SDK functionality.

### Insecure SSL Fallbacks
* **Issue:** Insecure SSL fallbacks detected.
* **Location:** `class-freemius.php` at Line 2244.
* **Risk:** Potential for man-in-the-middle attacks during communication with Freemius servers.

### Disabled SSL Verification
* **Issue:** `sslverify` is disabled in the Clone Manager.
* **Location:** `class-freemius.php` at Line 144.
* **Risk:** Compromises the integrity of the connection during sensitive operations.
