<?php defined('ALTUMCODE') || die() ?>

<style>
.stage {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}
.<?= 'wrapper_'.$data->link->biolink_block_id ?> {
  position: relative;
  color: <?= $data->link->settings->text_color ?>;
  font-size: <?= $data->link->settings->font_size ?>em;
  text-transform: uppercase;
  letter-spacing: 0.25rem;
  padding-top: 0.65rem;
  padding-left: 0.5rem;
  padding-right: 0.36rem;
  padding-bottom: 0.2rem;
}
.<?= 'slash_'.$data->link->biolink_block_id ?> {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  transform-origin: center center;
  width: 0.15rem;
  height: 145%;
  background: #fff;
  z-index: 4;
  -webkit-animation: slash 6s ease-in infinite;
          animation: slash 6s ease-in infinite;
}
.<?= 'slash_'.$data->link->biolink_block_id ?>:before {
  content: '';
  display: block;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 0.75rem;
  height: 120%;
  background: <?= $data->link->settings->background_color ?>;
  z-index: -1;
}
.<?= 'slash_'.$data->link->biolink_block_id ?>:after {
  content: '';
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: <?= $data->link->settings->text_color ?>;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  overflow: hidden;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> .<?= 'side_'.$data->link->biolink_block_id ?> {
  position: absolute;
  background: <?= $data->link->settings->background_color ?>;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> .<?= 'side_'.$data->link->biolink_block_id ?>:nth-child(1) {
  top: 0;
  left: 0;
  width: 100%;
  height: 0.15rem;
  transform: translateX(-101%);
  -webkit-animation: side-top ease 6s infinite;
          animation: side-top ease 6s infinite;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> .<?= 'side_'.$data->link->biolink_block_id ?>:nth-child(2) {
  top: 0;
  right: 0;
  width: 0.15rem;
  height: 100%;
  transform: translateY(-101%);
  -webkit-animation: side-right ease 6s infinite;
          animation: side-right ease 6s infinite;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> .<?= 'side_'.$data->link->biolink_block_id ?>:nth-child(3) {
  left: 0;
  bottom: 0;
  width: 100%;
  height: 0.15rem;
  transform: translateX(101%);
  -webkit-animation: side-bottom ease 6s infinite;
          animation: side-bottom ease 6s infinite;
}
.<?= 'sides_'.$data->link->biolink_block_id ?> .<?= 'side_'.$data->link->biolink_block_id ?>:nth-child(4) {
  top: 0;
  left: 0;
  width: 0.15rem;
  height: 100%;
  transform: translateY(101%);
  -webkit-animation: side-left ease 6s infinite;
          animation: side-left ease 6s infinite;
}
.text {
  position: relative;
}
.text--backing {
  opacity: 0;
}
.text--left {
  position: absolute;
  top: 0;
  left: 0;
  width: 51%;
  height: 100%;
  overflow: hidden;
}
.text--left .inner {
  transform: translateX(100%);
  -webkit-animation: text-left 6s ease-in-out infinite;
          animation: text-left 6s ease-in-out infinite;
}
.text--right {
  position: absolute;
  top: 0;
  right: 0;
  width: 50%;
  height: 100%;
  overflow: hidden;
}
.text--right .inner {
  transform: translateX(-200%);
  -webkit-animation: text-right 6s ease-in-out infinite;
          animation: text-right 6s ease-in-out infinite;
}
@-webkit-keyframes <?= 'slash_'.$data->link->biolink_block_id ?> {
  0% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
  6% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(1);
  }
  13% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(1);
  }
  16.6% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
  100% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
}
@keyframes <?= 'slash_'.$data->link->biolink_block_id ?> {
  0% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
  6% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(1);
  }
  13% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(1);
  }
  16.6% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
  100% {
    transform: translate(-50%, -50%) rotate(-24deg) scaleY(0);
  }
}
@-webkit-keyframes text-left {
  0% {
    transform: translateX(100%);
  }
  10% {
    transform: translateX(0);
  }
  58% {
    transform: translateX(0);
  }
  70% {
    transform: translateX(-200%);
  }
  100% {
    transform: translateX(-200%);
  }
}
@keyframes text-left {
  0% {
    transform: translateX(100%);
  }
  10% {
    transform: translateX(0);
  }
  58% {
    transform: translateX(0);
  }
  70% {
    transform: translateX(-200%);
  }
  100% {
    transform: translateX(-200%);
  }
}
@-webkit-keyframes text-right {
  0% {
    transform: translateX(-200%);
  }
  10% {
    transform: translateX(-100%);
  }
  58% {
    transform: translateX(-100%);
  }
  70% {
    transform: translateX(-300%);
  }
  100% {
    transform: translateX(-300%);
  }
}
@keyframes text-right {
  0% {
    transform: translateX(-200%);
  }
  10% {
    transform: translateX(-100%);
  }
  58% {
    transform: translateX(-100%);
  }
  70% {
    transform: translateX(-300%);
  }
  100% {
    transform: translateX(-300%);
  }
}
@-webkit-keyframes side-top {
  0%, 14% {
    transform: translateX(-101%);
  }
  24%, 55% {
    transform: translateX(0);
  }
  65% {
    transform: translateX(101%);
  }
  100% {
    transform: translateX(101%);
  }
}
@keyframes side-top {
  0%, 14% {
    transform: translateX(-101%);
  }
  24%, 55% {
    transform: translateX(0);
  }
  65% {
    transform: translateX(101%);
  }
  100% {
    transform: translateX(101%);
  }
}
@-webkit-keyframes side-right {
  0%, 14%, 23% {
    transform: translateY(-101%);
  }
  30%, 62% {
    transform: translateY(0);
  }
  72% {
    transform: translateY(101%);
  }
  100% {
    transform: translateY(101%);
  }
}
@keyframes side-right {
  0%, 14%, 23% {
    transform: translateY(-101%);
  }
  30%, 62% {
    transform: translateY(0);
  }
  72% {
    transform: translateY(101%);
  }
  100% {
    transform: translateY(101%);
  }
}
@-webkit-keyframes side-bottom {
  0%, 14%, 24%, 28% {
    transform: translateX(101%);
  }
  37%, 70% {
    transform: translateX(0);
  }
  79% {
    transform: translateX(-101%);
  }
  100% {
    transform: translateX(-101%);
  }
}
@keyframes side-bottom {
  0%, 14%, 24%, 28% {
    transform: translateX(101%);
  }
  37%, 70% {
    transform: translateX(0);
  }
  79% {
    transform: translateX(-101%);
  }
  100% {
    transform: translateX(-101%);
  }
}
@-webkit-keyframes side-left {
  0%, 14%, 24%, 34%, 35% {
    transform: translateY(101%);
  }
  44%, 79% {
    transform: translateY(0);
  }
  86% {
    transform: translateY(-101%);
  }
  100% {
    transform: translateY(-101%);
  }
}
@keyframes side-left {
  0%, 14%, 24%, 34%, 35% {
    transform: translateY(101%);
  }
  44%, 79% {
    transform: translateY(0);
  }
  86% {
    transform: translateY(-101%);
  }
  100% {
    transform: translateY(-101%);
  }
}
</style>

