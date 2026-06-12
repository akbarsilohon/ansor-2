<?php

class Ansor_Widget_Popular extends WP_Widget {
    public function __construct(){
        parent::__construct(
            'ansor_popular_list',
            'Ansor Popular Post', [
                'classname'     =>  'ansor-popular-list',
                'description'   =>  'Render postingan populer'
            ]
        );
    }

    // Form for user manage options ====================
    public function form( $instance ){
        $title    = $instance['title'] ?? 'Berita Populer';
        $number   = $instance['number'] ?? 5;
        $random   = $instance['random'] ?? 0; ?>

        <p>
            <label>Widget Name</label>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>">
        </p>

        <p>
            <label>Index Count</label>
            <input class="tiny-text" type="number" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo esc_attr($number); ?>">
        </p>

        <p>
            <input type="checkbox" name="<?php echo $this->get_field_name('random'); ?>" value="1" <?php checked($random, 1); ?>>
            <label>Random</label>
        </p>

        <?php
    }


    // Update Instance form =========================
    public function update( $new_instance, $old_instance ){
        $instance = [];
        $instance['title']    = sanitize_text_field($new_instance['title']);
        $instance['number']   = intval($new_instance['number']);
        $instance['random']   = !empty($new_instance['random']) ? 1 : 0;

        return $instance;
    }


    // render view widgets ===========================
    public function widget( $args, $instance ){
        $title    = $instance['title'] ?? '';
        $number   = $instance['number'] ?? 5;
        $random   = $instance['random'] ?? 0;

        echo $args['before_widget'];
        if(!empty($title)){
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }

        $query_args = [
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => $number,
            'meta_key'       => 'ansor_post_views',
            'orderby'        => 'meta_value_num',
            'order'          => 'DESC'
        ];
        if($random){
            $query_args['orderby'] = 'rand';
        }

        $popular = new WP_Query( $query_args );
        $counter = 1;

        if( $popular->have_posts()){
            while( $popular->have_posts()){
                $popular->the_post();
                $number = sprintf('%02d', $counter);

                if( $counter === 1 ){ ?>
                    <div class="nm-vis-big">
                        <div class="nm-vis-img">
                            <span class="nm-vis-big-num"><?php echo $number; ?></span>
                            <a href="<?php the_permalink(); ?>">
                                <?php echo gp_ansor_thumbnail( get_the_ID(), 'full', 'lazy', 'news_thumb' ); ?>
                            </a>
                        </div>
                        <h4 class="nm-vis-big-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                    </div>
                    <?php
                } else { ?>
                    <div class="nm-vis-item">
                        <div class="nm-vis-circle"><?php echo $number; ?></div>
                        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    </div>
                    <?php
                }

                $counter++;
            }
        }

        wp_reset_postdata();
        echo $args['after_widget'];
    }
}