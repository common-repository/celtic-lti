<?php
declare(strict_types=1);

namespace ceLTIc\LTI\Service;

use ceLTIc\LTI\Context;
use ceLTIc\LTI\User;

/**
 * Class to implement the Course Groups service
 *
 * @author  Stephen P Vickers <stephen@spvsoftwareproducts.com>
 * @copyright  SPV Software Products
 * @license  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3
 */
class Groups extends Service
{

    /**
     * Media type for course group sets service.
     */
    public const MEDIA_TYPE_COURSE_GROUP_SETS = 'application/vnd.ims.lti-gs.v1.contextgroupsetcontainer+json';

    /**
     * Media type for course groups service.
     */
    public const MEDIA_TYPE_COURSE_GROUPS = 'application/vnd.ims.lti-gs.v1.contextgroupcontainer+json';

    /**
     * Access scope.
     *
     * @var string $SCOPE
     */
    public static string $SCOPE = 'https://purl.imsglobal.org/spec/lti-gs/scope/contextgroup.readonly';

    /**
     * Default limit on size of container to be returned from requests.
     *
     * @var int|null $defaultLimit
     */
    public static ?int $defaultLimit = null;

    /**
     * The context to which the course groups apply.
     *
     * @var Context|null $context
     */
    private ?Context $context = null;

    /**
     * The endpoint for course group requests.
     *
     * @var string|null $groupsEndpoint
     */
    private ?string $groupsEndpoint = null;

    /**
     * The endpoint for course groupset requests.
     *
     * @var string|null $groupSetsEndpoint
     */
    private ?string $groupSetsEndpoint = null;

    /**
     * Limit on size of container to be returned from requests.
     *
     * A limit of null (or zero) will disable paging of requests
     *
     * @var int|null  $limit
     */
    private ?int $limit;

    /**
     * Whether requests should be made one page at a time when a limit is set.
     *
     * When false, all objects will be requested, even if this requires several requests based on the limit set.
     *
     * @var bool  $pagingMode
     */
    private bool $pagingMode;

    /**
     * Class constructor.
     *
     * @param object $context                 The context to which the course groups apply
     * @param string|null $groupsEndpoint     Service endpoint for course groups
     * @param string|null $groupSetsEndpoint  Service endpoint for course group sets (optional)
     * @param int|null $limit                 Limit of objects to be returned in each request, null for all
     * @param bool $pagingMode                True if only a single page should be requested when a limit is set
     */
    public function __construct(Context $context, ?string $groupsEndpoint, ?string $groupSetsEndpoint = null, ?int $limit = null,
        bool $pagingMode = false)
    {
        $platform = $context->getPlatform();
        parent::__construct($platform, $groupsEndpoint);
        $this->scope = self::$SCOPE;
        $this->mediaType = self::MEDIA_TYPE_COURSE_GROUPS;
        $this->context = $context;
        $this->groupsEndpoint = $groupsEndpoint;
        $this->groupSetsEndpoint = $groupSetsEndpoint;
        $this->limit = $limit;
        $this->pagingMode = $pagingMode;
    }

    /**
     * Get the course group sets and groups.
     *
     * @param bool $allowNonSets  Include groups which are not part of a set (optional)
     * @param User|null $user     Limit response to groups for specified user (optional)
     * @param int|null $limit     Limit on the number of objects to be returned in each request, null for service default (optional)
     *
     * @return bool  True if the operation was successful
     */
    public function get(bool $allowNonSets = false, ?User $user = null, ?int $limit = null): bool
    {
        $ok = $this->getGroupSets($limit);
        if ($ok) {
            $ok = $this->getGroups($allowNonSets, $user, $limit);
        }
        if (!$ok) {
            $this->context->groupSets = null;
            $this->context->groups = null;
        }

        return $ok;
    }

