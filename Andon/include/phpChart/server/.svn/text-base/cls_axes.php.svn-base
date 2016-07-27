<?php
class C_Axes{
	public $show;
	public $tickRenderer;
	public $tickOptions;
	public $labelRenderer;
	public $labelOptions;
	public $label;
	public $showLabel;
	public $min;
	public $max;
	public $autoscale;
	public $pad;
	public $padMax;
	public $padMin;
	public $ticks;
	public $numberTicks;
	public $tickInterval;
	public $renderer;
	public $rendererOptions;
	public $showTicks;
	public $showTickMarks;
	public $showMinorTicks;
	public $useSeriesColor;
	public $borderWidth;
	public $borderColor;
	public $syncTicks;
	public $tickSpacing;
		public $properties;


	public function __construct($properties=''){
			$this->properties = $properties;

	}


		public function show_axis(){
			return $this->show = true;
		}

		public function hide_axis(){
			return $this->show = false;
		}
		

		public function set_axis_tick_renderer_class($class_name=''){
			//echo $class_name;
			 $this->tickRenderer = $class_name;
		}

		public function get_axis_tick_renderer_class(){
			return $this->tickRenderer;
		}

		public function set_axis_tick_renderer_options($options = array()){
			$this->tickOptions = $options;
		}

		public function get_axis_tick_renderer_options(){
			return $this->tickOptions;
		}

		public function set_axis_label_renderer_class($class_name=''){
			$this->labelRenderer = $class_name;
		}

		public function get_axis_label_renderer_class(){
			return $this->labelRenderer;
		}

		public function set_axis_label_options($options = array()){
			$this->labelOptions = $options;
		}

		public function get_axis_label_options(){
			return $this->labelOptions;
		}

		public function set_axis_label($label=''){
			return $this->label = $label;
		}

		public function get_axis_label(){
			return $this->label;
		}

		public function show_axis_label(){
			return $this->showLabel = true;
		}
		
		public function hide_axis_label(){
			return $this->showLabel = false;
		}

		public function set_axis_min_value($min_val){
			$this->min = $min_val;
			$this->axis_autoscale_active(true);

		}

		public function get_axis_min_value(){
			return $this->min;
		}

		public function set_axis_max_value($max_val){
			$this->max = $max_val;
			$this->axis_autoscale_active(true);
		}

		public function get_axis_max_value(){
			return $this->max;
		}

		public function axis_autoscale_active($val){
			return $this->autoscale = $val;
		}


		public function set_axis_padding($pad_val= 1.0){
			$this->pad = $pad_val;
		}

		public function get_axis_padding(){
			return $this->pad;
		}

		public function set_axis_padding_max($pad_max = 1.0){
			if($this->autoscale) {
				$this->padMax = 1.0;
				return;
			}
			$this->padMax = $pad_max;

		}

		public function get_axis_padding_max(){
			return $this->padMax;
		}

		public function set_axis_padding_min($pad_min = 1.0){
			if($this->autoscale){
				$this->padMin = 1.0;
			}
			$this->padMin = $pad_min;
		}

		public function get_axis_padding_min(){
			return $this->padMin;
		}

		public function set_axis_ticks($tickFormat = array()){
			$this->ticks = $tickFormat;
		}

		public function get_axis_ticks(){
			return $this->ticks;
		}

		public function set_axis_tick_number($t_num){
			$this->numberTicks = $t_num;
		}

		public function get_axis_tick_number(){
			return $this->numberTicks;
		}

		public function set_axis_tick_interval($t_interval){
			$this->tickInterval = $t_interval;
		}

		public function get_axis_tick_interval(){
			return $this->tickInterval;
		}


		public function set_axis_renderer_class($renderer_class){
			$this->renderer = $renderer_class;
		}

		public function get_axis_renderer_class(){
			return $this->renderer;
		}

		public function set_axis_renderer_options($renderer_options = array()){
			$this->rendererOptions = $renderer_options;
		}

		public function get_axis_renderer_options(){
			return $this->rendererOptions;
		}

		public function axis_ticks_acitve(){
			$this->showTicks = true;
		}

		public function axis_ticks_deactive(){
			$this->showTicks = false;
		}

		public function axis_tick_marks_active(){
			$this->showTickMarks = true;
		}

		public function axis_tick_marks_deactive(){
			$this->showTickMarks = false;
		}

		public function axis_tick_monitor_active(){
			$this->showMinorTicks = true;
		}

		public function axis_tick_monitor_deactive(){
			$this->showMinorTicks = false;
		}

		public function axis_use_series_color(){
			$this->useSeriesColor = true;
		}

		public function axis_stop_series_color(){
			$this->useSeriesColor = false;
		}

		public function set_axis_border_width($b_width){
			$this->borderWidth = $b_width;
		}

		public function get_axis_border_width(){
			return $this->borderWidth;
		}


		public function set_axis_border_color($b_color){
			$this->borderColor = $b_color;
		}

		public function get_axis_border_color(){
			return $this->borderColor;
		}

		
		public function sync_tick_active(){
			$this->syncTicks = true;
		}

		public function sync_tick_deactive(){
			$this->syncTicks = false;
		}

		public function set_axis_tick_spacing($tick_spacing){
			if($this->autoscale) $this->tickSpacing = $tick_spacing;
			else $this->tickSpacing = 75;
		}

		public function get_axis_tick_spacing(){
			return $this->tickSpacing;
		}


		

		
}
?>