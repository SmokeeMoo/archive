<?php
/*
 * @copyright Copyright (c) 2023 AltumCode (https://altumcode.com/)
 *
 * This software is exclusively sold through https://altumcode.com/ by the AltumCode author.
 * Downloading this product from any other sources and running it without a proper license is illegal,
 *  except the official ones linked from https://altumcode.com/.
 */

namespace Altum\Controllers;

use Altum\Alerts;

class AdminBiolinkTemplateCreate extends Controller {

    public function index() {

        if(!empty($_POST)) {
            /* Filter some the variables */
            $_POST['link_id'] = (int) $_POST['link_id'];
            $_POST['name'] = input_clean($_POST['name']);
            $_POST['url'] = input_clean($_POST['url']);
            $_POST['order'] = (int) $_POST['order'] ?? 0;
            $_POST['is_enabled'] = (int) isset($_POST['is_enabled']);

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            /* Check for errors & process potential uploads */
            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!db()->where('link_id', $_POST['link_id'])->where('type', 'biolink')->getOne('links')) {
                Alerts::add_field_error('link_id', l('admin_biolinks_templates.error_message.link_id'));
            }

            $image_new_name = \Altum\Uploads::process_upload(null, 'biolinks_templates', 'image', 'image_remove', null);

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                $settings = json_encode([]);

                /* Database query */
                db()->insert('biolinks_templates', [
                    'link_id' => $_POST['link_id'],
                    'name' => $_POST['name'],
                    'url' => $_POST['url'],
                    'image' => $image_new_name ?? null,
                    'settings' => $settings,
                    'is_enabled' => $_POST['is_enabled'],
                    'order' => $_POST['order'],
                    'datetime' => \Altum\Date::$date,
                ]);

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.create1'), '<strong>' . $_POST['name'] . '</strong>'));

                /* Clear the cache */
                cache()->deleteItem('biolinks_templates');

                redirect('admin/biolinks-templates');
            }
        }

        $values = [
            'name' => $_POST['name'] ?? null,
            'url' => $_POST['url'] ?? null,
            'link_id' => $_POST['link_id'] ?? null,
            'order' => $_POST['order'] ?? 0,
            'is_enabled' => $_POST['is_enabled'] ?? 1,
        ];

        /* Main View */
        $data = [
            'values' => $values,
        ];

        $view = new \Altum\View('admin/biolink-template-create/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
