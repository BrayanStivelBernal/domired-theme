

class hstngr_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		// widget ID
		'hstngr_widget',
		// widget name
		'Mensaje usuarios',
		// widget description
		array( 'description' => 'Ser Widget Mensaje Relaciones' )
		);
	}
	
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $args['before_widget'];
		//if title is present
		if ( ! empty( $title ) )
		echo $args['before_title'] . $title . $args['after_title'];
		//output
		echo '
		<form method="">  
			<div class="form-group">
			
				<input class="form-control" placeholder="Producto">
				<br>
				<input class="form-control" placeholder="Donación">
			
			</div>
			
		</form>';
		echo $args['after_widget'];
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ){
			$title = $instance[ 'title' ];
		}else{
		$title = 'Default Title';
		}
	}
}