    /**
     * Get the course group sets.
     *
     * @param int|null $limit  Limit on the number of course group sets to be returned in each request, null for service default (optional)
     *
     * @return bool  True if the operation was successful
     */
    public function getGroupSets(?int $limit = null): bool
    {
        $this->endpoint = $this->groupSetsEndpoint;
        $ok = !empty($this->endpoint);
        if ($ok) {
            $this->mediaType = self::MEDIA_TYPE_COURSE_GROUP_SETS;
            $parameters = [];
            if (is_null($limit)) {
                $limit = $this->limit;
            }
            if (is_null($limit)) {
                $limit = self::$defaultLimit;
            }
            if (!empty($limit)) {
                $parameters['limit'] = strval($limit);
            }
            $this->context->groupSets = [];
            $groupSets = [];
            $endpoint = $this->endpoint;
            do {
                $http = $this->send('GET', $parameters);
                $ok = !empty($http) && $http->ok;
                $url = '';
                if ($ok) {
                    if (isset($http->responseJson->sets)) {
                        foreach ($http->responseJson->sets as $set) {
                            $groupSets[$set->id] = [
                                'title' => $set->name,
                                'groups' => [],
                                'num_members' => 0,
                                'num_staff' => 0,
                                'num_learners' => 0
                            ];
                        }
                    }
                    if (!$this->pagingMode && $http->hasRelativeLink('next')) {
                        $url = $http->getRelativeLink('next');
                        $this->endpoint = $url;
                        $parameters = [];
                    }
                }
            } while ($url);
            $this->endpoint = $endpoint;
            if ($ok) {
                $this->context->groupSets = $groupSets;
            }
        }

        return $ok;
    }

    /**
     * Get the course groups.
     *
     * @param bool $allowNonSets  Include groups which are not part of a set (optional)
     * @param User|null $user     Limit response to groups for specified user (optional)
     * @param int|null $limit     Limit on the number of course groups to be returned in each request, null for service default (optional)
     *
     * @return bool  True if the operation was successful
     */
    public function getGroups(bool $allowNonSets = false, ?User $user = null, ?int $limit = null): bool
    {
        $this->endpoint = $this->groupsEndpoint;
        $ok = !empty($this->endpoint);
        if ($ok) {
            $this->mediaType = self::MEDIA_TYPE_COURSE_GROUPS;
            $parameters = [];
            $ltiUserId = null;
            if (!empty($user) && !empty($user->ltiUserId)) {
                $ltiUserId = $user->ltiUserId;
            }
            if (!empty($ltiUserId)) {
                $parameters['user_id'] = $ltiUserId;
            }
            if (is_null($limit)) {
                $limit = $this->limit;
            }
            if (is_null($limit)) {
                $limit = self::$defaultLimit;
            }
            if (!empty($limit)) {
                $parameters['limit'] = strval($limit);
            }
            if (is_null($this->context->groupSets)) {
                $groupSets = [];
            } else {
                $groupSets = $this->context->groupSets;
            }
            $groups = [];
            $endpoint = $this->endpoint;
            do {
                $http = $this->send('GET', $parameters);
                $ok = !empty($http) && $http->ok;
                $url = '';
                if ($ok) {
                    if (isset($http->responseJson->groups)) {
                        foreach ($http->responseJson->groups as $agroup) {
                            if (!$allowNonSets && empty($agroup->set_id)) {
                                continue;
                            }
                            $group = [
                                'title' => $agroup->name
                            ];
                            if (!empty($agroup->set_id)) {
                                if (!array_key_exists($agroup->set_id, $groupSets)) {
                                    $groupSets[$agroup->set_id] = [
                                        'title' => "Set {$agroup->set_id}",
                                        'groups' => [],
                                        'num_members' => 0,
                                        'num_staff' => 0,
                                        'num_learners' => 0
                                    ];
                                }
                                $groupSets[$agroup->set_id]['groups'][] = $agroup->id;
                                $group['set'] = $agroup->set_id;
                            }
                            if (!empty($agroup->tag)) {
                                $group['tag'] = $agroup->tag;
                            }
                            $groups[$agroup->id] = $group;
                        }
                    }
                    if (!$this->pagingMode && $http->hasRelativeLink('next')) {
                        $url = $http->getRelativeLink('next');
                        $this->endpoint = $url;
                        $parameters = [];
                    }
                }
            } while ($url);
            $this->endpoint = $endpoint;
            if ($ok) {
                $this->context->groupSets = $groupSets;
                if (empty($ltiUserId)) {
                    $this->context->groups = $groups;
                } else {
                    $user->groups = $groups;
                }
            }
        }

        return $ok;
    }

}
