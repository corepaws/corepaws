<?php /* Template Name: Adoption Listing & Search */ ?>

<?php get_header(); ?>

<?php the_post(); ?>

    <main id="search">

        <div class="container">


            <?php

            // Queries all of the states for the published shelters

            $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            //Search Parameters: dog,cat

            $animal_array = [];

            if (isset($_GET['animal'])) {

                $animal_array = explode(',', $_GET['animal']);

            }

            // Shelter parameter - if shelter selected ignore city/state
            if (isset($_GET['location'])) {
                $selected_shelters = ["" . intval($_GET['location'])];
            }

            // Pet Query

            $pet_args = array(

                'post_type' => 'pet',

                'numberposts' => -1,

                'paged' => $paged,

                'posts_per_page' => 12,

                /*'orderby' => 'rand',*/

                'order' => 'ASC',

                'meta_query' => array(

                    'relation' => 'AND',

                    array(

                        'key' => 'animal',

                        'value' => $animal_array,

                        'compare' => 'IN'

                    )

                )

            );


            //Search Parameters: special,chance,senior,behavioral,capacity

            if (isset($_GET['category'])) {

                $placement_array = explode(',', $_GET['category']);

                $pet_args['tax_query'] = array(

                    'relation' => 'AND',

                    array(

                        'taxonomy' => 'reason_for_placement',

                        'field' => 'slug',

                        'terms' => $placement_array

                    )

                );

            }


            // Runs Search Query
            $pet_query = new WP_Query($pet_args);

            ?>


            <div id="heading">
                <h2 class="page-title"><?php the_field('headline'); ?></h2>
                <?php the_field('content'); ?>
            </div>


            <div id="sidebar">
                <div class="controls">

                    <h3>Let the Search Begin!</h3>

                    <div class="option group3">
                        <h3>Choose a Rescue Animal:</h3>
                        <?php if (isset($_GET['animal'])) {
                            $animal = explode(',', $_GET['animal']);
                        } ?>

                        <div class="choice"><input type="checkbox"
                                                   name="animal" <?php if (isset($animal) && in_array('dog', $animal)) {
                                echo "checked";
                            } ?> value="dog"><label>Dog</label></div>

                        <div class="choice"><input type="checkbox"
                                                   name="animal" <?php if (isset($animal) && in_array('cat', $animal)) {
                                echo "checked";
                            } ?> value="cat"><label>Cat</label></div>
                    </div>


                    <div class="option group4">
                        <h3>Choose a Category:</h3>

                        <?php if (isset($_GET['category'])) {
                            $category = explode(',', $_GET['category']);
                        } ?>

                        <div class="choice"><input type="checkbox"
                                                   name="category" <?php if (isset($category) && in_array('special', $category)) {
                                echo "checked";
                            } ?> value="special"><label>Special Needs</label></div>

                        <?php /*<div class="choice"><input type="checkbox" name="category" <?php if (isset($category) && in_array('chance',$category)){echo "checked";} ?> value="chance"><label>2nd or 3rd Chance</label></div>*/; ?>

                        <div class="choice"><input type="checkbox"
                                                   name="category" <?php if (isset($category) && in_array('senior', $category)) {
                                echo "checked";
                            } ?> value="senior"><label>Senior Animal</label></div>

                        <div class="choice"><input type="checkbox"
                                                   name="category" <?php if (isset($category) && in_array('behavioral', $category)) {
                                echo "checked";
                            } ?> value="behavioral"><label>Behavioral Challenges(s)</label></div>
                    </div>

                    <div class="searchButtonWrapper">
                        <div>
                            <button id="searchClear" type="button" class="btn-large button" aria-label="SearchButton"
                                    style="display: none">Clear
                            </button>
                        </div>
                        <div>
                            <button id="adoptionSearch" type="submit" class="btn-large button orange"
                                    aria-label="SearchButton">Search!
                            </button>
                        </div>
                    </div>

                </div>

            </div>


            <div id="listing">
                <?php // No Results message
                if ($pet_query->post_count == 0) {
                    echo '<div class="no-results">';
                    if (isset($selected_shelters)) {
                        echo "This partner does not currently have any animals listed. Please check back as we constantly add new animals looking for a forever home!";
                    } else {
                        echo "No results were returned from your search.  Please adjust your search criteria and try again.";
                    }
                    echo '</div>';
                }
                ?>
                <?php while ($pet_query->have_posts()) {
                    $pet_query->the_post(); ?>
                    <div class="result">
                        <div class="info">
                            <h3 class="section-heading"><?php echo get_the_title(); ?></h3>
                            <div class="since">Arrived: <span><?php the_time(get_option('date_format')); ?></span></div>
                        </div>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail'); ?>
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
                        <?php the_excerpt(); ?>
                        <a class="btn-small" href="<?php the_permalink(); ?>">Read More</a>
                    </div>

                <?php } ?>

            </div>


            <?php wp_reset_postdata(); ?>


            <div id="pages">

                <?php //Creates the Pagination


                $base_url = get_bloginfo('url') . "/adoption/page";

                $search_url = $_SERVER['QUERY_STRING'];

                if (isset($search_url) && $search_url != '') {
                    $search_url = "?" . $search_url;
                }


                if ($pet_query->max_num_pages >= 2) {

                    if ($paged == 0) {

                        $back = $pet_query->max_num_pages;

                        $next = $paged + 2;

                    } else if ($paged == $pet_query->max_num_pages) {

                        $back = $paged - 1;

                        $next = 1;

                    } else {

                        $back = $paged - 1;

                        $next = $paged + 1;

                    }

                    $back = $base_url . "/" . $back . "/" . $search_url;

                    $next = $base_url . "/" . $next . "/" . $search_url;


                    echo "<ul>";

                    echo "<li class='back'><a href='" . $back . "'>< Back</a></li>";

                    for ($x = 1; $x <= $pet_query->max_num_pages; $x++) {

                        $active = '';

                        if ($x == $paged || ($x == 1 && $paged == 0)) {

                            $active = 'active';

                        }

                        echo "<li class='page'><a class='" . $active . "' href='" . $base_url . "/" . $x . "/" . $search_url . "'>" . $x . "</li></a>";

                    }

                    echo "<li class='next'><a href='" . $next . "'>Next ></a></li>";

                    echo "</ul>";

                }


                ?>

            </div>

        </div>

        <br/>
    </main>


<?php $conn->close(); ?>

<?php get_footer(); ?>