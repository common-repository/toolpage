<?php
/**
 * Adds ToolPage_Widget widget.
 */
class ToolPage_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'toolpage_widget', // Base ID
			'ToolPage&trade;', // Name
			array( 'description' => __( 'All my ToolPage', 'toolpage' ), '') // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "toolpage"; 
		
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$limit = apply_filters( 'widget_title', $instance['limit'] );
		$order = apply_filters( 'widget_title', $instance['order'] );
		
		if($order != '' && $order != 'rand'){
			$ex = explode("_", $order);
			$q_order = $ex[0].' '.$ex[1];
		}
		elseif($order == 'rand'){
			$q_order = "RAND()";
		}
		else $q_order = "id DESC";
		
		if($limit > 0) $q_limit = " LIMIT ".$limit;
		else $q_limit = "";
		
		$toolpage_data = $wpdb->get_results("SELECT * FROM $table_name ORDER BY ".$q_order."".$q_limit); 

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		echo '<ul>';
		foreach ($toolpage_data as $data) {		
		echo '<li>';
		echo '<a href="'.get_home_url().'/toolpage/'.$data->url.'" class="btn btn-mini"><strong>'.$data->titolo.'</strong></a>';
		echo '</li>';
		}
		echo '</ul>';
		
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['limit'] = strip_tags( $new_instance['limit'] );
		$instance['order'] = strip_tags( $new_instance['order'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'My ToolPage', 'toolpage' );
		}
		
		if ( isset( $instance[ 'limit' ] ) ) {
			$limit = $instance[ 'limit' ];
		}
		else {
			$limit = '0';
		}
		
		if ( isset( $instance[ 'order' ] ) ) {
			$order = $instance[ 'order' ];
		}
		else {
			$order = 'id DESC';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        
		<p>
		<label for="<?php echo $this->get_field_id( 'order' ); ?>"><?php _e( 'Sort List:' ); ?></label> 
        <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
        	<option value="id_asc"<?php if(esc_attr( $order ) == 'id_asc') echo ' selected="selected"'; ?>><?php _e('ID 1-10', 'toolpage'); ?></option>
        	<option value="id_desc"<?php if(esc_attr( $order ) == 'id_desc') echo ' selected="selected"'; ?>><?php _e('ID 10-1', 'toolpage'); ?></option>
        	<option value="titolo_asc"<?php if(esc_attr( $order ) == 'titolo_asc') echo ' selected="selected"'; ?>><?php _e('Title A-Z', 'toolpage'); ?></option>
        	<option value="titolo_desc"<?php if(esc_attr( $order ) == 'titolo_desc') echo ' selected="selected"'; ?>><?php _e('Title Z-A', 'toolpage'); ?></option>
        	<option value="rand"<?php if(esc_attr( $order ) == 'rand') echo ' selected="selected"'; ?>><?php _e('Random', 'toolpage'); ?></option>
        </select>
		</p>
        
		<p>
		<label for="<?php echo $this->get_field_id( 'limit' ); ?>"><?php _e( 'Total ToolPage to show:' ); ?><br /><small><?php _e('(0 = all)', 'toolpage)'); ?></small></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="text" value="<?php echo esc_attr( $limit ); ?>" />
		</p>
		<?php 
	}

} // class ToolPage_Widget
?>