<?php
/*!
 * Traq
 * Copyright (C) 2009-2015 Jack P.
 * Copyright (C) 2012-2015 Traq.io
 * https://github.com/nirix
 * http://traq.io
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

use \FishHook;
use \HTML;
use avalon\Autoloader;
use avalon\Database;
use avalon\http\Router;
use avalon\http\Request;
use avalon\output\View;
use traq\models\Setting;

/**
 * reCAPTCHA plugin for Traq 3.x
 *
 * @author Jack P.
 * @version 1.0
 * @package traq\plugins
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
        // Register namespace
        Autoloader::registerNamespace('reCAPTCHA', __DIR__);

        // Register register page hooks
        FishHook::add('template:users/register', array(get_called_class(), 'registerField'));

        // Register routes
        Router::add('/admin/settings/recaptcha', 'reCAPTCHA::controllers::Settings.index');

        // Register navbar tab
        FishHook::add('template:admin/settings/_nav', array(get_called_class(), 'adminNav'));
    }

    /**
     * Adds the link to the settings navbar.
     */
    public static function adminNav()
    {
        echo '<li', iif(active_nav('/admin/settings/recaptcha'), ' class="active"'), '>',
                HTML::link(l('recaptcha'), "/admin/settings/recaptcha"),
             '</li>';
    }

    /**
     * reCAPTCHA field for registration form.
     */
    public static function registerField()
    {
        echo View::render('users/_recaptcha_field');
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
            ->insert(array('setting' => 'recaptcha_site_key', 'value' => ''))
            ->into('settings')->exec();

        Database::connection()
            ->insert(array('setting' => 'recaptcha_secret_key', 'value' => ''))
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
