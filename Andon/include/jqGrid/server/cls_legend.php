<?php
class C_Legend{
	public $show;
	public $location;
	public $labels;
	public $showLabels;
	public $showSwatch;
	public $placement;
	public $xoffset;
	public $yoffset;
	public $border;
	public $background;
	public $textColor;
	public $fontFamily;
	public $fontSize;
	public $rowSpacing;
	public $rendererOptions;
	public $predraw;
	public $marginTop;
        public $renderer;
	public $marginRight;
	public $marginBottom;
	public $marginLeft;

	public function __contruct(){
	}

        public function set_legend_renderer($renderer = ''){
            $this->renderer = $renderer;
        }

        public function get_legend_renderer(){
            return $this->renderer;
        }

        public function show_legend($val){
            $this->show = $val;
        }

        public function set_legend_location($location = ''){
            $this->location = $location;
        }

        public function get_legend_location(){
            return $this->location;
        }

        public function set_legend_labels($labels = array()){
            if($this->showLabels)$this->labels = $labels;
            else $this->labels = false;
        }

        public function get_legend_labels(){
            if($this->showLabels)return $this->labels;
            else return NULL;
        }


        public function show_legend_labels(){
            $this->showLabels = true;
        }

        public function hide_legend_labels(){
            $this->showLabels = false;
        }

        public function show_legend_swatches(){
            $this->showSwatch = true;
        }

        public function hide_legend_swathes(){
            $this->showSwatch = false;
        }


        public function set_legend_placement($placement = ''){
            $this->placement = $placement;
        }


        public function get_legend_placement(){
            return $this->placement;
        }


        public function set_legend_xoffset($offset){
            $this->xoffset = $offset;
        }


        public function get_legend_xoffset(){
            return $this->xoffset;
        }


        public function set_legend_yoffset($offset){
            $this->yoffset = $offset;
        }


        public function get_legend_yoffset(){
            return $this->yoffset;
        }


        public function set_legend_border($border = ''){
            $this->border = $border;
        }


        public function get_legend_border(){
            return $this->border;
        }


        public function set_legend_background($bg=''){
            $this->background = $bg;
        }

        public function get_legend_background(){
            return $this->background;
        }

        public function set_legend_text_color($text_color = ''){
            $this->textColor = $text_color;
        }

        public function set_legend_font_family($font_family = ''){
            $this->fontFamily = $font_family;
        }

        public function get_legend_font_family(){
            return $this->fontFamily;
        }

        public function set_legend_font_size($font_size = ''){
            $this->fontSize = $font_size;
        }

        public function get_legend_font_size(){
            return $this->fontSize;
        }


        public function set_legend_row_spacing($row_spacing = '0.5em'){
            $this->rowSpacing = $row_spacing;
        }

        public function get_legend_row_spacing(){
            return $this->rowSpacing;
        }

        public function set_legend_renderer_options($options = array()){
            $this->rendererOptions = $options;
        }

        public function get_legend_renderer_options(){
            return $this->rendererOptions;
        }

        public function legend_predraw_active(){
            $this->predraw = true;
        }

        public function legend_predraw_deactive(){
            $this->predraw = false;
        }

        public function set_legend_margin_top($css = ''){
            $this->marginTop = $css;
        }

        public function get_legend_margin_top(){
            return $this->marginTop;
        }

        public function set_legend_margin_bottom($css = ''){
            $this->marginBottom = $css;
        }

        public function get_legend_margin_bottom(){
            return $this->marginBottom;
        }

        public function set_legend_margin_left($css = ''){
            $this->marginLeft = $css;
        }

        public function get_legend_margin_left(){
            return $this->marginLeft;
        }

        public function set_legend_margin_right($css = ''){
            $this->marginRight = $css;
        }

        public function get_legend_margin_right(){
            return $this->marginRight;
        }


}
?>
