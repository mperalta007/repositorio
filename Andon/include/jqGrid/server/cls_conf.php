<?php

include_once($_SERVER["DOCUMENT_ROOT"].'/include/include.inc.php');
	
	
	/*******************************/
	class C_Config {
		private $scriptpath = '';
		protected $debug;
		private $default_js = array();
		private $default_css = array();
		private $load_initial_js = array();
		private $load_initial_css = array();
		private $load_jquery_plugins = array();
		
		public function __construct() {
		}
		
		public function set_jqplot_config(){
			$this->scriptpath = SCRIPTPATH;
			$this->debug = (defined('DEBUG'))?DEBUG:false;
			$this->default_js = array('jquery.jqplot');
			$this->default_css = array('jquery.jqplot');
			
			/*
			$this->load_jquery_plugins = array('barRenderer','BezierCurveRenderer','blockRenderer','bubbleRenderer','canvasAxisLabelRenderer','canvasAxisTickRenderer',
				'canvasOverlay','canvasTextRenderer','categoryAxisRenderer','ciParser','cursor','dateAxisRenderer','donutRenderer','dragable','enhancedLegendRenderer',
				'funnelRenderer','highlighter','json2','logAxisRenderer','mekkoAxisRenderer','mekkoRenderer','meterGaugeRenderer','ohlcRenderer','pieRenderer','pointLabels','trendline');
			*/
			//foreach($this->default_js as $k =>$js_fname){
				//echo '<script language="javascript" type="text/javascript" src="../js/src/jquery.min.js"></script>';
				//echo '<link rel="stylesheet" type="text/css" href="../js/src/jquery.jqplot.css" />';
				//echo '<script language="javascript" type="text/javascript" src="../js/src/jquery.jqplot.js"></script>';
			//}

			//Not implemented yet
			$this->load_initial_js = array_merge($this->default_js, explode(',', ADDITIONAL_JS_FILES));
			//Not implemented yet
			$this->load_initial_css = array_merge($this->default_css, explode(',',ADDITIONAL_CSS_FILES));                        
		}

		
		public function get_jqplot_plugin_list(){
			return $this->load_jquery_plugins;
		}
		
		public function get_scriptpath(){
			return $this->scriptpath;
		}
		
		public function get_default_js_to_load(){
			return $this->default_js;
		}
		
		public function get_default_css_to_load(){
			return$this->default_css;
		}


	}
	
?>
