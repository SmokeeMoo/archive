<?php
/*
 * @copyright Copyright (c) 2023 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\controllers;

use Altum\Models\Domain;

class LinkRedirect extends Controller {

    public function index() {

        $link_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$link = db()->where('link_id', $link_id)->getOne('links', ['link_id', 'domain_id', 'user_id', 'url'])) {
            redirect();
        }

        /* Get the current domain if needed */
        $link->domain = $link->domain_id ? (new Domain())->get_domain_by_domain_id($link->domain_id) : null;

        /* Determine the actual full url */
        $link->full_url = $link->domain ? $link->domain->url . $link->url : SITE_URL . $link->url;

        header('Location: ' . $link->full_url);

        die();

    }
}
