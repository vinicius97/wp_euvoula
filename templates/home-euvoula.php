<?php
/**
 * Template name: euvoula
 */

get_header(); ?>


    <div class="container box">

        <!--===============================-->
        <!--== Section ====================-->
        <!--===============================-->
        <section class="row">

            <div class="col-sm-12" style="margin-top: -30px; z-index: 999;">

                <div class="item-block-content">
                    <form action="<?php echo get_permalink( $all_events ); ?>/buscar/" method="get" accept-charset="UTF-8">

                        <div class="col-sm-3">

                            <select id="listingFormTime" name="time">

                                <option value="">Quando?</option>
                                <option value="1">Hoje</option>
                                <option value="2">Esta semana</option>
                                <option value="3">Este mês</option>

                            </select>

                        </div>

                        <div class="col-sm-3">

                            <select name="category">

                                <option value="">O que?</option>

                                <?php

                                $categories = get_categories( array('taxonomy' => 'event_cat', 'hide_empty' => false,  'parent' => 0) );

                                foreach ($categories as $category) {
                                    $option = '<option value="'.$category->slug.'">';
                                    $option .= $category->cat_name;
                                    $option .= '</option>';

                                    $catID = $category->term_id;

                                    $categories_child = get_categories( array('taxonomy' => 'event_cat', 'hide_empty' => false,  'parent' => $catID) );

                                    foreach ($categories_child as $category_child) {
                                        $option .= '<option value="'.$category_child->slug.'"> - ';
                                        $option .= $category_child->cat_name;
                                        $option .= '</option>';

                                    }

                                    echo $option;
                                }

                                ?>

                            </select>

                        </div>

                        <div class="col-sm-3">

                            <select name="location">

                                <option value="">Onde?</option>

                                <?php

                                $categories = get_categories( array('taxonomy' => 'event_loc', 'hide_empty' => false,  'parent' => 0) );

                                foreach ($categories as $category) {
                                    $option = '<option value="'.$category->slug.'">';
                                    $option .= $category->cat_name;
                                    $option .= '</option>';

                                    $catID = $category->term_id;

                                    $categories_child = get_categories( array('taxonomy' => 'event_loc', 'hide_empty' => false,  'parent' => $catID) );

                                    foreach ($categories_child as $category_child) {
                                        $option .= '<option value="'.$category_child->slug.'"> - ';
                                        $option .= $category_child->cat_name;
                                        $option .= '</option>';

                                    }

                                    echo $option;
                                }

                                ?>

                            </select>

                        </div>

                        <div class="col-sm-3" style="text-align: center;">

                            <button class="td-buttom" type="submit" style="width: 100%; padding: 16px 15px;"><i class="fa fa-search"></i><?php _e( 'Encontrar!', 'themesdojo' ); ?></button>

                        </div>

                    </form>

                    <?php

                    $term = $wp_query->get_queried_object();
                    $term_id = $term->slug;

                    ?>

                </div>

            </div>

            <div class="col-sm-12"><noscript><?php _e( 'Your browser does not support JavaScript, or it is disabled. JavaScript must be enabled in order to view listings.', 'themesdojo' ); ?></noscript></div>

            <div class="col-sm-12"><div class="listing-loading"><h3><i class="fa fa-spinner fa-spin"></i></h3></div></div>

        </section>

    </div>

    <div id="main-wrapper" class="content grey-bg">

        <div class="container box">

            <!--===============================-->
            <!--== Section ====================-->
            <!--===============================-->
            <section class="row">

                <div class="col-sm-12">

                    <div class="row">

                        <div class="col-sm-12">

                            <div class="post-excerpt">

                                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                                <?php the_content(); ?>

                                <?php endwhile; endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            </section>
            <!--==========-->

<?php get_footer(); ?>