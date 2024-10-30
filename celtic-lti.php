<?php
/*
  Plugin Name: ceLTIc LTI Library
  Plugin URI: https://github.com/celtic-project/LTI-PHP
  Description: This plugin to installs the ceLTIc LTI class library for use by other plugins.
  Version: 5.0.2
  Network: true
  Requires at least: 5.9
  Requires PHP: 8.1
  Author: Stephen P Vickers
  License: GPL3
 */

/*
 *  celtic-lti - WordPress plugin to install the ceLTIc LTI class library
 *  Copyright (C) 2024  Stephen P Vickers
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 *
 *  Contact: stephen@spvsoftwareproducts.com
 */

// Prevent loading this file directly
defined('ABSPATH') || exit;

// include the LTI library classes
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
