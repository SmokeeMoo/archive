<?php defined('ALTUMCODE') || die() ?>

<style>
.ribbon {
  --r: .5em;  /* control the cutout of the ribbon */
  --c: #d81a14;
  
  padding-inline: calc(.5em + var(--r));
  text-align: center;
  line-height: 2;
  color: <?= $data->link->settings->text_color ?>;
  background-image: 
    linear-gradient(var(--c) 70%,#0000 0), 
    linear-gradient(to bottom left,#0000 50%, color-mix(in srgb,var(--c),#000 40%) 51% 84%,#0000 85%);
  background-position: 0 .15lh;
  background-size: 100% 1lh;
  clip-path: polygon(0 .15lh,100% .15lh,calc(100% - var(--r)) .5lh,100% .85lh,100% calc(100% - .15lh),0 calc(100% - .15lh),var(--r) calc(100% - .5lh),0 calc(100% - .85lh));
  /* width: fit-content; you may need this in your real use case */
}

/* if you update the line-height, you need to also update the below */
@supports not (height:1lh) {
  .ribbon {
    background-position: 0 .3em;
    background-size: 100% 2em;    
    clip-path: polygon(0 .3em,100% .3em,calc(100% - var(--r)) 1em,100% 1.7em,100% calc(100% - .3em),0 calc(100% - .3em),var(--r) calc(100% - 1em),0 calc(100% - 1.7em))
  }
}

</style>


<div id="<?= 'biolink_block_id_' . $data->link->biolink_block_id ?>" data-biolink-block-id="<?= $data->link->biolink_block_id ?>" class="col-12 my-2">
<div class="col-<?= $data->link->settings->width ?>" style = "text-align: center; margin: 0 auto;">
    <<?= $data->link->settings->title_tag ?> class="ribbon" style="--c: <?= $data->link->settings->background_color ?>">
         <?php foreach($data->link->settings->items as $key => $item): ?>
  <?= $item->title ?><br>
<?php endforeach ?>
 </<?= $data->link->settings->title_tag ?>>
</div>
   

    
 


</div>
