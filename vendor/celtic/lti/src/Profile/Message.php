<?php
declare(strict_types=1);

namespace ceLTIc\LTI\Profile;

/**

 * Class to represent a resource handler message object
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3
 */
class Message
{

    /**
     * LTI message type.
     *
     * @var string|null $type
     */
    public ?string $type = null;

    /**
     * Path to send message request to (used in conjunction with a base URL for the Tool).
     *
     * @var string|null $path
     */
    public ?string $path = null;

    /**
     * Capabilities required by message.
     *
     * @var array|null $capabilities
     */
    public ?array $capabilities = null;

    /**
     * Variable parameters to accompany message request.
     *
     * @var array|null $variables
     */
    public ?array $variables = null;

    /**
     * Fixed parameters to accompany message request.
     *
     * @var array|null $constants
     */
    public ?array $constants = null;

    /**
     * Class constructor.
     *
     * @param string $type         LTI message type
     * @param string $path         Path to send message request to
     * @param array $capabilities  Array of capabilities required by message
     * @param array $variables     Array of variable parameters to accompany message request
     * @param array $constants     Array of fixed parameters to accompany message request
     */
    function __construct(string $type, string $path, array $capabilities = [], array $variables = [], array $constants = [])
    {
        $this->type = $type;
        $this->path = $path;
        $this->capabilities = $capabilities;
        $this->variables = $variables;
        $this->constants = $constants;
    }

}
