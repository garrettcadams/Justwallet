<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core Config File
 */

// Site Details
$config['site_version']          = "2.0.4";          // this version Just Deal
$config['themes_folder']         = "assets/themes";  // folder containing themes
$config['public_theme']          = "escrow";         // folder public theme
$config['account_theme']         = "account";        // folder account theme
$config['admin_theme']           = "modular_just";   // folder containing your admin theme
$config['captcha_folder']        = "assets/captcha"; // folder to save CAPTCHA images - must have write permission

// Pagination
$config['num_links']             = 8;
$config['full_tag_open']         = "<div class=\"pagination\">";
$config['full_tag_close']        = "</div>";

// Login Attempts
$config['login_max_time']        = 10;               // in seconds
$config['login_max_attempts']    = 3;

// Miscellaneous
$config['profiler']              = FALSE;
$config['error_delimeter_left']  = "";
$config['error_delimeter_right'] = "<br />";
