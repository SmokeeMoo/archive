<?php defined('ALTUMCODE') || die() ?>

<form name="update_biolink_" method="post" role="form">
    <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" required="required" />
    <input type="hidden" name="request_type" value="update" />
    <input type="hidden" name="block_type" value="tmmessengers" />
    <input type="hidden" name="biolink_block_id" value="<?= $row->biolink_block_id ?>" />
    
    <div class="notification-container"></div>
    
        <!-- Start Items -->
    <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmmessengers_items_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmmessengers_items_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmmessengers_modal.items_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmmessengers_items_container_' . $row->biolink_block_id ?>">
    
    <div id="<?= 'tmmessengers_items_' . $row->biolink_block_id ?>" data-biolink-block-id="<?= $row->biolink_block_id ?>">
        <?php foreach($row->settings->items as $key => $item): ?>
        <div class="mb-4">
        
                        <!-- Start block -->
                <div class="d-flex align-items-center "style="border-radius: 6px; padding: 10px; border: 2px solid #d3d3d35e;">	
                    <div class="col-7 col-md-7"> 
                        <div class="d-flex flex-column">
                            <a href="#" data-toggle="collapse" data-target="#<?= 'Contact' . ( $key + 1 ) . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'Contact' . ( $key + 1 )  ?>">
                                <strong><?= !empty($item->title) ? $item->title : l('create_biolink_messengers_modal.market_title.messengers.block') . ' '. ( $key + 1 )  ?></strong>
                            </a>
                            
                            <span class="d-flex align-items-center">
                            </span>
                            
                        </div>
                    </div>	
                    
                    <div class="col-2 col-md-2 d-flex justify-content-end">
                        <a href="#" data-toggle="collapse" data-target="#<?= 'Contact' . ( $key + 1 ). $row->biolink_block_id  ?>" aria-expanded="false" aria-controls="<?= 'Contact' . ( $key + 1 ) . $row->biolink_block_id ?>" >
                            <!--<div class="link-btn-arrow-wrapper-setting2" >		
                                <i class="fas fa-chevron-right "></i>
                                <i class="fas fa-chevron-down "></i>
                            </div> -->
                        </a>                                       
                    </div>
                    <div class="col-3 col-md-3 d-flex justify-content-end">
                        <button type="button" data-remove="item" class="btn btn-block btn-outline-danger" style="display:inline-block; border: none;"><i class="fas fa-fw fa-times"></i></button>
                    </div>
                </div>	
                
                <!-- End block -->
                
				<div class="collapse" id="<?= 'Contact' . ( $key + 1 ) . $row->biolink_block_id  ?>">	
                    <div class="mb-2">
            
            <div class="form-group">
                <label for="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.title') ?></label>
                <input id="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>" type="text" name="item_title[<?= $key ?>]" class="form-control" value="<?= $item->title ?>" required="required" />
            </div>
            
            <div class="form-group">
                <label for="<?= 'item_content_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-pen fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.content') ?></label>
                <input id="<?= 'item_content_' . $key . '_' . $row->biolink_block_id ?>" name="item_content[<?= $key ?>]" class="form-control" maxlength="2048" required="required" value="<?= $item->content ?>" />
            </div>
            
            
            <div class="form-group">
                <label for="<?= 'item_color_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-expand fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.color') ?></label>
                <select id="<?= 'item_color_' . $key . '_' . $row->biolink_block_id ?>" name="item_color[<?= $key ?>]" class="form-control" >
                    <option value="whatsapp" <?= $item->color == 'whatsapp' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmmessengers_modal.whatsapp') ?></option>
                    <option value="facebook" <?= $item->color == 'facebook' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmmessengers_modal.facebook') ?></option>
                    <option value="telegram" <?= $item->color == 'telegram' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmmessengers_modal.telegram') ?></option>
                    <option value="viber" <?= $item->color == 'viber' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmmessengers_modal.viber') ?></option>
                    <option value="skype" <?= $item->color == 'skype' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmmessengers_modal.skype') ?></option>
                    
                </select>
            </div>   
            
            <div class="form-group">
                <label for="<?= 'item_link_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-pen fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.link') ?></label>
                <input id="<?= 'item_link_' . $key . '_' . $row->biolink_block_id ?>" name="item_link[<?= $key ?>]" class="form-control" maxlength="2048" required="required" value="<?= $item->link ?>" />
            </div>
            
            <button type="button" data-remove="item" class="btn btn-block btn-outline-danger"><i class="fas fa-fw fa-times"></i> <?= l('global.delete') ?></button>
        </div>
        </div></div>
        <?php endforeach ?>
    </div>  
        <button data-add="tmmessengers_item" data-biolink-block-id="<?= $row->biolink_block_id ?>" type="button" class="btn btn-sm btn-outline-success"><i class="fas fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
  </div>      
    
    <div class="mb-3">
        <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmmessengers_settings_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmmessengers_settings_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmmessengers_modal.settings_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmmessengers_settings_container_' . $row->biolink_block_id ?>">
    <div class="form-group">
        <label for="<?= 'tmmessengers_text_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-align-center fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.text') ?></label>
        <input id="<?= 'tmmessengers_text_' . $row->biolink_block_id ?>" class="form-control" name="text" placeholder="<?= l('create_biolink_tmmessengers_modal.text.placeholder') ?>" required="required" maxlength="2048" value="<?= $row->settings->text ?>" />
    </div>
    
    <div class="form-group">
        <label for="<?= 'tmmessengers_window_title_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-align-center fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.window_title') ?></label>
        <input id="<?= 'tmmessengers_window_title_' . $row->biolink_block_id ?>" class="form-control" name="window_title" placeholder="<?= l('create_biolink_tmmessengers_modal.window_title.placeholder') ?>" maxlength="2048" required="required" value="<?= $row->settings->window_title ?>" />
    </div>
    
    <div class="form-group">
        <label for="<?= 'tmmessengers_description_window_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-paragraph fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.description_window') ?></label>
        <input id="<?= 'tmmessengers_description_window_' . $row->biolink_block_id ?>" class="form-control" name="description_window" placeholder="<?= l('create_biolink_tmmessengers_modal.description_window.placeholder') ?>" maxlength="2048" required="required" value="<?= $row->settings->description_window ?>" />
    </div>
    
             <div class="custom-control custom-switch mb-3">
                <input 
                id="<?= 'tmmessengers_message' . $row->biolink_block_id ?>" 
                name="message" type="checkbox" 
                class="custom-control-input" <?= $row->settings->message ? 'checked="checked"' : null ?>
                >
                <label class="custom-control-label" for="<?= 'tmmessengers_message' . $row->biolink_block_id ?>"><?= l('create_biolink_tmmessengers_modal.settings_message') ?></label>
            </div>
            
    <div class="form-group">
        <label for="<?= 'tmmessengers_message_placeholder_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.message_placeholder') ?></label>
        <input id="<?= 'tmmessengers_text_' . $row->biolink_block_id ?>" class="form-control" name="message_placeholder" placeholder="<?= l('create_biolink_tmmessengers_modal.message_placeholder.placeholder') ?>" maxlength="2048" value="<?= $row->settings->message_placeholder ?>" />
    </div>
    
    
    <div class="form-group">
        <label for="<?= 'image_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-image fa-sm mr-1"></i> <?= l('create_biolink_tmmessengers_modal.image') ?></label>
        <div data-image-container class="<?= !empty($row->settings->image) ? null : 'd-none' ?>">
			<div class="row">
				<div class="m-1 col-6 col-xl-3">
                    <img src="<?= $row->settings->image ? UPLOADS_FULL_URL . 'block_images/' . $row->settings->image : null ?>" class="img-fluid rounded <?= !empty($row->settings->image) ? null : 'd-none' ?>" loading="lazy" />
                </div>
            </div>
        </div>
        <input id="<?= 'image_' . $row->biolink_block_id ?>" type="file" name="image" accept=".gif, .png, .jpg, .jpeg, .svg" class="form-control-file" />
        
        
        <div class="custom-control custom-checkbox my-2">
            <input id="<?= $row->biolink_block_id . '_image_remove' ?>" name="image_remove" type="checkbox" class="custom-control-input" onchange="this.checked ? document.querySelector('#<?= 'link_image_' . $row->biolink_block_id ?>').classList.add('d-none') : document.querySelector('#<?= 'link_image_' . $row->biolink_block_id ?>').classList.remove('d-none')">
            <label class="custom-control-label" for="<?= $row->biolink_block_id . '_image_remove' ?>">
                <span class="text-muted"><?= l('global.delete_file') ?></span>
            </label>
        </div>
    </div>
    
    <div class="form-group">
        <label><i class="fas fa-fw fa-paint-brush fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.text_color') ?></label>
        <input type="hidden" name="text_color" class="form-control" value="<?= $row->settings->text_color ?>" required="required" />
        <div class="text_color_pickr"></div>
    </div>
    
    <div class="form-group">
        <label><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.background_color') ?></label>
        <input type="hidden" name="background_color" class="form-control" value="<?= $row->settings->background_color ?>" required="required" />
        <div class="background_color_pickr"></div>
    </div>
    
    <div class="form-group">
        <label><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmmessengers_modal.background_color_widget') ?></label>
        <input type="hidden" name="border_color" class="form-control" value="<?= $row->settings->border_color ?>" required="required" />
        <div class="border_color_pickr"></div>
    </div>

    </div>
    </div>
    
    <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'display_settings_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'display_settings_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_link_modal.display_settings_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'display_settings_container_' . $row->biolink_block_id ?>">
        <div <?= $this->user->plan_settings->temporary_url_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
            <div class="<?= $this->user->plan_settings->temporary_url_is_enabled ? null : 'container-disabled' ?>">
                <div class="custom-control custom-switch mb-3">
                    <input
                    id="<?= 'link_schedule_' . $row->biolink_block_id ?>"
                    name="schedule" type="checkbox"
                    class="custom-control-input"
                    <?= !empty($row->start_date) && !empty($row->end_date) ? 'checked="checked"' : null ?>
                    <?= $this->user->plan_settings->temporary_url_is_enabled ? null : 'disabled="disabled"' ?>
                    >
                    <label class="custom-control-label" for="<?= 'link_schedule_' . $row->biolink_block_id ?>"><?= l('link.settings.schedule') ?></label>
                    <small class="form-text text-muted"><?= l('link.settings.schedule_help') ?></small>
                </div>
            </div>
        </div>
        
        <div class="mt-3 schedule_container" style="display: none;">
            <div <?= $this->user->plan_settings->temporary_url_is_enabled ? null : 'data-toggle="tooltip" title="' . l('global.info_message.plan_feature_no_access') . '"' ?>>
                <div class="<?= $this->user->plan_settings->temporary_url_is_enabled ? null : 'container-disabled' ?>">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="<?= 'link_start_date_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-clock fa-sm text-muted mr-1"></i> <?= l('link.settings.start_date') ?></label>
                                <input
                                id="<?= 'link_start_date_' . $row->biolink_block_id ?>"
                                type="text"
                                class="form-control"
                                name="start_date"
                                value="<?= \Altum\Date::get($row->start_date, 1) ?>"
                                placeholder="<?= l('link.settings.start_date') ?>"
                                autocomplete="off"
                                data-daterangepicker
                                >
                            </div>
                        </div>
                        
                        <div class="col">
                            <div class="form-group">
                                <label for="<?= 'link_end_date_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-clock fa-sm text-muted mr-1"></i> <?= l('link.settings.end_date') ?></label>
                                <input
                                id="<?= 'link_end_date_' . $row->biolink_block_id ?>"
                                type="text"
                                class="form-control"
                                name="end_date"
                                value="<?= \Altum\Date::get($row->end_date, 1) ?>"
                                placeholder="<?= l('link.settings.end_date') ?>"
                                autocomplete="off"
                                data-daterangepicker
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="<?= 'link_display_countries_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-globe fa-sm text-muted mr-1"></i> <?= l('global.countries') ?></label>
            <select id="<?= 'link_display_countries_' . $row->biolink_block_id ?>" name="display_countries[]" class="form-control" multiple="multiple">
                <?php foreach(get_countries_array() as $country => $country_name): ?>
                <option value="<?= $country ?>" <?= in_array($country, $row->settings->display_countries ?? []) ? 'selected="selected"' : null ?>><?= $country_name ?></option>
                <?php endforeach ?>
            </select>
            <small class="form-text text-muted"><?= l('create_biolink_link_modal.input.display_countries_help') ?></small>
        </div>
        
        <div class="form-group">
            <label for="<?= 'link_display_devices_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-laptop fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.display_devices') ?></label>
            <select id="<?= 'link_display_devices_' . $row->biolink_block_id ?>" name="display_devices[]" class="form-control" multiple="multiple">
                <?php foreach(['desktop', 'tablet', 'mobile'] as $device_type): ?>
                <option value="<?= $device_type ?>" <?= in_array($device_type, $row->settings->display_devices ?? []) ? 'selected="selected"' : null ?>><?= l('global.device.' . $device_type) ?></option>
                <?php endforeach ?>
            </select>
            <small class="form-text text-muted"><?= l('create_biolink_link_modal.input.display_devices_help') ?></small>
        </div>
        
        <div class="form-group">
            <label for="<?= 'link_display_languages_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-language fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.display_languages') ?></label>
            <select id="<?= 'link_display_languages_' . $row->biolink_block_id ?>" name="display_languages[]" class="form-control" multiple="multiple">
                <?php foreach(get_locale_languages_array() as $locale => $language): ?>
                <option value="<?= $locale ?>" <?= in_array($locale, $row->settings->display_languages ?? []) ? 'selected="selected"' : null ?>><?= $language ?></option>
                <?php endforeach ?>
            </select>
            <small class="form-text text-muted"><?= l('create_biolink_link_modal.input.display_languages_help') ?></small>
        </div>
        
        <div class="form-group">
            <label for="<?= 'link_display_operating_systems_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-window-restore fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.display_operating_systems') ?></label>
            <select id="<?= 'link_display_operating_systems_' . $row->biolink_block_id ?>" name="display_operating_systems[]" class="form-control" multiple="multiple">
                <?php foreach(['iOS', 'Android', 'Windows', 'OS X', 'Linux', 'Ubuntu', 'Chrome OS'] as $os_name): ?>
                <option value="<?= $os_name ?>" <?= in_array($os_name, $row->settings->display_operating_systems ?? []) ? 'selected="selected"' : null ?>><?= $os_name ?></option>
                <?php endforeach ?>
            </select>
            <small class="form-text text-muted"><?= l('create_biolink_link_modal.input.display_operating_systems_help') ?></small>
        </div>
    </div>
    
    
    <div class="mt-4">
        <button type="submit" name="submit" class="btn btn-block btn-primary" data-is-ajax><?= l('global.update') ?></button>
    </div>
</form>
