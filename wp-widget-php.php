<?php    
/*
Plugin Name: Widget z kodem PHP
Description: Dodaje nowy widget z opcją wykonania w nim kodu PHP.
Version: 1.0.0
Author: Sebastian Bort
*/

class WP_Widget_PHP extends WP_Widget {  

    public function __construct() {
        parent::__construct(
            'widget_php',
            'Widget z kodem PHP',
            ['description' => 'Widget z kodem PHP']
        );
    }    

    public function widget($args, $instance) {
    
        extract($args);
        $title = $instance['title'];
 
        echo $before_widget;
        
        if(!empty($title)) {
            echo $before_title . $title . $after_title;
        } 
        
        ob_start();
		eval('?' . '>' . $instance['code']);
		$text = ob_get_contents();
		ob_end_clean();
		
        echo $text;	        
        echo $after_widget;
    }

    public function form($instance) {
        
        $title = isset($instance['title']) ? $instance['title'] : 'Widget z kodem PHP';
        $code = format_to_edit($instance['code']);           
        
        ?>
        <p>
            <label for="<?php echo $this->get_field_name('title'); ?>">Nazwa widgetu</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
         </p>
        <p>
            <label for="<?php echo $this->get_field_name('code'); ?>">Kod PHP do wykonania</label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>"><?php echo $code; ?></textarea>
         </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        
        $instance = [];
        
        $instance['title'] = !empty($new_instance['title']) ? $new_instance['title'] : '';
        $instance['code'] = !empty($new_instance['code']) ? $new_instance['code'] : '';
 
        return $instance;
    }   
} 

add_action('widgets_init', function() {
    register_widget('WP_Widget_PHP');
});

?>