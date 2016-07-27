<?php
class C_Series{
	public $show;
	public $xaxis;
	public $yaxis;
	public $renderer;
	public $rendererOptions;
	public $label;
	public $showLabel;
	public $color;
	public $lineWidth;
	public $lineJoin;
	public $lineCap;
	public $shadow;
	public $shadowAngle;
	public $shadowOffset;
	public $shadowDepth;
	public $shadowAlpha;
	public $breakOnNull;
	public $markerRenderer;
	public $markerOptions;
	public $showLine;
	public $showMarker;
	public $index;
	public $fill;
	public $fillColor;
	public $fillAlpha;
	public $fillAndStroke;
	public $disableStack;
	public $neighborThreshold;
	public $fillToZero;
	public $fillToValue;
	public $fillAxis;
	public $useNegativeColors;
	
	public function __construct(){
	}

        public function show_series(){
            $this->show = true;
        }

        public function hide_series(){
            $this->show = false;
        } 

        public function set_series_xaxis($xaxis = 'xaxis'){
            $this->xaxis = $xaxis;
        }

        public function get_series_xaxis(){
            return $this->xaxis;
        }

        public function set_series_yaxis($yaxis = 'yaxis'){
            $this->yaxis = $yaxis;
        }

        public function get_series_yaxis(){
            return $this->yaxis;
        }

        public function set_series_renderer($renderer = '$.jqplot.LineRenderer'){
            $this->renderer = $renderer;
        }

        public function get_series_renderer(){
            return $this->renderer;
        }

        public function set_series_renderer_options($options = array()){
            $this->rendererOptions = $options;
        }

        public function get_series_renderer_options(){
            return $this->rendererOptions;
        }

        public function set_series_label($label=''){
            $this->label = $label;
        }

        public function get_series_label(){
            return $this->label;
        }

        public function series_label_active(){
            $this->showLabel = true;
        }

        public function series_label_deactive(){
            $this->showLabel = false;
        }

        public function set_series_color($color = ''){
            $this->color = $color;
        }

        public function get_series_color(){
            return $this->color;
        }

        public function set_series_line_width($width = ''){
            $this->lineWidth = $width;
        }

        public function get_series_line_width(){
            return $this->lineWidth;
        }

        public function set_series_line_join($line_join = 'round'){
            $this->lineJoin = $line_join;
        }

        public function get_series_line_join(){
            return $this->lineJoin;
        }

        public function set_series_linecap($linecap=''){
            $this->lineCap = $linecap;
        }

        public function get_series_linecap(){
            return $this->lineCap;
        }

        public function set_series_shadow($shadow){
            $this->shadow = $shadow;
        }

        public function get_series_shadow(){
            return $this->shadow;
        }

        public function set_series_shadow_angle($shadow_angle = '45'){
            $this->shadowAngle = $shadow_angle;
        }

        public function get_series_shadow_angle(){
            return $this->shadowAngle;
        }

        public function set_series_shadow_offset($shadow_offset = '1.25'){
            $this->shadowAngle = $shadow_offset;
        }

        public function get_series_shadow_offset(){
            return $this->shadowAngle;
        }

        public function set_series_shadow_depth($shadow_depth = '3'){
            $this->shadowDepth = $shadow_depth;
        }

        public function get_series_shadow_depth(){
            return $this->shadowDepth;
        }

        public function set_series_shadow_alpha($shadow_alpha = '0.1'){
            $this->shadowAlpha = $shadow_alpha;
        }

        public function get_series_shadow_alpha(){
            return $this->shadowAlpha;
        }

        public function series_break_on_null_active(){
            $this->breakOnNull = true;
        }

        public function series_break_on_null_deactive(){
            $this->breakOnNull = false;
        }
        
        public function set_series_marker_renderer($renderer_class = '$.jqplot.MarkerRenderer'){
            $this->markerRenderer = $renderer_class;
        }

        public function get_series_marker_renderer(){
            return $this->markerRenderer;
        }


        public function set_series_marker_renderer_options($renderer_options = array()){
            $this->markerOptions = $renderer_options;
        }

        public function get_series_marker_renderer_options(){
            return $this->markerOptions;
        }

        public function series_show_line_active(){
            $this->showLine = true;
        }

        public function series_show_line_deactive(){
            $this->showLine = false;
        }

        public function series_show_marker_active(){
            $this->showMarker = true;
        }

        public function series_show_marker_deactive(){
            $this->showMarker = false;
        }

        public function set_series_index($index = array()){
            $this->index = $index;
        }

        public function get_series_index(){
            return $this->index;
        }

        public function series_fill_active(){
            $this->fill = true;
        }

        public function series_fill_deactive(){
            return $this->fill;
        }

        public function set_series_fill_color($fill_color=''){
            $this->fillColor = $fill_color;
        }

        public function get_series_fill_color(){
            return $this->fillColor;
        }

        public function set_series_fill_alpha($fill_alpha = ''){
            $this->fillAlpha = $fill_alpha;
        }

        public function get_series_fill_alpha(){
            return $this->fillAlpha;
        }

        public function series_fill_and_stroke_active(){
            if($this->fill) $this->fillAndStroke = true;
            else $this->fillAndStroke = true;
        }

        public function series_fill_and_stroke_deactive(){
            if(!$this->fill) $this->fillAndStroke = false;
            else $this->fillAndStroke = false;
        }

        public function series_disable_stack(){
            $this->disableStack = false;
        }

        public function series_enable_stack(){
            $this->disableStack = true;
        }

        public function set_series_neighbour_threshold($max_neighbour_distance = '4'){
            $this->neighborThreshold = $max_neighbour_distance;
        }

        public function get_series_neighbour_threshold(){
            return $this->neighborThreshold;
        }

        public function series_fill_to_zero_active(){
            $this->fillToZero = true;
        }

        public function series_fill_to_zero_deactive(){
            $this->fillToZero = false;
        }

        public function set_series_fill_to_value($fill_val=0){
            $this->fillToValue = $fill_val;
        }

        public function get_series_fill_to_value(){
            return $this->fillToValue;
        }

        public function set_series_fill_axis($axis_name = ''){
            $this->fillAxis = $axis_name;
        }

        public function get_series_fill_axis(){
            return $this->fillAxis;
        }

        public function series_use_negative_colors_active(){
            $this->useNegativeColors = true;
        }

        public function series_use_negative_colors_deactive(){
            $this->useNegativeColors = false;
        }






}
?>