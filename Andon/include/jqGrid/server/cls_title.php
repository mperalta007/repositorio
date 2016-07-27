<?php
class C_Title{
	public $text;		
	public $show;		
	public $fontFamily;	
	public $fontSize;	
	public $textAlign;	
	public $textColor;	
	public $renderer;
		public $rendererOptions;


		public function __construct(){
			$this->show = 1;
	}


	public function set_title_text($txt){
			$this->text = $txt;
			return $this;
	}

		public function get_title_text(){
			return $this->text;
		}

		public function show_title(){
			$this->show = true;
		}

		public function hide_title(){
			$this->show = false;
		}

		public function set_title_font_family($font_name){
			$this->fontFamily = $font_name;
		}

		public function get_title_font_family(){
			return $this->fontFamily;
		}
		
		public function set_title_font_size($font_size){
			$this->fontSize = $font_size;
		}

		public function get_title_font_size(){
			return $this->fontSize;
		}

		public function set_title_text_align($txt_alignment){
			$this->textAlign = $txt_alignment;
		}

		public function get_title_text_align(){
			return $this->textAlign;
		}

		public function set_title_text_color($text_color){
			$this->textColor = $text_color;
		}

		public function get_title_text_color(){
			return $this->textColor;
		}

		public function set_title_renderer_class($renderer_class){
			$this->renderer = $renderer_class;
		}

		public function get_title_renderer_class(){
			return $this->renderer;
		}

		public function set_title_renderer_options($renderer_options = array()){
			$this->rendererOptions =  $renderer_options;
		}

		public function get_title_renderer_options(){
			return $this->rendererOptions;
		}


}
?>