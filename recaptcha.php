<?php
/*!
 * Traq
 * Copyright (C) 2009-2015 Traq.io
 *
 * This file is part of Traq.
 *
 * Traq is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; version 3 only.
 *
 * Traq is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Traq. If not, see <http://www.gnu.org/licenses/>.
 */

namespace traq\plugins;

/**
 * reCAPTCHA plugin for Traq 3.x
 *
 * @author Jack P.
 * @version 1.0
 * @package traq\plugins\Recaptcha
 */
class Recaptcha extends \traq\libraries\Plugin
{
    /**
     * @var array
     */
    protected static $info = array(
        'name'    => "reCAPTCHA",
        'version' => "1.0",
        'author'  => "Jack P."
    );

    /**
     * Initialise hooks.
     */
    public static function init()
    {

    }

    /**
     * Script include for page header.
     */
    public static function scriptInc()
    {
        return "<script src='https://www.google.com/recaptcha/api.js'></script>";
    }

    /**
     * reCAPTCHA field for registration form.
     */
    public static function registerField()
    {
        return "<div class=\"g-recaptcha\" data-sitekey=\"{$site_key}\"></div>";
    }

    /**
     * Confirm. Not yet implemented.
     */
    public static function confirm()
    {
        // send request to: https://www.google.com/recaptcha/api/siteverify
        // with: secret key, response (g-recaptcha-response) and users IP.
    }

    /**
     * Create settings rows.
     */
    public static function __install()
    {
        Database::connection()
            ->insert(array('setting' => 'recaptcha_site_key', 'value'   => ''))
            ->into('settings')->exec();

        Database::connection()
            ->insert(array('setting' => 'recaptcha_secret_key', 'value'   => ''))
            ->into('settings')->exec();
    }

    /**
     * Remove settings rows.
     */
    public static function __uninstall()
    {
        Database::connection()->delete()
            ->from('settings')->where('setting', 'recaptcha_site_key')->exec();

        Database::connection()->delete()
            ->from('settings')->where('setting', 'recaptcha_secret_key')->exec();
    }
}
