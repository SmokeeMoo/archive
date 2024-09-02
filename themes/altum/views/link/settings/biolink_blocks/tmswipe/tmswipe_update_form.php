<?php defined('ALTUMCODE') || die() ?>

<form name="update_biolink_" method="post" role="form">
    <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" required="required" />
    <input type="hidden" name="request_type" value="update" />
    <input type="hidden" name="block_type" value="tmswipe" />
    <input type="hidden" name="biolink_block_id" value="<?= $row->biolink_block_id ?>" />
    
    <div class="notification-container"></div>
    
    <!-- Start Items -->
    <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmtmswipe_items_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmtmswipe_items_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmtmswipe_modal.items_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmtmswipe_items_container_' . $row->biolink_block_id ?>">
        
        <div id="<?= 'tmswipe_items_' . $row->biolink_block_id ?>" data-biolink-block-id="<?= $row->biolink_block_id ?>">
            <?php foreach($row->settings->items as $key => $item): ?>
            <div class="mb-4">
                
                <!-- Start block -->
                <div class="d-flex align-items-center "style="border-radius: 6px; padding: 10px; border: 2px solid #d3d3d35e;">	
                    <div class="col-7 col-md-7"> 
                        <div class="d-flex flex-column">
                            <a href="#" data-toggle="collapse" data-target="#<?= 'Page' . ( $key + 1 ) . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'Page' . ( $key + 1 )  ?>">
                                
                                <?php $userlinkd = db()->where('link_id', $item->page)->getOne('links', ['url']);?>
                                
                                
                                
                                <strong><?= !empty($item->page) ? $userlinkd->url : l('create_biolink_tmswipe_modal.market_title.tmswipe.block') . ' '. ( $key + 1 )  ?></strong>
                            </a>
                            
                            <span class="d-flex align-items-center">
                            </span>
                            
                        </div>
                    </div>	
                    
                    <div class="col-2 col-md-2 d-flex justify-content-end">
                        <a href="#" data-toggle="collapse" data-target="#<?= 'Page' . ( $key + 1 ). $row->biolink_block_id  ?>" aria-expanded="false" aria-controls="<?= 'Page' . ( $key + 1 ) . $row->biolink_block_id ?>" >
                            <div class="link-btn-arrow-wrapper-setting2" >		
                                <!--<i class="fas fa-chevron-right "></i>
                                <i class="fas fa-chevron-down "></i>-->
                            </div> 
                        </a>                                       
                    </div>
                    <div class="col-3 col-md-3 d-flex justify-content-end">
                        <button type="button" data-remove="item" class="btn btn-block btn-outline-danger" style="display:inline-block; border: none;"><i class="fas fa-fw fa-times"></i></button>
                    </div>
                </div>	
                
                <!-- End block -->
                
				<div class="collapse" id="<?= 'Page' . ( $key + 1 ) . $row->biolink_block_id  ?>">	
                    <div class="mb-2">
                        
                        <div class="form-group">
                            <label for="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswipe_modal.title') ?></label>
                            <input id="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>" name="item_title[<?= $key ?>]" type="number" min="1" max="99" class="form-control" value="<?= $item->title ?>" required="required" />
                        </div>
                        
                        
                        <div class="form-group">
                            <?php $userlink = db()->where('type', 'biolink')->where('user_id', $data->link->user_id)->get('links');?>
                            <label for="<?= 'item_page_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-expand fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswipe_modal.page') ?></label>
                            
                            <select id="<?= 'item_page_' . $key . '_' . $row->biolink_block_id ?>" name="item_page[<?= $key ?>]" class="form-control" >
                                <?php foreach($userlink as $rowd): ?>
                                <option value="<?= $rowd->link_id ?>" <?= $item->page ==  $rowd->link_id  ? 'selected="selected"' : null ?>><?= $rowd->url ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        
                        
                        <button type="button" data-remove="item" class="btn btn-block btn-outline-danger"><i class="fas fa-fw fa-times"></i> <?= l('global.delete') ?></button>
                    </div>
                </div></div>
                <?php endforeach ?>
        </div>
        <button data-add="tmswipe_item" data-biolink-block-id="<?= $row->biolink_block_id ?>" type="button" class="btn btn-sm btn-outline-success"><i class="fas fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
    </div>
    <div class="mb-3">
        
        <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmtmswipe_settings_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmtmswipe_settings_container_' . $row->biolink_block_id ?>">
            <?= l('create_biolink_tmtmswipe_modal.settings_header') ?>
        </button>
        
        <div class="collapse" id="<?= 'tmtmswipe_settings_container_' . $row->biolink_block_id ?>">
            
            <div class="custom-control custom-switch mb-3">
                <input 
                id="<?= 'tmswipe_pagination' . $row->biolink_block_id ?>" 
                name="pagination" type="checkbox" 
                class="custom-control-input" <?= $row->settings->pagination ? 'checked="checked"' : null ?>
                >
                <label class="custom-control-label" for="<?= 'tmswipe_pagination' . $row->biolink_block_id ?>"><?= l('create_biolink_tmswiper_modal.settings_pagination') ?></label>
            </div>
            
            <div class="custom-control custom-switch mb-3">
                <input 
                id="<?= 'tmswipe_pagination_style' . $row->biolink_block_id ?>" 
                name="pagination_style" type="checkbox" 
                class="custom-control-input" <?= $row->settings->pagination_style ? 'checked="checked"' : null ?>
                >
                <label class="custom-control-label" for="<?= 'tmswipe_pagination_style' . $row->biolink_block_id ?>"><?= l('create_biolink_tmswiper_modal.settings_pagination_style') ?></label>
            </div>
            
            <div class="custom-control custom-switch mb-3">
                <input 
                id="<?= 'tmswipe_navigation' . $row->biolink_block_id ?>" 
                name="navigation" type="checkbox" 
                class="custom-control-input" 
                <?= $row->settings->navigation ? 'checked="checked"' : null ?>
                >
                <label class="custom-control-label" for="<?= 'tmswipe_navigation' . $row->biolink_block_id ?>"><?= l('create_biolink_tmswiper_modal.settings_navigation') ?></label>
            </div>
            
            <div class="custom-control custom-switch mb-3">
                <input 
                id="<?= 'tmswipe_loop' . $row->biolink_block_id ?>" 
                name="loop" type="checkbox" 
                class="custom-control-input" 
                <?= $row->settings->loop ? 'checked="checked"' : null ?>
                >
                <label class="custom-control-label" for="<?= 'tmswipe_loop' . $row->biolink_block_id ?>"><?= l('create_biolink_tmswiper_modal.settings_loop') ?></label>
            </div>
            
            <div class="form-group">
                    <label for="<?= 'tmswipe_style_' . $key . '_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-expand fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswiper_modal.settings_style') ?></label>
                    <select id="<?= 'tmswipe_style_' . $key . '_' . $row->biolink_block_id ?>" name="style" class="form-control" >
           <option value="none" <?= $row->settings->style == 'none' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.none') ?></option>
            <option value="fade" <?= $row->settings->style == 'fade' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.fade') ?></option>
            <!--<option value="cube" <?= $row->settings->style == 'cube' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.cube') ?></option>-->
            <option value="coverflow" <?= $row->settings->style == 'coverflow' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.coverflow') ?></option>
            <!--<option value="flip" <?= $row->settings->style == 'flip' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.flip') ?></option>-->
            <option value="cards" <?= $row->settings->style == 'cards' ? 'selected="selected"' : null ?>><?= l('create_biolink_tmswipe_modal.cards') ?></option>
                    
                    </select>
                </div>
            
            <div class="form-group">
                <label for="<?= 'tmswipe_text_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-paint-brush fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswipe_modal.input.navigation_color') ?></label>
                <input id="<?= 'tmswipe_text_color_' . $row->biolink_block_id ?>" type="hidden" name="text_color" class="form-control" value="<?= $row->settings->text_color ?>" required="required" />
                <div class="text_color_pickr"></div>
            </div>
            
            <div class="form-group">
                <label for="<?= 'tmswipe_background_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswipe_modal.input.pagination_color') ?></label>
                <input id="<?= 'tmswipe_background_color_' . $row->biolink_block_id ?>" type="hidden" name="background_color" class="form-control" value="<?= $row->settings->background_color ?>" required="required" />
                <div class="background_color_pickr"></div>
            </div>
            
        <div class="form-group">
            <label for="<?= 'tmswipe_border_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmswipe_modal.input.background_color') ?></label>
            <input id="<?= 'tmswipe_border_color_' . $row->biolink_block_id ?>" type="hidden" name="border_color" class="form-control" value="<?= $row->settings->border_color ?>" required="required" />
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
        <button type="submit" name="submit" class="btn btn-block btn-primary"><?= l('global.update') ?></button>
    </div>
</form>