<?php
/**
 * Plugin Name: NW Media Fields
 * Description: Lightweight reusable media fields for WordPress.
 * Version: 0.1.0
 * Author: Neil Williams
 */

defined('ABSPATH') || exit;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/functions.php';

NW\MediaFields\Plugin::init();