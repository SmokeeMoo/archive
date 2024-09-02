<?php defined('ALTUMCODE') || die() ?>

<style>
    html,
    body {
    position: relative;
    min-height: 100%;
    }
    
    body {
    margin: 0;
    padding: 0;
    }
    
    swiper-container {
    width: 100%;
    height: 100%;
    }
</style>

<body class="<?= l('direction') == 'rtl' ? 'rtl' : null ?> link-body <?= $data->link->design->background_class ?>" style="<?= $data->link->design->background_style ?>">
    <?php foreach($data->biolink_blocks as $row): ?>
    <?php if($row->type == 'tmswipe') {
        if(json_decode($row->settings)->pagination_style == true) {$pagination_style = 'pagination-type="progressbar"';} else $pagination_style = '';
        if(json_decode($row->settings)->loop == true) {$loop = 'loop="true"';} else $loop = '';
        if(json_decode($row->settings)->style == 'fade') {$transition_style = 'space-between="30" effect="fade"';}
        if(json_decode($row->settings)->style == 'cube') {$transition_style = 'effect="cube" grab-cursor="true" cube-effect-shadow="true"
        cube-effect-slide-shadows="true" cube-effect-shadow-offset="20" cube-effect-shadow-scale="0.94"';}
        if(json_decode($row->settings)->style == 'coverflow') {$transition_style = 'effect="coverflow" grab-cursor="true" centered-slides="true"
            slides-per-view="auto" coverflow-effect-rotate="50" coverflow-effect-stretch="0" coverflow-effect-depth="100"
        coverflow-effect-modifier="1" coverflow-effect-slide-shadows="true"';}
        if(json_decode($row->settings)->style == 'flip') {$transition_style = 'effect="flip"';}
        if(json_decode($row->settings)->style == 'cards') {$transition_style = 'effect="cards" grab-cursor="true"';}
        if(json_decode($row->settings)->style == 'none') {$transition_style = '';}
        
        if(json_decode($row->settings)->pagination == false && json_decode($row->settings)->navigation == false) {echo '<swiper-container class="mySwiper" '. $transition_style .' '.$loop.'>'; break;}
        
        if(json_decode($row->settings)->pagination == true && json_decode($row->settings)->navigation == true) {echo '<swiper-container class="mySwiper" pagination="true" '. $pagination_style .' '.$loop.' navigation="true" '. $transition_style .'>'; break;} 
        
        if(json_decode($row->settings)->pagination == false && json_decode($row->settings)->navigation == true) {echo '<swiper-container class="mySwiper" navigation="true" '. $transition_style .' '.$loop.'>'; break;}
        
        if(json_decode($row->settings)->pagination == true && json_decode($row->settings)->navigation == false) {echo '<swiper-container class="mySwiper" pagination="true"  '. $pagination_style .' '. $transition_style .' '.$loop.'>'; break;} 
    } 
    
    else echo '<swiper-container class="mySwiper" pagination="true" pagination-type="progressbar" navigation="true">' ?>
    <?php endforeach ?>
    
    <swiper-slide>
        <div style="width:100%">
            
            <?php if((is_string($data->link->settings->background) && string_ends_with('.mp4', $data->link->settings->background)) || isset($_GET['preview'])): ?>
            
            <video autoplay muted loop playsinline class="link-video-background <?= is_string($data->link->settings->background) && string_ends_with('.mp4', $data->link->settings->background) ? '' : 'd-none' ?>">
                <source src="<?= is_string($data->link->settings->background) && string_ends_with('.mp4', $data->link->settings->background) ? \Altum\Uploads::get_full_url('backgrounds') . $data->link->settings->background : null; ?>" type="video/mp4">
            </video>
            <?php endif ?>
            
            <div class="container animate__animated animate__fadeIn">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-md-<?= $data->link->settings->width ?? '8' ?> link-content <?= isset($_GET['preview']) ? 'container-disabled-simple' : null ?>">
                        
                        <?php require THEME_PATH . 'views/l/partials/ads_header_biolink.php' ?>
                        
                        <main id="links" class="my-<?= $data->link->settings->block_spacing ?? '2' ?>">
                            <div class="row">
                                <?php if($data->link->is_verified): ?>
                                <div id="link-verified-wrapper-top" class="col-12 my-<?= $data->link->settings->block_spacing ?? '2' ?> text-center" style="<?= $data->link->settings->verified_location == 'top' ? null : 'display: none;' ?>">
                                    <div>
                                        <small class="link-verified" data-toggle="tooltip" title="<?= sprintf(l('link.biolink.verified_help'), settings()->main->title) ?>"><i class="fas fa-fw fa-check-circle fa-1x"></i> <?= l('link.biolink.verified') ?></small>
                                    </div>
                                </div>
                                <?php endif ?>
                                <?php if($data->biolink_blocks): ?>
                                <?php
                                    /* Detect the location */
                                    try {
                                        $maxmind = (new \MaxMind\Db\Reader(APP_PATH . 'includes/GeoLite2-Country.mmdb'))->get(get_ip());
                                        } catch(\Exception $exception) {
                                        /* :) */
                                    }
                                    /* Detect extra details about the user */
                                    $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
                                    $os_name = $whichbrowser->os->name ?? null;
                                    $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
                                    $country_code = isset($maxmind) && isset($maxmind['country']) ? $maxmind['country']['iso_code'] : null;
                                    $device_type = get_device_type($_SERVER['HTTP_USER_AGENT']);
                                ?>
                                
                                <?php foreach($data->biolink_blocks as $row): ?>
                                
                                <?php
                                    $row->settings = json_decode($row->settings ?? '');
                                    
                                    /* Check if its a scheduled link and we should show it or not */
                                    if(
                                    !empty($row->start_date) &&
                                    !empty($row->end_date) &&
                                    (
                                    \Altum\Date::get('', null) < \Altum\Date::get($row->start_date, null, \Altum\Date::$default_timezone) ||
                                    \Altum\Date::get('', null) > \Altum\Date::get($row->end_date, null, \Altum\Date::$default_timezone)
                                    )
                                    ) {
                                        continue;
                                    }
                                    
                                    /* Check if the user has permissions to use the link */
                                    if(!$data->user->plan_settings->enabled_biolink_blocks->{$row->type}) {
                                        continue;
                                    }
                                    
                                    /* Check if there are any extra display rules */
                                    if($row->settings->display_countries && !in_array($country_code, $row->settings->display_countries)) {
                                        continue;
                                    }
                                    if($row->settings->display_devices && !in_array($device_type, $row->settings->display_devices)) {
                                        continue;
                                    }
                                    if($row->settings->display_languages && !in_array($browser_language, $row->settings->display_languages)) {
                                        continue;
                                    }
                                    if($row->settings->display_operating_systems && !in_array($os_name, $row->settings->display_operating_systems)) {
                                        continue;
                                    }
                                    
                                    /* Set UTM */
                                    $row->utm = $data->link->settings->utm;
                                    
                                ?>
                                
                                <?= \Altum\Link::get_biolink_link($row, $data->user, $this->biolink_theme ?? null, $data->link) ?? null ?>
                                
                                <?php endforeach ?>
                                <?php endif ?>
                            </div>
                        </main>
                        
                        <?php require THEME_PATH . 'views/l/partials/ads_footer_biolink.php' ?>
                        
                        <footer id="footer" class="link-footer">
                            <?php if($data->link->is_verified): ?>
                            <div id="link-verified-wrapper-bottom" class="my-<?= $data->link->settings->block_spacing ?? '2' ?>" style="<?= $data->link->settings->verified_location == 'bottom' ? null : 'display: none;' ?>">
                                <small class="link-verified" data-toggle="tooltip" title="<?= sprintf(l('link.biolink.verified_help'), settings()->main->title) ?>"><i class="fas fa-fw fa-check-circle fa-1x"></i> <?= l('link.biolink.verified') ?></small>
                            </div>
                            <?php endif ?>
                            
                            <div id="branding" class="link-footer-branding">
                                <?php if($data->link->settings->display_branding): ?>
                                <?php if(isset($data->link->settings->branding, $data->link->settings->branding->name, $data->link->settings->branding->url) && !empty($data->link->settings->branding->name)): ?>
                                <a href="<?= !empty($data->link->settings->branding->url) ? $data->link->settings->branding->url : '#' ?>" style="<?= $data->link->design->text_style ?>"><?= $data->link->settings->branding->name ?></a>
                                <?php else: ?>
                                <?php
                                    $replacers = [
                                    '{{URL}}' => url(),
                                    '{{WEBSITE_TITLE}}' => settings()->main->title,
                                    '{{AFFILIATE_URL_TAG}}' => \Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled ? '?ref=' . $data->user->referral_key : null,
                                    ];
                                    
                                    settings()->links->branding = str_replace(
                                    array_keys($replacers),
                                    array_values($replacers),
                                    settings()->links->branding
                                    );
                                ?>
                                <?= settings()->links->branding ?>
                                <?php endif ?>
                                <?php endif ?>
                            </div>
                        </footer>
                        
                    </div>
                </div>
            </div>
            
            <?= \Altum\Event::get_content('modals') ?>
        </div>
    </swiper-slide>
    
    
    
    <!-- /////////////////////////////////////////////////////////////////////// -->
    
    
    
    
    <?php foreach($data->biolink_blocks as $row): ?>
    <?php if($row->type == 'tmswipe') {
        $tmlinkid = [];
        foreach($data->biolink_blocks as $key => $item){
            if($item->type == 'tmswipe'){
                foreach($item->settings->items as $keyd => $itemd){
                    $tmlinkid[$itemd->title] = $itemd->page;
                }}}
                
                ksort($tmlinkid);
                
                foreach ($tmlinkid as $val) {    
                    $data->link->link_id = $val;
                    $data->biolink_blocks = db()->where('link_id', $val)->where('is_enabled', '1')->get('biolinks_blocks');
                    $data->link = db()->where('user_id', $data->user->user_id)->where('link_id', $val)->getOne('links');
                    //$data->link->settings = db()->where('link_id', $tmlinkid[$i])->getOne('links', ['settings']);
                    $data->link->settings = json_decode($data->link->settings);
                    $link = $data->link;
                    
                    $link->design = new \StdClass();
                    $link->design->background_class = '';
                    $link->design->background_style = '';
                    
                    /* Check if the user has the access needed from the plan */
                    if(!$user->plan_settings->custom_backgrounds && in_array($link->settings->background_type, ['image', 'gradient', 'color'])) {
                        
                        
                    }
                    
                    
                    switch($link->settings->background_type) {
                        case 'image':
                        
                        $link->design->background_style = 'background: url(\'' . \Altum\Uploads::get_full_url('backgrounds') . $link->settings->background . '\');';
                        
                        break;
                        
                        case 'gradient':
                        
                        $link->design->background_style = 'background-image: linear-gradient(135deg, ' . $link->settings->background_color_one . ' 10%, ' . $link->settings->background_color_two . ' 100%);';
                        
                        break;
                        
                        case 'color':
                        
                        $link->design->background_style = 'background: ' . $link->settings->background . ';';
                        
                        break;
                        
                        case 'preset':
                        case 'preset_abstract':
                        $biolink_backgrounds = require APP_PATH . 'includes/biolink_backgrounds.php';
                        $link->design->background_style = $biolink_backgrounds[$link->settings->background_type][$link->settings->background];
                        
                        break;
                    }
                    
                    /* Background attachment */
                    $link->design->background_style .= 'background-attachment: ' . ($link->settings->background_attachment ?? 'scroll') . ';';
                    
                    /* Determine the color of the header text */
                    $link->design->text_style = 'color: ' . $link->settings->text_color;
                    
                    /* Determine the notification branding settings */
                    if($user && !$user->plan_settings->removable_branding && !$link->settings->display_branding) {
                        $link->settings->display_branding = true;
                    }
                    
                    if($user && $user->plan_settings->removable_branding && !$link->settings->display_branding) {
                        $link->settings->display_branding = false;
                    }
                    
                    /* Check if we can show the custom branding if available */
                    if(isset($link->settings->branding, $link->settings->branding->name, $link->settings->branding->url) && !$user->plan_settings->custom_branding) {
                        $link->settings->branding = false;
                    }
                    
                ?>
                <swiper-slide>
                    <div class="<?= l('direction') == 'rtl' ? 'rtl' : null ?> link-body <?= $data->link->design->background_class ?>" style="<?= $data->link->design->background_style ?>; position: relative; margin: 0; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #31363f;text-align: left; width: 100%;">
                        
                        <video autoplay muted loop playsinline class="link-video-background <?= is_string($data->link->settings->background) && string_ends_with('.mp4', $data->link->settings->background) ? '' : 'd-none' ?>">
                            <source src="<?= is_string($data->link->settings->background) && string_ends_with('.mp4', $data->link->settings->background) ? \Altum\Uploads::get_full_url('backgrounds') . $data->link->settings->background : null; ?>" type="video/mp4">
                        </video>
                        
                        <div class="container animate__animated animate__fadeIn">
                            <div class="row d-flex justify-content-center text-center">
                                <div class="col-md-<?= $data->link->settings->width ?? '8' ?> link-content <?= isset($_GET['preview']) ? 'container-disabled-simple' : null ?>">
                                    
                                    <?php require THEME_PATH . 'views/l/partials/ads_header_biolink.php' ?>
                                    
                                    <main id="links" class="my-<?= $data->link->settings->block_spacing ?? '2' ?>">
                                        
                                        <div class="row">
                                            <?php if($data->link->is_verified): ?>
                                            <div id="link-verified-wrapper-top" class="col-12 my-<?= $data->link->settings->block_spacing ?? '2' ?> text-center" style="<?= $data->link->settings->verified_location == 'top' ? null : 'display: none;' ?>">
                                                <div>
                                                    <small class="link-verified" data-toggle="tooltip" title="<?= sprintf(l('link.biolink.verified_help'), settings()->main->title) ?>"><i class="fas fa-fw fa-check-circle fa-1x"></i> <?= l('link.biolink.verified') ?></small>
                                                </div>
                                            </div>
                                            <?php endif ?>
                                            <?php usort($data->biolink_blocks, function($a, $b) {
                                                return $a->order - $b->order;
                                            }); if($data->biolink_blocks): ?>
                                            <?php
                                                /* Detect the location */
                                                try {
                                                    $maxmind = (new \MaxMind\Db\Reader(APP_PATH . 'includes/GeoLite2-Country.mmdb'))->get(get_ip());
                                                    } catch(\Exception $exception) {
                                                    /* :) */
                                                }
                                                /* Detect extra details about the user */
                                                $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);
                                                $os_name = $whichbrowser->os->name ?? null;
                                                $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
                                                $country_code = isset($maxmind) && isset($maxmind['country']) ? $maxmind['country']['iso_code'] : null;
                                                $device_type = get_device_type($_SERVER['HTTP_USER_AGENT']);
                                            ?>
                                            
                                            <?php foreach($data->biolink_blocks as $row): ?>
                                            
                                            <?php
                                                $row->settings = json_decode($row->settings);
                                                
                                                /* Check if its a scheduled link and we should show it or not */
                                                if(
                                                !empty($row->start_date) &&
                                                !empty($row->end_date) &&
                                                (
                                                \Altum\Date::get('', null) < \Altum\Date::get($row->start_date, null, \Altum\Date::$default_timezone) ||
                                                \Altum\Date::get('', null) > \Altum\Date::get($row->end_date, null, \Altum\Date::$default_timezone)
                                                )
                                                ) {
                                                    continue;
                                                }
                                                
                                                /* Check if the user has permissions to use the link */
                                                if(!$data->user->plan_settings->enabled_biolink_blocks->{$row->type}) {
                                                    continue;
                                                }
                                                
                                                /* Check if there are any extra display rules */
                                                if($row->settings->display_countries && !in_array($country_code, $row->settings->display_countries)) {
                                                    continue;
                                                }
                                                if($row->settings->display_devices && !in_array($device_type, $row->settings->display_devices)) {
                                                    continue;
                                                }
                                                if($row->settings->display_languages && !in_array($browser_language, $row->settings->display_languages)) {
                                                    continue;
                                                }
                                                if($row->settings->display_operating_systems && !in_array($os_name, $row->settings->display_operating_systems)) {
                                                    continue;
                                                }
                                                
                                                /* Set UTM */
                                                $row->utm = $data->link->settings->utm;
                                                
                                            ?>
                                            
                                            <?= \Altum\Link::get_biolink_link($row, $data->user, $this->biolink_theme ?? null, $data->link) ?? null ?>
                                            <?php endforeach ?>
                                            <?php endif ?>
                                        </div>
                                    </main>
                                    
                                    <?php require THEME_PATH . 'views/l/partials/ads_footer_biolink.php' ?>
                                    
                                    <footer id="footer" class="link-footer">
                                        <?php if($data->link->is_verified): ?>
                                        <div id="link-verified-wrapper-bottom" class="my-<?= $data->link->settings->block_spacing ?? '2' ?>" style="<?= $data->link->settings->verified_location == 'bottom' ? null : 'display: none;' ?>">
                                            <small class="link-verified" data-toggle="tooltip" title="<?= sprintf(l('link.biolink.verified_help'), settings()->main->title) ?>"><i class="fas fa-fw fa-check-circle fa-1x"></i> <?= l('link.biolink.verified') ?></small>
                                        </div>
                                        <?php endif ?>
                                        
                                        <div id="branding" class="link-footer-branding">
                                            <?php if($data->link->settings->display_branding): ?>
                                            <?php if(isset($data->link->settings->branding, $data->link->settings->branding->name, $data->link->settings->branding->url) && !empty($data->link->settings->branding->name)): ?>
                                            <a href="<?= !empty($data->link->settings->branding->url) ? $data->link->settings->branding->url : '#' ?>" style="<?= $data->link->design->text_style ?>"><?= $data->link->settings->branding->name ?></a>
                                            <?php else: ?>
                                            <?php
                                                $replacers = [
                                                '{{URL}}' => url(),
                                                '{{WEBSITE_TITLE}}' => settings()->main->title,
                                                '{{AFFILIATE_URL_TAG}}' => \Altum\Plugin::is_active('affiliate') && settings()->affiliate->is_enabled ? '?ref=' . $data->user->referral_key : null,
                                                ];
                                                
                                                settings()->links->branding = str_replace(
                                                array_keys($replacers),
                                                array_values($replacers),
                                                settings()->links->branding
                                                );
                                            ?>
                                            <?= settings()->links->branding ?>
                                            <?php endif ?>
                                            <?php endif ?>
                                        </div>
                                    </footer>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?= \Altum\Event::get_content('modals') ?>
                    </div>
                </body>
                
    </swiper-slide>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<?php }?>
<?php //var_dump($data->biolink_blocks); ?>
<?php endforeach ?>
<?php //var_dump($tmlinkidlist); ?>
</swiper-container>

<?php ob_start() ?>
<script>
    /* Internal tracking for biolink page blocks */
    document.querySelectorAll('a[data-track-biolink-block-id]').forEach(element => {
        element.addEventListener('click', event => {
            let biolink_block_id = event.currentTarget.getAttribute('data-track-biolink-block-id');
            navigator.sendBeacon(`${site_url}l/link?biolink_block_id=${biolink_block_id}&no_redirect`);
        });
    });
    

    /* Fix CSS when using scroll for background attachment on long content */
    if(document.body.offsetHeight > window.innerHeight) {
        let background_attachment = document.querySelector('body').style.backgroundAttachment;
        if(background_attachment == 'scroll') {
            document.documentElement.style.height = 'auto';
        }
    }
</script>

<?= $this->views['pixels'] ?? null ?>

<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

