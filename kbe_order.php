<!--==============
	>> KBE Categories / Articles Ordering
==============-->

<?php
    global $post;
?>
<div id="wpbody">
    <div id="wpbody-content">
        <div class="wrap">
            
            <h2><?php _e('Re-Order','kbe')?></h2>
            
            <?php
                $message = "";
                if (isset($_POST['kbe_order_submit'])) { 
                    parent_article_order_update();
                }
                
                $message = "";
                
                if(isset($_POST['kbe_article_submit'])){
                    custome_article_order_update();
                }
            ?>
            
            <div class="kbe_admin_left_bar">
                <!--=============== Re Order Catgories ===============-->
                <div class="kbe_admin_left_content">
                    <div class="kbe_admin_left_heading">
                        <h3><?php _e('Category Order','kbe'); ?></h3>
                    </div>
                    <div class="kbe_admin_body">
                        <form name="custom_order_form" method="post" action="">
                        <?php
                            $kbe_parent_ID = 0;
                            $kbe_args = array(
                                'orderby' => 'terms_order',
                                'order' => 'ASC',
                                'hide_empty' => false,
                                'parent' => $kbe_parent_ID
                            );
                            $kbe_terms = get_terms('kbe_taxonomy', $kbe_args);
                            if($kbe_terms){
                        ?>
                            <p><?php _e('Drag and drop items to customise the order of categories in WP '.KBE_PLUGIN_TITLE,'kbe') ?></p>
                        
                            <ul id="kbe_order_sortable" class="kbe_admin_order">
                            <?php
                                foreach($kbe_terms as $kbe_term) :
                            ?>
                                    <li id="kbe_parent_id_<?php echo $kbe_term->term_id; ?>" class="lineitem <?php echo ($i % 2 == 0 ? 'alternate ' : ''); ?>ui-state-default">
                                        <?php echo $kbe_term->name; ?>
                                    </li>
                            <?php
                                endforeach;
                            ?>
                            </ul>
                            <img src="<?php echo esc_url(admin_url('images/wpspin_light.gif')); ?>" id="kbe_custom_loading" style="display:none" alt="" />
                            <input type="submit" name="kbe_order_submit" id="kbe_order_submit" class="button-primary" value="<?php _e('Save Order', 'kbe') ?>" />
                            <input type="hidden" id="kbe_parent_custom_order" name="kbe_parent_custom_order" />
                            <input type="hidden" id="kbe_parent_id" name="kbe_parent_id" value="<?php echo $kbe_parent_ID; ?>" />
                        <?php
                            }else{
                        ?>
                            <p>
                                <?php _e('No terms found', 'kbe'); ?>
                            </p>
                        <?php
                            }
                        ?>
                        </form>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#kbe_custom_loading").hide();
                            jQuery("#kbe_order_submit").click(function() {
                                kbeOrderSubmit();
                            });
                        });
						
                        function kbe_custome_order(){
                            //alert("hello 2");
                            jQuery("#kbe_order_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };
						
                        addLoadEvent(kbe_custome_order);
                        function kbeOrderSubmit() {
                            var kbeParentNewOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            //alert(kbeParentNewOrder);
                            //var newChildOrder = jQuery("#kbe_order_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading").show();
                            jQuery("#kbe_parent_custom_order").val(kbeParentNewOrder);
                            //jQuery("#hidden-custom-child-order").val(newChildOrder);
                            return true;
                        }
                    </script>
                </div>
            
                <!--=============== Re Order Articles ===============-->
                <div class="kbe_admin_left_content">
                    <div class="kbe_admin_left_heading">
                        <h3><?php _e('Article Order','kbe'); ?></h3>
                    </div>
                    <div class="kbe_admin_body">
                        <form name="custom_order_form" method="post" action="">
                        <?php
                            $kbe_article_args = new WP_Query(array(
                                                        'post_type' => 'kbe_knowledgebase',
                                                        'order'     => 'ASC',
                                                        'orderby'   => 'menu_order',
                                                        'nopaging'  => true,
                                                    ));
                            if($kbe_article_args->have_posts()){
                        ?>
                            <p><?php _e('Drag and drop items to customise the order of articles in WP '.KBE_PLUGIN_TITLE,'kbe') ?></p>
                            
                            <ul id="kbe_article_sortable" class="kbe_admin_order">
                            <?php
                                while($kbe_article_args->have_posts()) :
                                    $kbe_article_args->the_post();
                            ?>
                                    <li id="kbe_article_id_<?php echo the_ID(); ?>" class="lineitem <?php echo ($i % 2 == 0 ? 'alternate ' : ''); ?>ui-state-default">
                                        <?php the_title(); ?>
                                    </li>
                            <?php
                                endwhile;
                            ?>
                            </ul>
                            <img src="<?php echo esc_url(admin_url('images/wpspin_light.gif')); ?>" id="kbe_custom_loading_article" style="display:none" alt="" />
                            <input type="submit" name="kbe_article_submit" id="kbe_article_submit" class="button-primary" value="<?php _e('Save Order', 'kbe') ?>" />
                            <input type="hidden" id="kbe_article_custom_order" name="kbe_article_custom_order" />
                        <?php
                            }else{
                        ?>
                            <p>
                                <?php _e('No Articles found', 'kbe'); ?>
                            </p>
                        <?php
                            }
                        ?>
                        </form>
                    </div>
                    <script type="text/javascript">
                        jQuery(document).ready(function() {
                            jQuery("#kbe_custom_loading_article").hide();
                            jQuery("#kbe_article_submit").click(function() {
                                kbeArticleSubmit();
                            });
                        });
						
                        function kbe_custome_order_article(){
                            //alert("hello 2");
                            jQuery("#kbe_article_sortable").sortable({
                                    placeholder: "sortable-placeholder",
                                    revert: false,
                                    tolerance: "pointer"
                            });
                        };
						
                        addLoadEvent(kbe_custome_order_article);
                        function kbeArticleSubmit() {
                            var kbeArticleNewOrder = jQuery("#kbe_article_sortable").sortable("toArray");
                            jQuery("#kbe_custom_loading_article").show();
                            jQuery("#kbe_article_custom_order").val(kbeArticleNewOrder);
                            return true;
                        }
                    </script>
                </div>
            </div>
            
            <?php
                /*====================>>_ Update Category Query _<<====================*/
                function parent_article_order_update() {
                    if (isset($_POST['kbe_parent_custom_order']) && $_POST['kbe_parent_custom_order'] != "") { 
                        
                        global $wpdb;
    
                        $parent_new_order = $_POST['kbe_parent_custom_order'];
                        //echo $parent_new_order.'<br />';
                        $parent_IDs = explode(",", $parent_new_order);
                        //print_r($parent_IDs).'<br />';
                        $parent_result = count($parent_IDs);
                        for($p = 0; $p < $parent_result; $p++) {
                            $parent_str = str_replace("kbe_parent_id_", "", $parent_IDs[$p]);
                            //echo $parent_str."<br />";
                            //echo "UPDATE $wpdb->terms SET term_order = '$p' WHERE term_id ='$parent_str'"."<br />";
                            $term_update = "UPDATE $wpdb->terms SET terms_order = '$p' WHERE term_id ='$parent_str'";
                            mysql_query($term_update);
                        }
                        echo '<div id="message" class="updated fade"><p>'. __('Category Order updated successfully.', 'kbe').'</p></div>';
                    }else{
                        echo '<div id="message" class="error fade"><p>'. __('An error occured, order has not been saved.', 'kbe').'</p></div>';
                    }
                }
                
                /*====================>>_ Update Articles Query _<<====================*/
                function custome_article_order_update(){
                    if (isset($_POST['kbe_article_custom_order']) && $_POST['kbe_article_custom_order'] != "") { 
                        global $wpdb;
    
                        $article_new_order = $_POST['kbe_article_custom_order'];
                        //echo $article_new_order.'<br />';
                        $article_IDs = explode(",", $article_new_order);
                        //print_r($article_IDs).'<br />';
                        $article_result = count($article_IDs);
                        
                        for($a = 0; $a < $article_result; $a++) {
                            $article_str = str_replace("kbe_article_id_", "", $article_IDs[$a]);
                            //echo $article_str."<br />";
                            $article_update = "UPDATE $wpdb->posts SET menu_order = '$a' WHERE ID ='$article_str'";
                            mysql_query($article_update);
                        }
                        echo '<div id="message" class="updated fade"><p>'. __('Article Order updated successfully.', 'kbe').'</p></div>';
                    }else{
                        echo '<div id="message" class="error fade"><p>'. __('An error occured, order has not been saved.', 'kbe').'</p></div>';
                    }
                }
            ?>
            
	</div>
    </div>
</div>