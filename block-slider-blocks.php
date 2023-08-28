<?php
/* Block. Slider Blocks */
$slider_background_color = get_sub_field('slider_background_color');
$slider_headline_color = get_sub_field('slider_headline_color');
$slider_subheadline_color = get_sub_field('slider_subheadline_color');
$slider_text_color = get_sub_field('slider_text_color');
$slider_button_bg_color = get_sub_field('slider_button_bg_color');
$slider_button_text_color = get_sub_field('slider_button_text_color');

$slider = get_sub_field('slider_blocks_slider');

//var_dump($slider);

if ($slider){
?>

    <section class="slider-blocks-section" style="
        --background-color: <?php echo $slider_background_color; ?>;
        --title-color: <?php echo $slider_headline_color; ?>;
        --sub-title-color: <?php echo $slider_subheadline_color; ?>;
        --texy-color: <?php echo $slider_text_color; ?>;
        --button-background-color: <?php echo $slider_button_bg_color."!important"; ?>;
        --button-text-color: <?php echo $slider_button_text_color."!important"; ?>;
        ">
      <div class="wrapper">
        <div class="slider-blocks test">
            <?php foreach ($slider as $item): ?>
                <div class="slider-item">
                    <div class="box-info">
                        <?php if (trim($item['slider_headline'])){ ?>
                            <h2><?php echo $item['slider_headline'] ?></h2>
                        <?php } ?>
                        <?php /*print_r($item['sub_slider']);
                        echo "fddfg";*/
                        ?>
                        <?php //if (trim($item['sub_slider'])){
                            foreach ($item['sub_slider'] as $sub_slider): ?>
                                <div class="slider-blocks-items">
                                    <?php //if (trim($item['slider_subheadline'])){ ?>
                                        <h5><?php echo $sub_slider['slider_subheadline'] ?></h5>
                                    <?php /*}
                                    if (trim($item['slider_text'])){ */?> 
                                        <p><?php echo $sub_slider['slider_text'] ?></p>
                                    <?php //} ?>
                                </div>
                            <?php endforeach;
                        //} ?>
                        <?php if (trim($item['slider_button']['url']) || trim($item['slider_button']['title']))  { ?>
                            <a href="<?php echo $item['slider_button']['url'] ?>"><?php echo $item['slider_button']['title'] ?></a>
                        <?php } ?>
                    </div>
                    <div class="box-image">
                        <!--<img src="<?php //if(wp_is_mobile()){ echo $item['mobile_image']; } else { echo $item['image']; } ?>" alt="">-->
                        <picture>
                            <source srcset="<?php echo $item['mobile_image'];?>"
                                media="(max-width: 480px)">
                            <!--<source srcset="<?php //echo $header_block_tablet_image;?>"
                                media="(max-width: 1380px)">-->
                            <img src="<?php echo $item['image'];?>" alt="" />
                        </picture>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <div class="carousel__arrows">
                <div class="slider-with-text-blocks--right"><img src="<?php echo esc_url(get_template_directory_uri())?>/html/app/img/arrows/right.svg" alt=""></div>
                <div class="slider-with-text-blocks--left"><img src="<?php echo esc_url(get_template_directory_uri())?>/html/app/img/arrows/left.svg" alt=""></div>
        </div>
      </div>
    </section>
<?php } else {
    echo "<h5 class='error-message'>Error: Slider with 1-3 Text Box(es) couldn't be found! Please check if the content really exists.</h5><h5 style='blame-and-refill'>If disappeared, then you need to blame the developer(s) <b>BEFORE</b> Arthur Sarkisian, then refill the content again ¯\_(ツ)_/¯<br/><br/><h5 class='quick-advice'><i>Psst. One quick advice:</i> Before editing the page you can backup/export it, so in this case you'll just import it.</h5><h5 class='doesnt-seem-to-work-always'> But this doesn't seem to work always, because that dev(s) before him have done really bad work. Cause even after restoring a revision it should come back.</h4>";
}