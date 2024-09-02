<?php defined('ALTUMCODE') || die() ?>

<form name="update_biolink_" method="post" role="form">
    <input type="hidden" name="token" value="<?= \Altum\Csrf::get() ?>" required="required" />
    <input type="hidden" name="request_type" value="update" />
    <input type="hidden" name="block_type" value="tmappointments" />
    <input type="hidden" name="biolink_block_id" value="<?= $row->biolink_block_id ?>" />
    
    <div class="notification-container"></div>
    <!-- Start Days-->
    <button class="btn btn-block btn-gray-600 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmappointments_items_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmappointments_items_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmappointments_modal.items_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmappointments_items_container_' . $row->biolink_block_id ?>">
        <?php
            $daysOfWeek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
            
            foreach ($daysOfWeek as $day) {
                $dayCap = ucfirst($day); // Делаем первую букву заглавной для отображения
                
                echo "<!-- *****************************************  {$dayCap} ***************************************************** -->";
                echo "<button class=\"btn btn-block btn-gray-300 my-4\" type=\"button\" data-toggle=\"collapse\" data-target=\"#tmappointments_{$day}_container_{$row->biolink_block_id}\" aria-expanded=\"false\" aria-controls=\"tmappointments_{$day}_container_{$row->biolink_block_id}\">";
                echo l("create_biolink_tmappointments_modal.{$day}_header");
                echo "</button>";
                
                echo "<div class=\"collapse\" id=\"tmappointments_{$day}_container_{$row->biolink_block_id}\">";
                echo "<div class=\"tmappointments_items\" data-biolink-block-id=\"{$row->biolink_block_id}\">";
                
                foreach($row->settings->$day as $key => $item) {
                    echo "<div class=\"mb-4\" style=\"margin-bottom: 0.2rem !important\">";
                    echo "<div class=\"row\" style=\"height: 3rem;\">";
                    
                    // Блок для времени начала
                    echo "<div class=\"p-2 col-4\" style=\"height: 4rem;\">";
                    echo "<div class=\"form-group\" style=\"margin-bottom: 0.5rem;\">";
                    echo "<select id=\"{$day}_time_start_{$key}_{$row->biolink_block_id}\" name=\"{$day}_time_start[{$key}]\" class=\"time-start-select form-control \" style=\"text-align:center;\">";
                    for ($hour = 0; $hour < 24; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $formattedTime = sprintf('%02d:%02d', $hour, $minute);
                            $selected = $item->time_start == $formattedTime ? 'selected="selected"' : '';
                            echo "<option value=\"{$formattedTime}\" {$selected}>{$formattedTime}</option>";
                        }
                    }
                    echo "</select></div></div>";
                    
                    // Разделитель
                    echo "<div class=\"p-1 col-2\" style=\"text-align: center; margin-top: 0.5rem; height: 4rem;\">";
                    echo l("tmappointments_to");
                    echo "</div>";
                    
                    // Блок для времени окончания
                    echo "<div class=\"p-2 col-4\" style=\"height: 4rem;\">";
                    echo "<div class=\"form-group\" style=\"margin-bottom: 0.5rem;\">";
                    echo "<select id=\"{$day}_time_end_{$key}_{$row->biolink_block_id}\" name=\"{$day}_time_end[{$key}]\" class=\"time-end-select form-control\" style=\"text-align:center;\">";
                    for ($hour = 0; $hour < 24; $hour++) {
                        for ($minute = 0; $minute < 60; $minute += 15) {
                            $formattedTime = sprintf('%02d:%02d', $hour, $minute);
                            $selected = $item->time_end == $formattedTime ? 'selected="selected"' : '';
                            echo "<option value=\"{$formattedTime}\" {$selected}>{$formattedTime}</option>";
                        }
                    }
                    echo "</select></div></div>";
                    
                    // Кнопка удаления
                    echo "<div class=\"p-1 col-2\" style=\"text-align: center; height: 4rem;\">";
                    echo "<button type=\"button\" data-remove=\"item\" class=\"btn btn-block btn-outline-danger\" style=\"display:inline-block; border: none;\"><i class=\"fas fa-fw fa-times\"></i></button>";
                    echo "</div></div></div>";
                }
                
                echo "</div>";
                echo "<button data-add=\"tmappointments_{$day}\" data-biolink-block-id=\"{$row->biolink_block_id}\" type=\"button\" class=\"btn btn-sm btn-outline-success\" style=\"margin: 1rem 0 1rem 0;\"><i class=\"fas fa-fw fa-plus-circle\"></i> " . l("global.create") . "</button>";
                echo "</div>";
                echo "<!-- *****************************************  {$dayCap} ***************************************************** -->";
            }
        ?>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Находим все элементы select для времени начала
            var startTimeSelects = document.querySelectorAll('.time-start-select');
            startTimeSelects.forEach(function(startTimeSelect) {
                // Добавляем обработчик событий при изменении времени начала
                startTimeSelect.addEventListener('change', function() {
                    // Находим связанный с ним select для времени окончания
                    var endTimeSelect = document.getElementById(this.id.replace('time_start', 'time_end'));
                    var selectedTime = this.value.split(':');
                    var selectedHour = parseInt(selectedTime[0]);
                    var selectedMinute = parseInt(selectedTime[1]);
                    
                    // Обновляем опции времени окончания
                    updateEndTimeOptions(endTimeSelect, selectedHour, selectedMinute);
                });
            });
        });
        
        function updateEndTimeOptions(endTimeSelect, selectedHour, selectedMinute) {
            // Разблокировка select
            endTimeSelect.disabled = false;
            
            // Обновляем доступные варианты выбора времени
            var options = endTimeSelect.options;
            for (var i = 0; i < options.length; i++) {
                var time = options[i].value.split(':');
                var hour = parseInt(time[0]);
                var minute = parseInt(time[1]);
                
                // Проверка, чтобы время окончания было больше времени начала минимум на 15 минут
                if (hour > selectedHour || (hour == selectedHour && minute >= selectedMinute + 15)) {
                    options[i].disabled = false;
                    } else {
                    options[i].disabled = true;
                }
            }
        }
    </script>
    <!-- Start Items -->
    <button class="btn btn-block btn-gray-600 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmappointment_items_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmappointment_items_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmappointment_modal.items_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmappointment_items_container_' . $row->biolink_block_id ?>">
        <div id="<?= 'tmappointment_items_' . $row->biolink_block_id ?>" data-biolink-block-id="<?= $row->biolink_block_id ?>">
            <?php foreach($row->settings->items as $key => $item): ?>
            <div class="mb-4" style="margin-bottom: 0.5rem !important;">
                <div class="row">
                    <div class="form-group col-9">
                        <label for="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>">
                            <i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> 
                            <?= l('create_biolink_tmappointment_modal.title') ?>
                        </label>
                        <input id="<?= 'item_title_' . $key . '_' . $row->biolink_block_id ?>" type="text" name="item_title[<?= $key ?>]" class="form-control" value="<?= $item->title ?>" required="required" />
                    </div>
                    
                    <div class="col-3 d-flex align-items-center">
                        <button type="button" data-remove="item" class="btn btn-outline-danger">
                            <i class="fas fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <?php endforeach ?>
        </div>
        <button data-add="tmappointment_item" data-biolink-block-id="<?= $row->biolink_block_id ?>" type="button" class="btn btn-sm btn-outline-success"><i class="fas fa-fw fa-plus-circle"></i> <?= l('global.create') ?></button>
    </div>
    
	
	<!--------------------------------------------------------------------------------------------------------->
	
    <button class="btn btn-block btn-gray-600 my-4" type="button" data-toggle="collapse" data-target="#<?= 'tmappointment_appearance_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'tmappointment_appearance_container_' . $row->biolink_block_id ?>">
        <?= l('create_biolink_tmappointment_modal.appearance_header') ?>
    </button>
    
    <div class="collapse" id="<?= 'tmappointment_appearance_container_' . $row->biolink_block_id ?>">
        
        <div class="mb-3">
            
            <div class="form-group">
                <label for="<?= 'tmappointments_text_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-paint-brush fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointments_modal.input.text_color') ?></label>
                <input id="<?= 'tmappointments_text_color_' . $row->biolink_block_id ?>" type="hidden" name="text_color" class="form-control" value="<?= $row->settings->text_color ?>" required="required" />
                <div class="text_color_pickr"></div>
            </div>
            
            <div class="form-group">
                <label for="<?= 'tmappointments_background_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointments_modal.input.background_color') ?></label>
                <input id="<?= 'tmappointments_background_color_' . $row->biolink_block_id ?>" type="hidden" name="background_color" class="form-control" value="<?= $row->settings->background_color ?>" required="required" />
                <div class="background_color_pickr"></div>
            </div>
            
            
            <div class="form-group">
                <label for="<?= 'link_icon_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-icons fa-sm text-muted mr-1"></i> <?= l('global.icon') ?></label>
                <input id="<?= 'link_icon_' . $row->biolink_block_id ?>" type="text" name="icon" class="form-control" value="<?= $row->settings->icon ?>" placeholder="<?= l('global.icon_placeholder') ?>" />
                <small class="form-text text-muted"><?= l('global.icon_help') ?></small>
            </div>
            
            
            <div class="form-group">
                <label for="<?= 'block_text_alignment_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-align-center fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.text_alignment') ?></label>
                <div class="row btn-group-toggle" data-toggle="buttons">
                    <?php foreach(['center', 'left', 'right', 'justify'] as $text_alignment): ?>
                    <div class="col-4">
                        <label class="btn btn-light btn-block <?= ($row->settings->text_alignment  ?? null) == $text_alignment ? 'active"' : null?>">
                            <input type="radio" name="text_alignment" value="<?= $text_alignment ?>" class="custom-control-input" <?= ($row->settings->text_alignment  ?? null) == $text_alignment ? 'checked="checked"' : null ?> />
                            <i class="fas fa-fw fa-align-<?= $text_alignment ?> fa-sm mr-1"></i> <?= l('create_biolink_link_modal.input.text_alignment.' . $text_alignment) ?>
                        </label>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
            
            <div class="form-group">
                <label for="<?= 'link_animation_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-film fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.animation') ?></label>
                <select id="<?= 'link_animation_' . $row->biolink_block_id ?>" name="animation" class="custom-select">
                    <option value="false" <?= !$row->settings->animation ? 'selected="selected"' : null ?>><?= l('global.none') ?></option>
                    <?php foreach(require APP_PATH . 'includes/biolink_animations.php' as $animation): ?>
                    <option value="<?= $animation ?>" <?= $row->settings->animation == $animation ? 'selected="selected"' : null ?>><?= $animation ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            
            <div class="form-group" data-animation="<?= implode(',', require APP_PATH . 'includes/biolink_animations.php') ?>">
                <label for="<?= 'link_animation_runs_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-play-circle fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.animation_runs') ?></label>
                <select id="<?= 'link_animation_runs_' . $row->biolink_block_id ?>" name="animation_runs" class="custom-select">
                    <option value="repeat-1" <?= $row->settings->animation_runs == 'repeat-1' ? 'selected="selected"' : null ?>>1</option>
                    <option value="repeat-2" <?= $row->settings->animation_runs == 'repeat-2' ? 'selected="selected"' : null ?>>2</option>
                    <option value="repeat-3" <?= $row->settings->animation_runs == 'repeat-3' ? 'selected="selected"' : null ?>>3</option>
                    <option value="infinite" <?= $row->settings->animation_runs == 'repeat-infinite' ? 'selected="selected"' : null ?>><?= l('create_biolink_link_modal.input.animation_runs_infinite') ?></option>
                </select>
            </div>
            
            <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'border_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'border_container_' . $row->biolink_block_id ?>">
                <i class="fas fa-fw fa-square-full fa-sm mr-1"></i> <?= l('create_biolink_link_modal.border_header') ?>
            </button>
            
            <div class="collapse" id="<?= 'border_container_' . $row->biolink_block_id ?>">
                <div class="form-group" data-range-counter data-range-counter-suffix="px">
                    <label for="<?= 'block_border_width_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-border-style fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_width') ?></label>
                    <input id="<?= 'block_border_width_' . $row->biolink_block_id ?>" type="range" min="0" max="5" class="form-control" name="border_width" value="<?= $row->settings->border_width ?>" required="required" />
                </div>
                
                <div class="form-group">
                    <label for="<?= 'block_border_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_color') ?></label>
                    <input id="<?= 'block_border_color_' . $row->biolink_block_id ?>" type="hidden" name="border_color" class="form-control" value="<?= $row->settings->border_color ?>" required="required" />
                    <div class="border_color_pickr"></div>
                </div>
                
                <div class="form-group">
                    <label for="<?= 'block_border_radius_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-border-all fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_radius') ?></label>
                    <div class="row btn-group-toggle" data-toggle="buttons">
                        <div class="col-4">
                            <label class="btn btn-light btn-block <?= ($row->settings->border_radius  ?? null) == 'straight' ? 'active"' : null?>">
                                <input type="radio" name="border_radius" value="straight" class="custom-control-input" <?= ($row->settings->border_radius  ?? null) == 'straight' ? 'checked="checked"' : null?> />
                                <i class="fas fa-fw fa-square-full fa-sm mr-1"></i> <?= l('create_biolink_link_modal.input.border_radius_straight') ?>
                            </label>
                        </div>
                        <div class="col-4">
                            <label class="btn btn-light btn-block <?= ($row->settings->border_radius  ?? null) == 'round' ? 'active' : null?>">
                                <input type="radio" name="border_radius" value="round" class="custom-control-input" <?= ($row->settings->border_radius  ?? null) == 'round' ? 'checked="checked"' : null?> />
                                <i class="fas fa-fw fa-circle fa-sm mr-1"></i> <?= l('create_biolink_link_modal.input.border_radius_round') ?>
                            </label>
                        </div>
                        <div class="col-4">
                            <label class="btn btn-light btn-block <?= ($row->settings->border_radius  ?? null) == 'rounded' ? 'active' : null?>">
                                <input type="radio" name="border_radius" value="rounded" class="custom-control-input" <?= ($row->settings->border_radius  ?? null) == 'rounded' ? 'checked="checked"' : null?> />
                                <i class="fas fa-fw fa-square fa-sm mr-1"></i> <?= l('create_biolink_link_modal.input.border_radius_rounded') ?>
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="<?= 'block_border_style_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-border-none fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_style') ?></label>
                    <div class="row btn-group-toggle" data-toggle="buttons">
                        <?php foreach(['solid', 'dashed', 'double', 'outset', 'inset'] as $border_style): ?>
                        <div class="col-4">
                            <label class="btn btn-light btn-block <?= ($row->settings->border_style  ?? null) == $border_style ? 'active"' : null?>">
                                <input type="radio" name="border_style" value="<?= $border_style ?>" class="custom-control-input" <?= ($row->settings->border_style  ?? null) == $border_style ? 'checked="checked"' : null?> />
                                <?= l('create_biolink_link_modal.input.border_style_' . $border_style) ?>
                            </label>
                        </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
            
            <button class="btn btn-block btn-gray-300 my-4" type="button" data-toggle="collapse" data-target="#<?= 'border_shadow_container_' . $row->biolink_block_id ?>" aria-expanded="false" aria-controls="<?= 'border_shadow_container_' . $row->biolink_block_id ?>">
                <i class="fas fa-fw fa-cloud fa-sm mr-1"></i> <?= l('create_biolink_link_modal.border_shadow_header') ?>
            </button>
            
            <div class="collapse" id="<?= 'border_shadow_container_' . $row->biolink_block_id ?>">
                <div class="form-group" data-range-counter data-range-counter-suffix="px">
                    <label for="<?= 'block_border_shadow_offset_x_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-arrows-alt-h fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_shadow_offset_x') ?></label>
                    <input id="<?= 'block_border_shadow_offset_x_' . $row->biolink_block_id ?>" type="range" min="-20" max="20" class="form-control" name="border_shadow_offset_x" value="<?= $row->settings->border_shadow_offset_x ?>" required="required" />
                </div>
                
                <div class="form-group" data-range-counter data-range-counter-suffix="px">
                    <label for="<?= 'block_border_shadow_offset_y_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-arrows-alt-v fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_shadow_offset_y') ?></label>
                    <input id="<?= 'block_border_shadow_offset_y_' . $row->biolink_block_id ?>" type="range" min="-20" max="20" class="form-control" name="border_shadow_offset_y" value="<?= $row->settings->border_shadow_offset_y ?>" required="required" />
                </div>
                
                <div class="form-group" data-range-counter data-range-counter-suffix="px">
                    <label for="<?= 'block_border_shadow_blur_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-arrows-alt fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_shadow_blur') ?></label>
                    <input id="<?= 'block_border_shadow_blur_' . $row->biolink_block_id ?>" type="range" min="0" max="20" class="form-control" name="border_shadow_blur" value="<?= $row->settings->border_shadow_blur ?>" required="required" />
                </div>
                
                <div class="form-group" data-range-counter data-range-counter-suffix="px">
                    <label for="<?= 'block_border_shadow_spread_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-border-all fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_shadow_spread') ?></label>
                    <input id="<?= 'block_border_shadow_spread_' . $row->biolink_block_id ?>" type="range" min="0" max="10" class="form-control" name="border_shadow_spread" value="<?= $row->settings->border_shadow_spread ?>" required="required" />
                </div>
                
                <div class="form-group">
                    <label for="<?= 'block_border_shadow_color_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-fill fa-sm text-muted mr-1"></i> <?= l('create_biolink_link_modal.input.border_shadow_color') ?></label>
                    <input id="<?= 'block_border_shadow_color_' . $row->biolink_block_id ?>" type="hidden" name="border_shadow_color" class="form-control" value="<?= $row->settings->border_shadow_color ?>" required="required" />
                    <div class="border_shadow_color_pickr"></div>
                </div>
            </div>
            
        </div>
    </div>
	
    <div class="form-group">
        <label for="<?= 'tmappointment_name_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointment_modal.input.name') ?></label>
        <input id="<?= 'tmappointment_name_' . $row->biolink_block_id ?>" type="text" name="name" class="form-control" value="<?= $row->settings->name ?>" maxlength="128" required="required" />
    </div>
    
    <div class="form-group">
        <label for="<?= 'tmappointment_button_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointment_modal.input.button') ?></label>
        <input id="<?= 'tmappointment_button_' . $row->biolink_block_id ?>" type="text" name="button_name" class="form-control" value="<?= $row->settings->button_name ?>" maxlength="128" required="required" />
    </div>
    
    <div class="form-group">
        <label for="<?= 'tmappointment_successful_appointment_message_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointment_modal.input.successful_appointment_message') ?></label>
        <input id="<?= 'tmappointment_successful_appointment_message_' . $row->biolink_block_id ?>" type="text" name="successful_appointment" class="form-control" value="<?= $row->settings->successful_appointment ?>" maxlength="128" required="required" />
    </div>
    
    <div class="form-group">
        <label for="<?= 'tmappointment_max_days_' . $row->biolink_block_id ?>"><i class="fas fa-fw fa-signature fa-sm text-muted mr-1"></i> <?= l('create_biolink_tmappointment_modal.input.max_days') ?></label>
        <input id="<?= 'tmappointment_max_days_' . $row->biolink_block_id ?>" type="number" name="max_days" class="form-control" value="<?= $row->settings->max_days ?>" min="7" max="365" required="required" />
    </div>
	
	        <div class="form-group">
            <label for="<?= 'tmappointment_email_notification_' . $row->biolink_block_id ?>"><?= l('create_biolink_block_modal.email_notification') ?></label>
            <input type="text" id="<?= 'tmappointment_email_notification_' . $row->biolink_block_id ?>" name="email_notification" class="form-control" value="<?= $row->settings->email_notification ?? null ?>" maxlength="<?= $data->biolink_blocks['service']['fields']['email_notification']['max_length'] ?>" />
            <small class="form-text text-muted"><?= l('create_biolink_block_modal.email_notification_help') ?></small>
        </div>
	<!-------------------------------------------------------------------------------------------------->
    
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
