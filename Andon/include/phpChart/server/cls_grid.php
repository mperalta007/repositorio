<?php
class C_Grid{
	public $drawGridlines;
	public $gridLineColor;
	public $gridLineWidth;
	public $background;
	public $borderColor;
	public $borderWidth;
	public $drawBorder;
	public $shadow;
	public $shadowAngle;
	public $shadowOffset;
	public $shadowWidth;
	public $shadowDepth;
	public $shadowColor;
	public $shadowAlpha;
	public $renderer;
	public $rendererOptions;

	public function __construct(){
            //$this->drawGridlines = false;
            //$this->drawBorder = false;
	}

        public function grid_lines_active(){
            $this->drawGridlines = true;
        }

        public function grid_lines_deactive(){
            $this->drawGridlines = false;
        }

        public function set_grid_line_color($color=''){
            $this->gridLineColor = $color;
        }

        public function get_grid_line_color(){
            return $this->gridLineColor;
        }

        public function set_grid_line_width($width=''){
            $this->gridLineWidth = $width;
        }

        public function get_grid_line_width(){
            return $this->gridLineWidth;
        }

        public function set_grid_background_color($bg_color=''){
            $this->background = $bg_color;
        }

        public function get_grid_background_color(){
            return $this->background;
        }

        public function set_grid_border_color($border_color=''){
            $this->borderColor = $border_color;
        }

        public function get_grid_border_color(){
            return $this->borderColor;
        }

        public function set_grid_border_width($border_width = ''){
            $this->borderWidth = $border_width;
        }

        public function get_grid_border_width(){
            return $this->borderWidth;
        }

        public function draw_grid_border_active(){
            $this->drawBorder = true;
        }

        public function draw_grid_border_deactive(){
            $this->drawBorder = false;
        }

        public function grid_shadow_active($val){
            $this->shadow = $val;
        }


        public function set_grid_shadow_alpha($val){
            $this->shadowAlpha = $val;
        }

        public function get_grid_shadow_alpha(){
            return $this->shadowAlpha;
        }

        public function set_grid_shadow_angle($angle){
            $this->shadowAngle = $angle;
        }
        public function get_grid_shadow_angle(){
            return $this->shadowAngle;
        }
        
        public function set_grid_shadow_offset($offset){
            $this->shadowOffset = $offset;
        }
        public function get_grid_shadow_offset(){
            return $this->shadowOffset;
        }

        public function set_grid_shadow_width($width){
            $this->shadowWidth = $width;
        }
        public function get_grid_shadow_width(){
            return $this->shadowWidth;
        }

        public function set_grid_shadow_depth($depth){
            $this->shadowDepth = $depth;
        }
        public function get_grid_shadow_depth(){
            return $this->shadowDepth;
        }

        public function set_grid_shadow_color($color){
            $this->shadowColor = $color;
        }
        public function get_grid_shadow_color(){
            return $this->shadowColor;
        }


        public function set_grid_renderer($renderer = '###$.jqplot.CanvasGridRenderer###'){
            $this->renderer = $renderer;
        }

        public function get_grid_renderer(){
            return $this->renderer;
        }

        public function set_grid_renderer_option($option='###$.jqplot.CanvasGridRenderer###'){
            $this->rendererOptions = $option;
        }

        public function get_grid_renderer_option(){
            return $this->rendererOptions;
        }

    }
?>