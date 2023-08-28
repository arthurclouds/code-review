<?php
/* Block. Main Banner + accordeon */

$image_main_banner_ac = get_sub_field('image_main_banner_ac');
$main_banner_ac_bg_color = get_sub_field('main_banner_ac_bg_color');

$section_bg = ( isset( $image_main_banner_ac ) && !empty($image_main_banner_ac) ) ? 'background-url:' . esc_url( $image_main_banner_ac ) . ';' : 'background-color:' . esc_attr( $main_banner_ac_bg_color ) . ';';

$title_main_banner_ac = get_sub_field('title_main_banner_ac');
$description_main_banner_ac = get_sub_field('description_main_banner_ac');
$main_banner_accordeon_repeater = get_sub_field('main_banner_accordeon_repeater');
$button_main_banner_ac = get_sub_field('button_main_banner_ac');

$title_color_mba = get_sub_field('title_color_mba');
$description_color_mba = get_sub_field('description_color_mba');
$question_color_mba = get_sub_field('question_color_mba');
$answer_color_mba = get_sub_field('answer_color_mba');

?>
<section class="deine-ideen"
  style="
    --background-color: <?php echo $main_banner_ac_bg_color; ?>;
    --title-color: <?php echo $title_color_mba; ?>;
    --description-color: <?php echo $description_color_mba; ?>;
    --question-color: <?php echo $question_color_mba; ?>;
    --answer-color: <?php echo $answer_color_mba; ?>;
  "
>

    <div class="wrapper">

      <div class="deine-ideen__header">
        <h1><?php echo wp_kses( $title_main_banner_ac, minimal_allowed_tags() ); ?></h1>
        <?php echo wp_kses_post( $description_main_banner_ac ); ?>
      </div>

      <div class="accordion accordion-faq" id="accordionFAQ-1">

          <?php
          if( $main_banner_accordeon_repeater ) {

              $counter = 1;
              foreach ($main_banner_accordeon_repeater as $accordeon_item) {

                  $main_banner_accordeon_title = $accordeon_item['main_banner_accordeon_title'];
                  $main_banner_number_columns = $accordeon_item['main_banner_number_columns'];

                  ?>

                <div class="accordion-item">
                  <div class="accordion-header">
                    <button class="accordion-button collapsed"
                            type="button" aria-label=""
                            data-bs-toggle="collapse"
                            data-bs-target="#accordionFAQ-tab-<?php echo esc_attr( $counter ); ?>"
                            aria-label="<?php _e('Accordion button', 'pioneer');?>"
                            aria-expanded="false"
                            aria-controls="accordionFAQ-tab-1">
                        <?php esc_html_e( $main_banner_accordeon_title ); ?>
                        <svg class="icon icon-arrow-down-2 accordion-button__arrow">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/html/app/img/svg-sprite/sprite.svg#arrow-down-2"></use>
                        </svg>
                    </button>
                  </div>

                  <div class="accordion-collapse collapse" id="accordionFAQ-tab-<?php echo esc_attr( $counter ); ?>" aria-labelledby="" data-bs-parent="#accordionFAQ-1">
                    <div class="accordion-faq-content">

                        <?php if( 1 === (int) $main_banner_number_columns ) {

                            $main_banner_full_width_content = $accordeon_item['main_banner_full_width_content']; ?>

                            <div class="accordion-faq-content__wide">
                                <?php echo wp_kses_post( $main_banner_full_width_content ); ?>
                            </div>

                        <?php } else {

                            $main_banner_content_left = $accordeon_item['main_banner_content_left'];
                            $main_banner_content_right = $accordeon_item['main_banner_content_right'];

                            ?>

                          <div class="accordion-faq-content__left">
                              <?php echo wp_kses_post( $main_banner_content_left ); ?>
                          </div>

                          <div class="accordion-faq-content__right">
                              <?php echo wp_kses_post( $main_banner_content_right ); ?>
                          </div>

                        <?php }?>

                    </div>
                  </div>
                </div>
              <?php
                  $counter++;
              }
          }?>
      </div>
    </div>
    </section>
