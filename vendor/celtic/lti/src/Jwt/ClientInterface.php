<?php
declare(strict_types=1);

namespace ceLTIc\LTI\Jwt;

/**
 * Interface to represent an HWT client
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license   GNU Lesser General Public License, version 3 (<http://www.gnu.org/licenses/lgpl.html>)
 */
interface ClientInterface
{

    /**
     * Return an array of supported signature algorithms.
     *
     * @return string[]  Array of algorithm names
     */
    public static function getSupportedAlgorithms(): array;

    /**
     * Check if a JWT is defined.
     *
     * @return bool  True if a JWT is defined
     */
    public function hasJwt(): bool;

    /**
     * Check if a JWT's content is encrypted.
     *
     * @return bool  True if a JWT is encrypted
     */
    public function isEncrypted(): bool;

    /**
     * Load a JWT from a string.
     *
     * @param string $jwtString        JWT string
     * @param string|null $privateKey  Private key in PEM format for decrypting encrypted tokens (optional)
     *
     * @return bool  True if the JWT was successfully loaded
     */
    public function load(string $jwtString, ?string $privateKey = null): bool;

    /**
     * Get the value of the JWE headers.
     *
     * @return array  The value of the JWE headers
     */
    public function getJweHeaders(): array;

    /**
     * Check whether a JWT has a header with the specified name.
     *
     * @param string $name  Header name
     *
     * @return bool  True if the JWT has a header of the specified name
     */
    public function hasHeader(string $name): bool;

    /**
     * Get the value of the header with the specified name.
     *
     * @param string $name               Header name
     * @param string|null $defaultValue  Default value
     *
     * @return string|null  The value of the header with the specified name, or the default value if it does not exist
     */
    public function getHeader(string $name, ?string $defaultValue = null): ?string;

    /**
     * Get the value of the headers.
     *
     * @return array  The value of the headers
     */
    public function getHeaders(): array|object;

    /**
     * Get the value of the headers for the last signed JWT (before any encryption).
     *
     * @return array  The value of the headers
     */
    public static function getLastHeaders(): array;

    /**
     * Check whether a JWT has a claim with the specified name.
     *
     * @param string $name  Claim name
     *
     * @return bool  True if the JWT has a claim of the specified name
     */
    public function hasClaim(string $name): bool;

    /**
     * Get the value of the claim with the specified name.
     *
     * @param string $name                                     Claim name
     * @param int|string|bool|array|object|null $defaultValue  Default value
     *
     * @return int|string|bool|array|object|null  The value of the claim with the specified name, or the default value if it does not exist
     */
    public function getClaim(string $name, int|string|bool|array|object|null $defaultValue = null): int|string|bool|array|object|null;

    /**
     * Get the value of the payload.
     *
     * @return array  The value of the payload
     */
    public function getPayload(): array|object;

    /**
     * Get the value of the payload for the last signed JWT (before any encryption).
     *
     * @return array  The value of the payload
     */
    public static function getLastPayload(): array;

    /**
     * Verify the signature of the JWT.
     *
     * @param string|null $publicKey  Public key of issuer
     * @param string|null $jku        JSON Web Key URL of issuer (optional)
     *
     * @return bool True if the JWT has a valid signature
     */
    public function verify(?string $publicKey, ?string $jku = null): bool;

    /**
     * Sign the JWT.
     *
     * @param array $payload                 Payload
     * @param string $signatureMethod        Signature method
     * @param string $privateKey             Private key in PEM format
     * @param string|null $kid               Key ID (optional)
     * @param string|null $jku               JSON Web Key URL (optional)
     * @param string|null $encryptionMethod  Encryption method (optional)
     * @param string|null $publicKey         Public key of recipient for content encryption (optional)
     *
     * @return string  Signed JWT
     */
    public static function sign(array $payload, string $signatureMethod, string $privateKey, ?string $kid = null,
        ?string $jku = null, ?string $encryptionMethod = null, ?string $publicKey = null): string;

    /**
     * Generate a new private key in PEM format.
     *
     * @param string $signatureMethod  Signature method
     *
     * @return string|null  Key in PEM format
     */
    public static function generateKey(string $signatureMethod = 'RS256'): ?string;

    /**
     * Get the public key for a private key.
     *
     * @param string $privateKey  Private key in PEM format
     *
     * @return string|null  Public key in PEM format
     */
    public static function getPublicKey(string $privateKey): ?string;

    /**
     * Get the public JWKS from a key in PEM format.
     *
     * @param string $pemKey           Private or public key in PEM format
     * @param string $signatureMethod  Signature method
     * @param string|null $kid         Key ID (optional)
     *
     * @return array  JWKS keys
     */
    public static function getJWKS(string $pemKey, string $signatureMethod, ?string $kid = null): array;
}
