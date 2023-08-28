<?php
/* Block. Main Banner */
//Content img
  $image_main_banner = get_sub_field('image_main_banner');
  $tablet_image_main_banner = get_sub_field('tablet_image_main_banner');
  $mobile_image_main_banner = get_sub_field('mobile_image_main_banner');
//Content text and button
  $title_main_banner = get_sub_field('title_main_banner');
  $description_main_banner = get_sub_field('description_main_banner');
  $button_main_banner = get_sub_field('button_main_banner');
//Settings
  $background_block_type_mb = get_sub_field('background_block_type_mb');
  $use_margin_bottom_main_banner = get_sub_field('use_margin_bottom_main_banner');
  $use_short_description_block = get_sub_field('use_short_description_block');
  $auto_height_main_banner = get_sub_field('auto_height_main_banner');
//Colors
  $background_color_mb = get_sub_field('background_color_mb');
  $title_color_mb = get_sub_field('title_color_mb');
  $description_color_mb = get_sub_field('description_color_mb');
  $button_background_color_mb = get_sub_field('button_background_color_mb');
  $button_color_mb = get_sub_field('button_color_mb');

  if( is_home() || is_front_page() ) {

    $section_banner_class = ' agentur-banner';

    if( $use_margin_bottom_main_banner ) {
        $section_banner_class = ' agentur-banner';
    }

    /*var_dump("TRIM: ".trim($title_main_banner));
    echo "trim: ";*/
?>
        <section
          class="main-banner<?php echo $section_banner_class; ?>"
          style="
            --background-color: <?php echo $background_color_mb; ?>;
            --title-color: <?php echo $title_color_mb; ?>;
            --desc-color: <?php echo $description_color_mb; ?>;
            --button-bg-color: <?php echo $button_background_color_mb; ?>;
            --button-color: <?php echo $button_color_mb; ?>
          "
        >
          <?php if ($background_block_type_mb === 'image_bg' && !empty($image_main_banner)): ?>
            <?php
              /*echo pioneer_get_image(array(
                  'deck' => $image_main_banner,
                  'size' => 'full',
                  'lazy' => true,
                  'class' => 'main-banner__bg',
              ));*/
            ?>
        <div class="picth1">
            <picture>
              <source srcset="<?php echo $mobile_image_main_banner;?>"
                media="(max-width: 480px)">
              <source srcset="<?php echo $tablet_image_main_banner;?>"
                media="(max-width: 1380px)">
              <img src="<?php echo $image_main_banner;?>" alt="Main Banner Alt text" width="100%" />
            </picture>
          <?php endif; ?>
          <?php if (trim($title_main_banner) || trim($description_main_banner) || $button_main_banner){ ?>
            <div class="wrapper">
              <div class="b-main-banner b-main-banner-absolute">
              <?php if (trim($title_main_banner)){ ?>
                  <h1 class="b-main-banner__h1">
                    <?php echo wp_kses( $title_main_banner, minimal_allowed_tags() ); ?>
                  </h1>
              <?php } if ($description_main_banner){ ?>
                  <div class="b-main-banner__txt">
                    <?php echo $description_main_banner; ?>
                </div>
              <?php } ?>
                <?php if ($button_main_banner){ ?>
                  <div class="b-main-banner__btn-row">
                    <a class="btn-blue" href="<?php echo esc_url( $button_main_banner['url'] ); ?>">
                      <?php echo empty($button_main_banner['title'])? esc_html__( 'Über uns', 'pioneer' ) : esc_html__( $button_main_banner['title'] ); ?>
                    </a>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
         </div>
        </section>

<?php } else {

      $desc_class = '';
      if( $use_short_description_block ) {
          $desc_class = ' b-agentur-banner__txt--w760';
      }

      ?>

      <section
        class="agentur-banner"
        style="
          --background-color: <?php echo $background_color_mb; ?>;
          --title-color: <?php echo $title_color_mb; ?>;
          --desc-color: <?php echo $description_color_mb; ?>;
          --button-bg-color: <?php echo $button_background_color_mb; ?>;
          --button-color: <?php echo $button_color_mb; ?>
        "
      >
        <?php if ($background_block_type_mb === 'image_bg' && !empty($image_main_banner)): ?>
          <?php
            /*echo pioneer_get_image(array(
                'deck' => $image_main_banner,
                'size' => 'full',
                'lazy' => true,
                'class' => 'main-banner__bg',
            ));*/
          ?>
        <div class="picth1">
          <picture>
              <source srcset="<?php echo $mobile_image_main_banner;?>"
                media="(max-width: 480px)">
              <source srcset="<?php echo $tablet_image_main_banner;?>"
                media="(max-width: 1380px)">
              <img src="<?php echo $image_main_banner;?>" alt="" />
            </picture>
        <?php endif; ?>
        <?php if (trim($title_main_banner) || trim($description_main_banner) || $button_main_banner){ ?>
          <div class="wrapper">
              <div class="b-agentur-banner b-main-banner-absolute" <?php echo $auto_height_main_banner ? 'style="min-height: auto; padding-bottom: 0;"':''; ?>>
                <?php if (trim($title_main_banner)){ ?>  
                  <h1 class="b-agentur-banner__h1">
                      <?php echo wp_kses( $title_main_banner, minimal_allowed_tags() ); ?>
                  </h1>
                <?php } if (trim($description_main_banner)){ ?>
                  <div class="b-agentur-banner__txt<?php esc_attr_e( $desc_class ); ?>">
                      <?php echo $description_main_banner; ?>
                  </div>
                <?php } ?>
                  <?php if ($button_main_banner){ ?>
                      <div class="b-main-banner__btn-row">
                          <a class="btn-blue" href="<?php echo esc_url( $button_main_banner['url'] ); ?>">
                              <?php echo empty($button_main_banner['title'])? esc_html__( 'Über uns', 'pioneer' ) : esc_html__( $button_main_banner['title'] ); ?>
                          </a>
                      </div>
                  <?php } ?>
              </div>
            </div>
          <?php } ?>
          </div>
      </section>

<?php } ?>
