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

namespace reCAPTCHA\controllers;

use avalon\http\Request;
use avalon\output\View;
use traq\models\Setting;

/**
 * reCAPTCHA plugin settings controller.
 *
 * @author Jack P.
 * @package reCAPTCHA
 * @subpackage Controllers
 */
class Settings extends \traq\controllers\admin\AppController
{
    /**
     * Settings page.
     */
    public function action_index()
    {
        // Set page title
        $this->title(l('recaptcha'));

        // Save
        if (Request::method() == 'post') {
            $siteKey = Setting::find('setting', 'recaptcha_site_key');
            $secretKey = Setting::find('setting', 'recaptcha_secret_key');

            $siteKey->value = Request::post('recaptcha_site_key');
            $secretKey->value = Request::post('recaptcha_secret_key');

            $siteKey->save();
            $secretKey->save();
        }
    }
}