<script>
const curry = f => (...args) =>
args.length >= f.length ?
f(...args) :
curry(f.bind(f, ...args));

const compose = (f, g) => x => f(g(x));
const composeN = (...fns) => (...args) =>
fns.reverse().
reduce((x, f) => f.apply(f, [].concat(x)), args);
</script>
   

<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-12 my-2">
          
    
    <div class="stage">
  <div class="<?= 'wrapper_'.$data->link->biolink_block_id ?>">
    <div class="<?= 'slash_'.$data->link->biolink_block_id ?>"></div>
    <div class="<?= 'sides_'.$data->link->biolink_block_id ?>">
      <div class="<?= 'side_'.$data->link->biolink_block_id ?>"></div>
      <div class="<?= 'side_'.$data->link->biolink_block_id ?>"></div>
      <div class="<?= 'side_'.$data->link->biolink_block_id ?>"></div>
      <div class="<?= 'side_'.$data->link->biolink_block_id ?>"></div>
    </div>
    <div class="text">
      <div class="text--backing"><?= $data->link->settings->text ?></div>
      <div class="text--left">
        <div class="inner"><?= $data->link->settings->text ?></div>
      </div>
      <div class="text--right">
        <div class="inner"><?= $data->link->settings->text ?></div>
      </div>
    </div>
  </div>
</div>



</div>