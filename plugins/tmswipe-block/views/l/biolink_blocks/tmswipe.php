<?php defined('ALTUMCODE') || die() ?>
<style>
   html,
    body {
      position: relative;
      height: 100%;
      background: <?= $data->link->settings->border_color ?>;
    }

    body {
      margin: 0;
      padding: 0;
	  padding-top: 0px !important;
    }

    swiper-container {
      width: 100%;
      height: 100%;
    }

    swiper-slide {
      text-align: center;
      font-size: 18px;
      display: flex;
      justify-content: center;
      align-items: start;
      min-height: 100vh;
      height: revert !important;
      overflow-y: overlay;
    }

    swiper-slide img {
      display: block;
      width: 100%;
      object-fit: cover;
    }

    ::slotted(swiper-slide) {
    height: revert !important;
    }
    
:root{
    --swiper-navigation-color: <?= $data->link->settings->text_color ?>;
    --swiper-pagination-color: <?= $data->link->settings->background_color ?>;
    --swiper-pagination-bullet-inactive-color: #fff;
    }

</style>