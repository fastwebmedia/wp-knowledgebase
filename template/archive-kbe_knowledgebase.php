<?php
    get_header();
    
    // Classes For main content div
    if(KBE_SIDEBAR_HOME == 0) {
        $kbe_content_class = 'class="kbe_content_full"';
    } elseif(KBE_SIDEBAR_HOME == 1) {
        $kbe_content_class = 'class="kbe_content_right"';
    } elseif(KBE_SIDEBAR_HOME == 2) {
        $kbe_content_class = 'class="kbe_content_left"';
    }
    
    // Classes For sidebar div
    if(KBE_SIDEBAR_HOME == 0) {
        $kbe_sidebar_class = 'kbe_aside_none';
    } elseif(KBE_SIDEBAR_HOME == 1) {
        $kbe_sidebar_class = 'kbe_aside_left';
    } elseif(KBE_SIDEBAR_HOME == 2) {
        $kbe_sidebar_class = 'kbe_aside_right';
    }
?>
<div id="kbe_container">
   
    <!--Breadcrum-->
    <?php
        if(KBE_BREADCRUMBS_SETTING == 1){
    ?>
        <div class="kbe_breadcrum">
            <?php echo kbe_breadcrumbs(); ?>
        </div>
    <?php
        }
    ?>
    <!--/Breadcrum-->
    
    <!--search field-->
    <?php
        if(KBE_SEARCH_SETTING == 1){
            kbe_search_form();
        }
    ?>
    <!--/search field-->
    
    <!--content-->
    <div id="kbe_content" <?php echo $kbe_content_class; ?>>
        <h1><?php echo get_the_title(KBE_PAGE_TITLE) ?></h1>

        <!--leftcol-->
        <div class="kbe_leftcol">
            <div class="kbe_categories">
            <?php
               $kbe_cat_args = array(
                                    'orderby'       => 'terms_order', 
                                    'order'         => 'ASC',
                                    'hide_empty'    => true, 
                                );

                $kbe_terms = get_terms(KBE_POST_TAXONOMY, $kbe_cat_args);

                foreach($kbe_terms as $kbe_taxonomy){
                    $kbe_term_id = $kbe_taxonomy->term_id;
                    $kbe_term_slug = $kbe_taxonomy->slug;
                    $kbe_term_name = $kbe_taxonomy->name;
            ?>
                    <div class="kbe_category">
                        <h2>
                            <span class="kbe_count">
                                <?php
                                    echo $kbe_taxonomy->count;
                                    _e(' Articles','kbe');
                                ?>
                            </span>
                            <a href="<?php echo get_term_link($kbe_term_slug, 'kbe_taxonomy') ?>">
                                <?php echo $kbe_term_name; ?>
                            </a>
                        </h2>

                        <ul class="kbe_article_list">
                        <?php
                            $kbe_tax_post_args = array(
                                                        'post_type' => KBE_POST_TYPE,
                                                        'posts_per_page' => KBE_ARTICLE_QTY,
                                                        'orderby' => 'menu_order',
                                                        'order' => 'ASC',
                                                        'tax_query' => array(
                                                                array(
                                                                        'taxonomy' => KBE_POST_TAXONOMY,
                                                                        'field' => 'term_id',
                                                                        'terms' => $kbe_term_id
                                                                )
                                                        )
                                                );
                            $kbe_tax_post_qry = new WP_Query($kbe_tax_post_args);
                            if($kbe_tax_post_qry->have_posts()) :
                                while($kbe_tax_post_qry->have_posts()) :
                                    $kbe_tax_post_qry->the_post();
                        ?>
                                    <li>
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </li>
                        <?php
                                endwhile;
                            else :
                                echo "No posts";
                            endif;
                        ?>
                        </ul>
                    </div>
            <?php
                }
             ?>
            </div>
        </div>
        <!--/leftcol-->

    </div>
    <!--content-->
    
    <!--aside-->
    <div class="kbe_aside <?php echo $kbe_sidebar_class; ?>">
    <?php
        if((KBE_SIDEBAR_HOME == 2) || (KBE_SIDEBAR_HOME == 1)){
            dynamic_sidebar('kbe_cat_widget');
        }
    ?>
    </div>
    <!--/aside-->
    
</div>
<?php get_footer(); ?>