=== ceLTIc LTI Library ===
Contributors: spvickers
Tags: lti, ims, learning tools interoperability, celtic
Requires at least: 5.9
Tested up to: 6.5
Requires PHP: 8.1
Stable tag: 5.0.2
License: GNU General Public License Version 3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

This plugin installs the ceLTIc LTI class library for use by other plugins which use the IMS Learning Tools Interoperability specification.

== Description ==
The IMS Learning Tools Interoperability (LTI) specification provides a standard, secure method by which a platform (e.g. an Learning Management System) can be seamlessly integrated with a tool.  This library plugin provides the support required to allow other plugins to enable WordPress to act as either a platform (so that a blog can be integrated with other content or learning activities) or as a tool (so that a platform can integrate a WordPress blog into their user experience).  For example, the [open source LTI plugin](https://github.com/celtic-project/wordpress-lti/) supports enabling WordPress as a tool.

== Installation ==
This plugin has no user interface; it merely loads the ceLTIc LTI library and any dependencies so that they are available for use by other plugins.  Just activate it to have the library loaded for any other plugins you wish to activate which use it.

== Frequently Asked Questions ==

= Why do I need this plugin? =

If you use a plugin which uses the ceLTIc LTI library, this plugin provides an alternative from using composer to install this dependent library for each individual plugin, and avoids the need for server access to do so.  It also avoids having multiple versions of the library installed and makes it easy to keep the library up-to-date when new releases are made.

= Will my other LTI plugins work without this one? =

This will depend upon how the plugins have been written, but the [LTI plugin](https://github.com/celtic-project/wordpress-lti/) will look for the ceLTIc LTI library either within its own dependent library area or use one loaded elsewhere, whichever is loaded first.  This plugin will not affect any plugins which do not use the ceLTIc LTI library.

== Changelog ==

See the [library's version history](https://github.com/celtic-project/LTI-PHP/wiki/Version-history).

= 4.6.2 =

First release as a WordPress plugin.

= 4.6.3 =

* Update UserResult->getId for users not associated with a resource link
* Update to latest release of Firebase/php-jwt library
* Minor bug fixes

= 4.6.4 =

Fix bug with handling public keys in PEM format in Firebase JWT client
Enhance JWT clients
Enhance handling of Content items

= 4.6.5 =

Remove erroneous GROUP BY clauses in SQL for data connectors
Improve debug logging for missing message handlers

= 4.7.0 =

Fix bug with checking state value on LTI 1.3 messages
Add support for groups to belong to more than one groupset (so set element of a group may now be an array of strings rather than just a string)
Correct value of iss claim in client_assertion JWT when requesting an access token
Add option to allow use of HTTP GET for LTI 1.3 authentication requests
Improve mapping between JWT claims and OAuth1 message parameters (uses "lti1p1_" prefix for any "https://purl.imsglobal.org/spec/lti/claim/lti1p1" claims; added "target_link_uri" and "unmapped_claims" parameters)

= 4.7.1 =

Fix bug with format of JWT claim using FirebaseClient

= 4.7.2 =

Fix mapping of LTI 1.3 claim for Basic Outcomes service
Add check for Course Groups service in `getMemberships` method
Added checks for required properties of optional message claims
Fix bug with updating date of last access for a platform
Fix handling of groups belonging to more than one group in Moodle API hook
Deprecated CanvasApiToolProvider class (use CanvasApiTool instead)
Fix signing of extension service requests with LTI 1.3

= 4.7.3 =

Ignore namespace in XML service responses
Fix bug with supported messages in platform configurations
Add support for username passed by Brightspace
Allow Context to be passed to UserResult->getId method
Add HTTP version override option to CurlClient
Improve logging for PDO database connections

= 4.8.0 =

Added check for blocked third-party cookies
Added option to generate warnings about any additional errors identified
Added support for user's middle name
Other code improvements

= 4.9.0 =

Ensure Memberships service saves all learners
Registration access token is optional
Added support for using Memcache to handle nonce values

= 4.10.0 =

Add workaround for Anthology Learn bug in Names and Role Provisioning services
Add support for draft "OIDC Login with LTI Client Side postMessages" specification
Add support for Firebase PHP-JWT 6.0.0
Fix bug with saving learners when no lis_result_sourcedid is provided
Retain Moodle groupings with no groups
Add middle name to Assessment Platform verified claims
Add support for submission review message
Make life of launch state values a platform property
Fix support for LTI 1.3 TeachingAssistant role URI
Add new core role methods to Tool object: isInstructor, isContentDeveloper, isTeachingAssistant, isManager, isMember, isOfficer, isMentor

= 4.10.2 =

Miscellaneous bug fixes
Change default lti_message_hint to none
Add support for X_ORIGINAL_HOST header
Allow tools to disable use of platform storage
Add check for invalid context and resource link ID values
Improve method for parsing roles

= 5.0.0 =

Updated to require PHP 8.1

= 5.0.1 =

Allow resourceLink to be null for a UserResult object
Fix bug when error occurs with call to Result service in ResourceLink->doOutcomesService
Fix tests for missing parameters with LtiSubmissionReviewRequest message
Do not enable LTI 2 platforms by default
Correct return type for Tool::findService method
Avoid creation of platform record when LTI 2 not supported by tool
Fix data type errors
Use ServiceDefinition class for ToolProxy service
Set default alg value when parsing a key with Firebase JWT client

= 5.0.2 =

Miscellaneous fixes for PHP 8.1 related issues
Allow full URL for icon in tool registration
