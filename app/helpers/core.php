<?php
/*
 * @copyright Copyright (c) 2023 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

function settings() {
    if(!\Altum\Settings::$settings) {
        \Altum\Settings::initialize();
    }

    return \Altum\Settings::$settings;
}

function get_settings_custom_head_js($key = 'head_js') {
    $head_js = settings()->custom->{$key};

    /* Dynamic variables processing */
    $replacers = [
        '{{USER:USER_ID}}' => json_encode(\Altum\Authentication::check() ? \Altum\Authentication::$user->user_id : ''),
        '{{USER:NAME}}' => json_encode(\Altum\Authentication::check() ? \Altum\Authentication::$user->name : ''),
        '{{USER:EMAIL}}' => json_encode(\Altum\Authentication::check() ? \Altum\Authentication::$user->email : ''),
        '{{USER:PLAN_ID}}' => json_encode(\Altum\Authentication::check() ? \Altum\Authentication::$user->plan_id : ''),
    ];

    $head_js = str_replace(
        array_keys($replacers),
        array_values($replacers),
        $head_js
    );

    return $head_js;
}

function db() {
    if(!\Altum\Database::$db) {
        \Altum\Database::initialize();
    }

    return \Altum\Database::$db;
}

function database() {
    if(!\Altum\Database::$database) {
        \Altum\Database::initialize();
    }

    return \Altum\Database::$database;
}

function language($language = null) {
    return \Altum\Language::get($language);
}

function l($key, $language = null, $null_coalesce = false) {
    return \Altum\Language::get($language)[$key] ?? \Altum\Language::get(\Altum\Language::$main_name)[$key] ?? ($null_coalesce ? null : 'missing_translation: ' . $key);
}

function currency() {
    if(!\Altum\Currency::$currency) {
        \Altum\Currency::initialize();
    }

    return \Altum\Currency::$currency;
}

function cache($adapter = 'adapter') {
    return \Altum\Cache::${$adapter};
}
