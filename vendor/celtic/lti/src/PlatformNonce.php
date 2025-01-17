<?php
declare(strict_types=1);

namespace ceLTIc\LTI;

/**
 * Class to represent a platform nonce
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3
 */
class PlatformNonce
{

    /**
     * Maximum age nonce values will be retained for (in minutes).
     */
    public const MAX_NONCE_AGE = 30;  // in minutes

    /**
     * Maximum length which can be stored.
     *
     * Characters are removed from the beginning of the value when too long.
     *
     * @var int $maximumLength
     */
    public static int $maximumLength = 50;

    /**
     * Timestamp for when the nonce value expires.
     *
     * @var int $expires
     */
    public int $expires;

    /**
     * Platform to which this nonce applies.
     *
     * @var Platform $platform
     */
    private Platform $platform;

    /**
     * Nonce value.
     *
     * @var string|null $value
     */
    private ?string $value = null;

    /**
     * Class constructor.
     *
     * @param Platform $platform  Platform object
     * @param string|null $value  Nonce value (optional, default is null)
     */
    public function __construct(Platform $platform, ?string $value = null)
    {
        $this->platform = $platform;
        $this->value = substr($value, -self::$maximumLength);
        $this->expires = time() + (self::MAX_NONCE_AGE * 60);
    }

    /**
     * Load a nonce value from the database.
     *
     * @return bool  True if the nonce value was successfully loaded
     */
    public function load(): bool
    {
        return $this->platform->getDataConnector()->loadPlatformNonce($this);
    }

    /**
     * Save a nonce value in the database.
     *
     * @return bool  True if the nonce value was successfully saved
     */
    public function save(): bool
    {
        return $this->platform->getDataConnector()->savePlatformNonce($this);
    }

    /**
     * Delete a nonce value in the database.
     *
     * @return bool  True if the nonce value was successfully deleted
     */
    public function delete(): bool
    {
        return $this->platform->getDataConnector()->deletePlatformNonce($this);
    }

    /**
     * Get platform.
     *
     * @return Platform  Platform for this nonce
     */
    public function getPlatform(): Platform
    {
        return $this->platform;
    }

    /**
     * Get nonce value.
     *
     * @return string|null  Nonce value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

}
