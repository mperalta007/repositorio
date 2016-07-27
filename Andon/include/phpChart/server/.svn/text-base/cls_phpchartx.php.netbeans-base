<?php
/**
 * Class name: C_PhpChartX
 * The wrapper class for jqplot
 */


//Loading basic class files that are required in most of the cases
require_once($_SERVER['DOCUMENT_ROOT'].'/'. _ABS_PATH_pC .'/phpChart.php');  

/*
   phpChart class definition */
class C_PhpChartX extends C_Config{
	
	private $target;						//this is the target DIV in the HTML, a DIV in HTML will automatically be created. 
											//Therefore no DIV in HTML should be created automatically
	private $plot_properties_jsvarname;		// unique js varialbe name to avoid name collison
	private $data;							//The set of data that plots the graph, associative array
	private $axesDefaults;					//axes default values, associative array
	private $seriesDefaults;				//series default values, associative array
	private $seriesColors;					//set of colors for seiries that are defined, single dimension array
	private $sortData;						//boolean value to determine whether to sort the provided data or not
	private $fontSize;						//default font size
	private $stackSeries;					//boolean value to determine whether to stack the series or not
	private $defaultAxisStart;  	
	private $axis;
	private $legend;
	private $title;
	private $series;
	private $grid;
	private $options;
	private $plot_properties = array();     //all properties will be summerized and assigned as a json value to this variable, this will appear as
											//JS value in the HTML document										
	private $jqplot_plugins  = array();     //set of jqplot plugins to be loaded dynamically
	private $scriptpath;                    //the web path for jqplot javascript path
	private $customJS=array();              //the wrapper will convert the value into javascript, that is supplied here 
	private $extra_data;                    //sometimes some extra data are required, that can be assigned here, optional
	private $js_vars;                       //the wrapper will convert php array variables into javascript variables with assigned JSON data, 
											//these will appear in the HTML document
	private $config;                        //the default config for jqplot wrapper class, for example setting up script path, loading default plugins             
	private $data_as_json;                  //data will be converted as JSON, for wrapper uses
	private $customJSAddOrder=array();      //For Wrapper uses, this defines the order of placing javascript codes that are supplied
	private $jsCustom = '';
	private $jsCustomAfter = '';
	private $jsCustomOutsideJQuery = '';
	private $script_includeonce;			//jqplot js include file
	private $script_body;					// jqgrid everything else

	public $__imported;                     //not in use right now
	public $__imported_functions;           //not in use right now
	public $render_type;                    //there are few different renderer types in jqplot
	public $js_theme;                       //jqplot can be used with javascript themes
	
	public static $js_css = array();        //to add javascript and css files dynamically, static value to make sure to prevent
											//duplicate loading

	/**
	* jqplot properties
	*  - enablePlugins
	*  - defaultHeight
	*  - defaultWidth
	*/
	public $enablePlugins = 'false';            //boolean value, to determine whether to enable or disable the plugins
	public $defaultHeight = 300;            //default height for jqplot display
	public $defaultWidth  = 400;            //default width for jqplot display


	/* Description
	   This is our phpChart constructor. Use this function to create
	   phpChart object. It normally should be the first line of the
	   code.
	   Parameters
	   data :    Type array. The set of data supplied here to use to
	             plot the graphs, default NULL or an empty array,
	             Possible Data Type\: Array, NULL or JSON Data
	   target :  Type string. Unique name to our phpChart. Default
	             value is '__chart1'.
	   Returns
	   None
	   Example
	   <extlink http://phpchart.net/examples/introduction>phpChart
	   Introduction</extlink>
	   Summary
	   phpChart constructor                                          */
	public function __construct($data = array(), $tgt = '__chart1',$render_type='default', $js_theme='',$js_vars=array()){
				
		$this->script_includeonce	= '';	
		$this->script_body			= '';
		
		$this->__imported = Array();                //Not in Used, at the moment
		$this->__imported_functions = Array();      //Not in Used, at the moment
				
		$this->target = $tgt;                       //sets target value
		$this->plot_properties_jsvarname = "_". $tgt ."_plot_properties";
		$this->js_vars = $js_vars;                  //sets php variables to for making javascript variables

		$this->render_type = $render_type;          //sets renderer type
		$this->js_theme = $js_theme;                //sets javascript theme
				
				
		//While js_theme is set, make sure the data is set into another array
		if($this->js_theme != ''){                          //check js_theme if set
			$this->data = array($data);              //assign supplied jqplot_data inside another array for wrapper use
		}
		else $this->data = $data;                    //If no theme is set, then assing the supplied jqplot_data as is

		//set config
		$this->set_jqplot_config();                         //Calling inherited member function, parent class: C_Config
				
		//setting script path   
		$this->set_scriptpath($this->get_scriptpath());     //Sets script path by getting path value by calling get_scriptpath 
															//inherited member function, parent class for "get_scriptpath" C_Config
											
		$this->data_as_json = false;                        //Sometimes, wrapper class is supplied with JSON data, need to keep track
		//var_dump(json_decode($this->data)); die;
		if(!is_array($this->data)) {                        //Checking supplied data
			$this->data_as_json = (json_decode($this->data) == NULL) ? true : false;    //If it is a JSON Data, then set it as true, otherwise false
			if($this->data_as_json) $this->render_type = 'json_data';                   //If it is a JSON Data, then set the renderer type to 'json_data'
		}
				
		$this->config = NULL;                               //Initiating config var as NULL

		// include the following files before everything else happen.
		$this->addCSSJS('excanvas.min.js','js');
		$this->addCSSJS('jquery.jqplot.min.css','css');
		$this->addCSSJS('jquery.min.js','js');
		$this->addCSSJS('jquery.jqplot.min.js','js');	
		// keep track off what's included so only inlucde them once
		$this->set_js_css('excanvas.min.js');
		$this->set_js_css('jquery.jqplot.min.css');
		$this->set_js_css('jquery.min.js');
		$this->set_js_css('jquery.jqplot.min.js');
	}

	// Description:
	//		Sets to config object to hold configuration information for jqPlot plot object
	// Arguments:
	//      config - Type Array
	// Returns: 
	//		None
	// Example:
	//		<extlink http://phpchart.net/phpChart/examples/catch_error.php>phpChart Catch Error</extlink>	
	//	
	//		<extlink http://phpchart.net/phpChart/examples/dashed_lines.php>Dashed Lines</extlink>		
	// Summary:
	//      Sets config to initiate configuration variable
	public function set_config($config=array()){
		$this->config = $config;                                 //Initiates config variable
	}

	/**
	* gets config value
	* Params: None
	* 
	* Returns: Array, current set of configuration
	*/
	public function get_config(){
		return $this->config;
	}

	/**
	* Enables/Disables plugins
	* Params
	*      @$val: Boolean
	*/
	public function jqplot_show_plugins($val){
		if($val == false) $val = 'false';
		$this->enablePlugins = empty($val) ? 'false' : 'true';
	}

	/**
	* Sets JQplot default heigh
	* Params
	*      @h: integer
	*/
	public function jqplot_default_height($h){
		$this->defaultHeight = $h;
	}
		
		
	/**
	* Sets JQplot default width
	* Params
	*      @w: integer
	*/
	public function jqplot_default_width($w){
		$this->defaultWidth = $w;
	}

	/**
	* Makes an entry into the js_css static member, whenever a new CSS or JS file is loaded dynamically, 
	* during page loading.
	* 
	* Params
	*      @val : String
	* 
	* Returns: None
	*  
	*/
	private function set_js_css($val){
		self::$js_css[] = $val;
	}
		
	/**
	* Retrieves the static member variable
	* Params: None
	* 
	* Returns: 
	*      @js_css: static Array 
	*/
	public function get_js_css(){
		return self::$js_css;
	}

	/**
		*
		* 
	private function assign_axes_options($m, $a){
		echo 'assign option';
		echo '<pre>';
		print_r($a);
		echo '</pre>';
	}
		
	public function Imports($object)
	{
		$new_imports = new $object();
		//var_dump($new_imports);
		$imports_name = get_class($new_imports);
		array_push( $this->__imported, Array($imports_name,$new_imports) );
		$imports_function = get_class_methods($new_imports);
		foreach ($imports_function as $i=>$function_name)
		{
			$this->__imported_functions[$function_name] = &$new_imports;
		}
	}

	public function __call($m, $a)
	{            
		if(array_key_exists($m,$this->__imported_functions))
		{
			//echo $m;
			$this->assign_axes_options($m,$a);
			$retVal =  call_user_func_array(Array($this->__imported_functions[$m],$m),$a);
			return $retVal;
		}
		throw new ErrorException ('Call to Undefined Method/Class Function', 0, E_ERROR);
	}
		*
		*
		*/
 
	/* Returns
	   String, HTML Table inside a DIV
	   Description
	   Sets custom Legend of the graph, the phpChart will
	   automatically create the necessary HTML, currently only the
	   HTML TABLE format is supported. This is an advanced function
	   for handling jqplotDataHighlight and jqplotDataUnhighlight
	   events with user defined custom event handler.
	   
	   
	   
	   <image set_custom_legend>
	   Parameters
	   pos1 :          integer, position top
	   pos2 :          integer, position left
	   legend_table :  table div id
	   Example
	   <extlink http://phpchart.net/phpChart/examples/bubble_chart_2.php>Bubble
	   Chart (Chart 1b Example)</extlink>
	   Summary
	   Sets custom legend of the graph.                                                        */

	public function set_custom_legend($pos1,$pos2,$legend_table=''){
		?>
		<script language="javascript" type="text/javascript">
			$(document).ready(function (){
				//Execute the html creation function after 400 miliseconds,
				//This delay is to make sure that the code does not run before the plugins gets loaded
				setTimeout(put_legend_html, 400);               //The timer function
					
				//This javascript function generates the necessary HTML for custom Legend
				function put_legend_html(){
					var pos1 = '<?php echo $pos1?>';            //assigning position top for the legend
					var pos2 = '<?php echo $pos2?>';            //assigning position left for the legend

					var data = <?php echo json_encode($this->data[0])?>;    //assigning the javascript data variable after json encoding of provided plot data

					var outer_obj = '<?php echo $this->target?>';           //outer target div
					//setting up css
					$('#'+outer_obj).css('clear','right');          
					$('#'+outer_obj).css('float','left');

					var inner_obj = '<?php echo $this->target?>_legend_inner';  //inner html object div
					var legend_table = '';                              //legend table id, initiating
						
					//defining legend table id
					if('<?php echo $legend_table?>' == '') legend_table = '<?php echo $this->target?>_legend_inner_table'; //if table id is not defined that generate it
					else legend_table = '<?php echo $legend_table?>';             //if table id is supplied, then assign it
						
					//formating html
					$('#'+outer_obj).after('<div style="padding-top:33px; padding-left:20px;" id="'+inner_obj+'"><table cellpadding=0 cellmargin=0 id="'+legend_table+'"></table></div>');
					$('#'+inner_obj).css('clear','right');
					$('#'+inner_obj).css('float','left');

					// Now populate it with the labels from each data value.
					$.each(data, function(index, val) {
						$('#'+legend_table).append('<tr><td>'+val[pos1]+'</td><td>'+val[pos2]+'</td></tr>');    //append table columns and making cells
					});
						
					//setting up table css properties by jquery
					$('#'+legend_table).css('border','1px solid gray');
					$('#'+legend_table).css('border-collapse','collapse');
					$('#'+legend_table).css('font-size','12px');
					$('#'+legend_table).css('font-family','"Trebuchet MS",Arial,Helvetica,sans-serif');
					$('#'+legend_table+' td').css('border','1px solid gray');
					$('#'+legend_table+' td').css('padding','2px');
					$('#'+legend_table+' td').css('padding-left','4px');
					$('#'+legend_table+' td').css('padding-right','4px');

				}
			});
		</script>
		<?php
			
		//legend table tooltip setup
		if($legend_table == '')$legend_table_tooltip = $this->target.'_legend_inner_table_tooltip';     //if table id is not supplied
		else $legend_table_tooltip = $legend_table.'_tooltip';                                          //if table id is supplied
			
		//below line prints the HTML in the document
		echo '<div style="clear:both;"></div><div style="position:absolute;z-index:99;display:none;" id="'.$legend_table_tooltip.'"></div>';
	}
		
	/**
	* Sets grid padding
	* Params
	*      @val: integer, padding value
	* 
	* Returns: None
	*
	*/
	public function set_grid_padding($val){
		$this->options['gridPadding'] = $val;   //sets padding value in gridPadding
	}


		
				/* Description
				   Sets axes default properties. The value automatically applies
				   to both x and y axes. This method is for convenience since
				   both x, and y axes share many the same properties.. X, Y axes
				   can be also set individually using set_xaxes and set_yaxes
				   function.
				   Returns
				   None
				   Remarks
				   The complete reference to Axes properties, can be found at <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis>http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis</extlink>
				   Parameters
				   axis_default :  Type array\: a set of Array
				   Summary
				   Sets axis default properties
				   Example
							   <extlink http://phpchart.net/phpChart/examples/linepiebar.php>Line
				   Pie Bar Chart</extlink>
				   
							   <extlink http://phpchart.net/phpChart/examples/mekko_chart.php>Mekko
				   Chart</extlink>
				   
							   <extlink http://phpchart.net/phpChart/examples/multi_axes_rotated_text.php>Multiple
				   Axes with Rotated Text</extlink>
				   
				   <extlink http://phpchart.net/phpChart/examples/reploting.php>Reploting</extlink>                                                                                                   */
	public function set_axes_default($def){
		//check the 1st degree of the array dimension to see if there is any renderer defined
		foreach($def as $key=>$item1){
			// if($key == 'renderer' || (is_string($item1) && strstr($item1, '$.') )) $def[$key] = '###'.$item1.'###';         //If any renderer defined, then append and prepend '###' to that property
			if($key == 'renderer' || (is_string($item1) && strstr($item1, '$.') )) $def[$key] = $item1;
		}
		$this->options['axesDefaults'] = $def;                              //Assigns the array into axesDefaults property
	}

	/* Summary
	   Sets no data indicator
	   Description
	   Sets no data indicator "noDataIndicator" option.  If no data is passed in on plot creation, a DIV will be placed roughly in the center of the plot.  Whatever text or html is given in the "indicator" option will be rendered. 
	   	   
	   <image nodataoptions>
	   
	   Parameters
	   indicator :   String: No data indicator. HTML OK.
	   
	   Example
				   <extlink http://phpchart.net/phpChart/examples/no_data_options.php>No Data Options</extlink>
	   
	   Remarks

	   Returns
	   None                                                                                        */
	public function set_no_data_indicator($def){
		//check the 1st degree of the array dimension to see if there is any renderer defined
		foreach($def as $key=>$item1){                          
			// if($key == 'renderer') $def[$key] = '###'.$item1.'###';         //If any renderer defined, then append and prepend '###' to that property
			if($key == 'renderer') $def[$key] = $item1;
		}
		$this->options['noDataIndicator'] = $def;                           //Assigns the array into noDataIndicator property
	}
		
		
	/* 
	Summary
	Sets series default, The default properties for all series
	Description
	Sets series default, The default properties for all series. Online example of this method is available at <extlink http://phpchart.net/examples/set-series-default/>http://phpchart.net/examples/set-series-default/</extlink>
	
	Complete Series reference: <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Series>http://www.jqplot.com/docs/files/jqplot-core-js.html#Series</extlink>
	
	Parameters
	default :   phpChart default series values

	Example
				<extlink http://phpchart.net/phpChart/examples/set_series_default.php>Set Series Default Example</extlink>

				<extlink http://phpchart.net/phpChart/examples/filled_line.php>Filled Line</extlink>

				<extlink http://phpchart.net/phpChart/examples/linepiebar.php>Line Pie Bar</extlink>

	Returns
	None                                                                                        */
	public function set_series_default($def){
		//check the 1st degree of the array dimension to see if there is any renderer defined
		foreach($def as $key=>$item1){
			// if($key == 'renderer') $def[$key] = '###'.$item1.'###';         //If any renderer defined, then append and prepend '###' to that property
			if($key == 'renderer') $def[$key] = $item1;         
		}
		$this->options['seriesDefaults'] = $def;                            //Assigns the array into seriesDefaults property
	}

	/* Summary
	   Sets pointLabels plugin property for putting labels at the
	   data points.
	   Description
	   Sets pointLabels plugin property for putting labels at the
	   data points. Must include PointLabels plugin using
	   add_plugins method. The complete reference is available at <extlink http://www.jqplot.com/docs/files/plugins/jqplot-pointLabels-js.html>http://www.jqplot.com/docs/files/plugins/jqplot-pointLabels-js.html</extlink>
	   
	   
	   
	   <image point_labels>
	   Parameters
	   prop :  Array point label properties
	   Example
				   <extlink http://phpchart.net/phpChart/examples/reploting.php>Reploting
	   Chart</extlink>
	   Returns
	   None                                                                                                                                                                                                                  */
	public function set_point_labels($def){
		//check the 1st degree of the array dimension to see if there is any renderer defined
		foreach($def as $key=>$item1){
			// if($key == 'renderer') $def[$key] = '###'.$item1.'###';         //If any renderer defined, then append and prepend '###' to that property
			if($key == 'renderer') $def[$key] = $item1;         
		}
		$this->options['pointLabels'] = $def;                            //Assigns the array into pointLabels property
	}
		
	/* Summary
	   Sets options for highlighter plugin
	   Description
	   Sets options for highlighter plugin. Must add plugin
	   highlighter first using add_plugins method.
	   
	   For complete list of highlighter plugin options, visit <extlink http://www.jqplot.com/docs/files/plugins/jqplot-highlighter-js.html>http://www.jqplot.com/docs/files/plugins/jqplot-highlighter-js.html</extlink>
	   
	   
	   
	   <image highlighter>
	   Parameters
	   options :  Type Array. highlighter options
	   Example
	   <extlink http://phpchart.net/phpChart/examples/highlighter.php>Highlighter</extlink>
	   
	   <extlink http://phpchart.net/phpChart/examples/series_canvas_reorder.php>Series
	   Canvas Reorder</extlink>
	   Returns
	   None                                                                                                                                                                                                              */
	public function set_highlighter($val){
		$this->options['highlighter'] = $val;                               //sets the highlighter property
	}

	/* Returns
	   None
	   Description
	   Sets animation property (new in 1.0.0b2_r1012)
	   
	   
	   Summary
	   enable animation
	   
	   
	   Parameters
	   has_animate :  boolean\: true or false         */
	public function set_animate($has_animate=false, $has_animate_replot=true){
		$this->options['animate'] = $has_animate; 
		$this->options['animateReplot'] = $has_animate_replot; 	
	}


	/* Returns
	   None
	   Summary
	   Sets cursor property. It requires cursor plugin.
	   Description
	   Sets cursor property. It requires cursor plugin. Use <link C_PhpChartX.add_plugins@, add_plugins>
	   to add cursor first before using this method.
	   
	   Detail of cursor plugin can be found at <extlink http://www.jqplot.com/docs/files/plugins/jqplot-cursor-js.html>http://www.jqplot.com/docs/files/plugins/jqplot-cursor-js.html</extlink>
	   Parameters
	   cursor_property :  Array. Cursor property
	   Example
				   <extlink http://phpchart.net/phpChart/examples/data_tracking.php>Data
	   Tracking</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/basic_chart2.php>Basic
	   Chart 2</extlink>                                                                                                                                                                        */
	public function set_cursor($val){
		$this->options['cursor'] = $val;                                    //Sets cursor property
	}


	/* 
	Summary
	Sets all phpChart properties.

	Description
	Sets all properties to phpChart object. The parameter is a complex array representing the entire phpChart properties. Use get_properties function to get the properties of a phpChart object for reuse.
	   
	Parameters
	properties :   phpChart properties

	Example
				<extlink http://phpchart.net/phpChart/examples/hidden_plot.php>Hidden Plot</extlink>

				<extlink http://phpchart.net/phpChart/examples/dynamicplot.php>DynamicPlot</extlink>

	Returns
	None                                                                                        */
	public function set_properties($props){

		$this->options = $props;                                            //sets the properties
	}

	/* 
	Summary
	Get phpChart properties in an array 

	Description
	Return an array representing the entire properties of a phpChart object. Use this function to retrieve properties of a phpChart object for later reuse.
	
	Returns
	phpChart properties                                                                                        */
	public function get_properties(){
		return $this->options;                                            
	}
		
	/**
	* Not in use 
	*/
	function format_properties($item1,$key){
		echo $key.'<br />';
	}
		
		
	/**
	* Wraps all jqplot properties
	* It takes jqplot properties as an associative array and formats for further use.
	* 
	* Input: $this->options as raw Array data
	* It then just formats the array to make compatible for further use
	* 
	* Returns: boolean
	*/
	private function wrap_jqplot(){
		//echo '<pre>';
		//print_r($props);
		//echo '</pre>';
			 
		$wrap_props = array();                                              //a temporary storage for properties
		/**
		if($props != NULL){
			foreach($props as $key => $val){
				$class_name = strtolower(str_replace('C_', '', get_class($val)));
				if(!isset($val->properties)) {
					$opt = array();
					foreach ($val as $k=>$v){
						if($v == NULL || $v == '' || ($v == 0 && !is_string($v))) continue;
						$opt[$k] = $v;
					}
					$wrap_props[$class_name] = $opt;
				}
				else if(isset($val->properties)){
					$prop_title = $val->properties;
					unset($val->properties);
					$opt = array();
					foreach ($val as $k=>$v){
						if($v == NULL || $v == '' || ($v == 0 && !is_string($v))) continue;
						$opt[$k] = $v;
					}
					$wrap_props[$class_name][$prop_title] = $opt;
				}
			}
		}
		*/

		//check if any default value is already set by the object callers for jqplot defaults
		if(is_array($this->options) && isset ($this->options)) $temp_options = $this->options;          //if found then put that into a temporary storage
		else $temp_options = array();                                                                   //if not found, assign the temp storage with an empty array

		//assign wrapping options
		$this->options = $this->plot_properties;
			
		//merges wrapped options and default options
		$this->options = array_merge($this->options,$temp_options);
		//return $this->options['seriesDefaults'];
		//return $this->options['axesDefaults'];
		//return $this->options['seriesColors'];
		//return $this->options['fontSize'];
		//return $this->options['defaultAxisStart'];
		//
		//$this->options['seriesDefaults'] = array('fill'=>true);

		/**
		echo '<pre>';
		print_r($this->options);
		echo '</pre>';
			* 
			*/

		/**
		echo '<pre>';
		//print_r($this->plot_properties);
		//print_r($axis);
		echo '</pre>';
			* 
			*/

		/**
		echo '<pre>';
		echo json_encode($wrap_props);
		echo '</pre>';
			* 
			*/

		return true;
			
	}


	/* 
	Summary
	Sets xaxes properties
	Description
	Sets xaxes properties. There are 2 x axes, �xaxis� and �x2axis�, and up to 9 yaxes, �yaxis�, �y2axis�.  �y3axis�, etc.  The x y axes online exmample is available at <extlink http://phpchart.net/examples/325/>http://phpchart.net/examples/325/</extlink>
	
	For complete reference, please vist <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis>http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis</extlink>
	   
	<image set_xyaxes>

	Parameters
	xaxes_prop :   Array. xaxes properties

	Example
				<extlink http://phpchart.net/phpChart/examples/area_new.php>Area Graph</extlink>

				<extlink http://phpchart.net/phpChart/examples/set_xyaxes.php>Set X Y Axes Example</extlink>

				<extlink http://phpchart.net/phpChart/examples/waterfall.php>Waterfall Graph</extlink>

	Returns
	None                                                                                        */
	public function set_xaxes($axis_props=array()){
		$this->set_axes($axis_props);       //calls member function set_axes to format the array data and assign the property
	}
		
	/* 
	Summary
	Sets yaxes properties
	Description
	Sets yaxes properties. There are 2 x axes, �xaxis� and �x2axis�, and up to 9 yaxes, �yaxis�, �y2axis�.  �y3axis�, etc.  The x y axes online exmample is available at <extlink http://phpchart.net/examples/325/>http://phpchart.net/examples/325/</extlink>
	
	For complete reference, please vist <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis>http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis</extlink>
	   
	<image set_xyaxes>

	Parameters
	yaxes_prop :   Array. yaxes properties

	Example
				<extlink http://phpchart.net/phpChart/examples/area_new.php>Area Graph</extlink>

				<extlink http://phpchart.net/phpChart/examples/set_xyaxes.php>Set X Y Axes Example</extlink>

				<extlink http://phpchart.net/phpChart/examples/waterfall.php>Waterfall Graph</extlink>

	Returns
	None                                                                                        */
	public function set_yaxes($axis_props=array()){
		$this->set_axes($axis_props);       //calls member function set_axes to format the array data and assign the property
	}
		
		

	/* Description
	   Sets axis properties. It takes both xaxes and/or yaxes
	   properties and formats them, then sets their properties. X, Y
	   axes can be also set individually using set_xaxes and
	   set_yaxes function.
	   Returns
	   None
	   Remarks
	   The complete reference to Axes properties, can be found at <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis>http://www.jqplot.com/docs/files/jqplot-core-js.html#Axis</extlink>
	   Parameters
	   axis_props :  Type array\: a set of Array
	   Summary
	   Sets axis properties
	   Example
				   <extlink http://phpchart.net/phpChart/examples/axis_labels_rotated_text_2.php>Axis
	   Labels with Rotated Text</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/block_plot.php>Block
	   Plot</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/category_horizontal_bar.php>Category
	   Horizontal Bar</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/grid_customization.php>Grid
	   Customization</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/multiple_bar_colors.php>Multiple
	   Colored Bar Chart</extlink>                                                                                                                                                                       */
	public function set_axes($axis_props=array()){
						
		foreach($axis_props as $axis_type => $ap){
			$axis = new C_Axes($axis_type);                                 //creates an Axes objext

			//check the 1st degree of the array dimension to see if there is any renderer defined
			foreach($ap as $k => $props){
				$axis->$k = (!is_array($props) && strstr($props,'$')) ? $props:$props;      //If any renderer defined, then append and prepend '###' to that property
			}

			$this->plot_properties['axes'][$axis_type] = $this->filter_array(get_object_vars($axis));   //calls member function filter_array to filter duplicacy, 
			//formats boolean values etc and removes unassigned variables of Axes object

		}
	}

	/* Description
	   Sets canvesOverlay property. It draws lines on top of the
	   current chart. This requires canvasOverlay plugin. To add
	   plugin, use <link C_PhpChartX.add_plugins@, add_plugin(array('canvasOverlay'>)
	   
	   
	   
	   <image canvas_overlay>
	   Returns
	   None
	   Remarks
	   The complete reference to canvasOverlay plugin properties,
	   visit <extlink http://www.jqplot.com/docs/files/plugins/jqplot-canvasOverlay-js.html>http://www.jqplot.com/docs/files/plugins/jqplot-canvasOverlay-js.html</extlink>
	   Parameters
	   properties :  Type array, a set of overlay properties
	   Summary
	   Sets canvesOverlay property. Requires canvasOverlay plugin.
	   Example
				   <extlink http://phpchart.net/phpChart/examples/canvas_overlay.php>Canvas
	   Overlay Example</extlink>                                                                                                                                            */
	public function set_canvas_overlay($def){
		//check the 1st degree of the array dimension to see if there is any renderer defined
		foreach($def as $key=>$item1){
			// if($key == 'renderer') $def[$key] = '###'.$item1.'###';         //If any renderer defined, then append and prepend '###' to that property
		}
		$this->options['canvasOverlay'] = $def;                             //Sets canvasOverlay property
	}
		
	/* Returns
	   None
	   Description
	   Sets dataRenderer property. Data renderers allow jqPlot to
	   pull data from any external data source such as a function
	   implementing an AJAX call. Simply assign the external source
	   to the "dataRenderer" plot option. The only requirement on
	   data renderers is that it must return a valid jqPlot data
	   array.
	   
	   
	   
	   The Sine Data Renderer returns data from a sine function.
	   
	   
	   
	   <image data_renderer>
	   
	   
	   
	   The following example returns the data from the ci_parser
	   plugin.
	   
	   
	   
	   <image ci_parser>
	   Summary
	   Sets dataRenderer property to pull data from external data
	   source.
	   Parameters
	   renderer :  plugin or user function that returns plotting data
	   
	   Example
				   <extlink http://phpchart.net/phpChart/examples/data_renderer.php>Data
	   Renderer</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/ci_parser.php>Ci
	   Parser</extlink>                                                                     */
	public function set_data_renderer($renderer){
		// $this->options['dataRenderer'] = '###'.$renderer.'###';             //Sets dataRenderer property
		$this->options['dataRenderer'] = $renderer;             //Sets dataRenderer property
	}

	
	
	/* Returns
	   None
	   Description
	   Sets dataRenderer Option property. This function must used with set_data_renderer function. 
	   Summary
	   Sets dataRenderer Option property.
	   Parameters
	   options :  data renderer options.
	   
	   Example
				   <extlink http://phpchart.net/phpChart/examples/data_renderer.php>Data
	   Renderer</extlink>
	*/	
	public function set_data_rendererOptions($options){
		$this->options['dataRendererOptions'] = $options;             //Sets dataRenderer property
	}
			
	/**
	* Sets seriesColors Properties
	* 
	* Params:
	*      @val: Array, a linear array
	* 
	* Returns: None
	*      
	*/
	public function set_series_color($val){
		$this->options['seriesColors'] = $val;                              //Sets seriesColors property
	}

	/* Summary
	   add data series used for charting
	   Parameters
	   series_prop :  Array, a set of array defining data series
	   Example
				   <extlink http://phpchart.net/phpChart/examples/banded_line.php>Banded
	   Line</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/axis_labels_rotated_text.php>Axis
	   Labels Rotated Text</extlink>
	   
	   <extlink http://phpchart.net/phpChart/examples/block_plot.php>Block
	   Plot</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/candle_stick_canvas_overlay.php>Candle
	   Stick Canvas Overlay</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/multiple_y_axes.php>Multiple
	   Y Axes</extlink>
	   Remarks
	   For complete reference to series properties, please visit <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Series>http://www.jqplot.com/docs/files/jqplot-core-js.html#Series</extlink>
	   Returns
	   None
	   Description
	   Use this method to add values to series properties, in
	   addition to the plotting data. This adds additional
	   information in the chart such as labels to display additional
	   data.
	   
	   
	   
	   <image block_data>                                                                                                                                                                                   */
				

	public function add_series($props = array()){
		$this->process_params($props,'C_Series','series',true);             //calls member function process_params to make compatible format to use with wrapper
	}

	/**
	* Sets sortData property
	* 
	* Params:
	*      @val: array
	* 
	* Returns: None
	*/
	
	public function sort_data($val){
		$this->options['sortData'] = $val;                                  //sets sortData property
	}

	/* 
	Summary
	Sets title Object
	
	Description
	Sets title Object. The complete title object properties can be found <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Title>http://www.jqplot.com/docs/files/jqplot-core-js.html#Title</extlink>

	Parameters
	title :   Array. phpChart title object.

	Example
				<extlink http://phpchart.net/phpChart/examples/add_title.php>Add Title Example</extlink>

	Remarks
	The parameter is an array, not a string
	
	Returns
	None                                                                                        */
	public function set_title($props = array()){
		$this->process_params($props,'C_Title','title');                    //Calls member function: process_params to create and set Title object
	}

	/* Summary
	   Sets Legend object properties.
	   Description
	   Sets Legend object properties. A legend contains a list of
	   the variables appearing in the chart and an example of their
	   appearance. 
	   
	   For complete legend object, please visit <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Legend>http://www.jqplot.com/docs/files/jqplot-core-js.html#Legend</extlink>
	   
	   <image legend>
	   Parameters
	   legend_properties :  Legend properties
	   Example
				   <extlink http://phpchart.net/phpChart/examples/legend_labels.php>Legend
	   Labels</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/legend_labels_2.php>Legend
	   Labels 2</extlink>
	   Returns
	   None                                                                                                                                                                                            */
	public function set_legend($props = array()){
		$this->process_params($props,'C_Legend','legend');                  //Calls member function: process_params to create and set Legend Object
	}

	/* Description
	   Sets values to the grid object. It represents the grid on which the plot is drawn such as grid line and background.  It is the area bounded by the axes, the area which will contain the series.  Note, the series are drawn on their own canvas.  
	   Returns
	   None
	   Remarks
	   The complete reference to grid properties, can be found at <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#Grid>http://www.jqplot.com/docs/files/jqplot-core-js.html#Grid</extlink>
	   Parameters
	   grid_properties :  Type array\: a set of Array
	   Summary
	   Sets values to the grid object.	
	   Example
				   <extlink http://phpchart.net/phpChart/examples/set_grid.php>Set Grid Example</extlink>
	*/
	public function set_grid($props = array()){
		$this->process_params($props,'C_Grid','grid');                      //Calls member function: process_params to create and set Grid Object
	}


	/**
	* Processes properties array passed to it
	* It creates Classes objects and assigns values to the objects automatically
	* 
	* Params:
	*      @props: Array, Set of the properties (Required)
	*      @class_name: String, The name of the class which object needs to be created (Required)
	*      @prop_name: String, The literal name for the class, will be used as a key for the associative array
	*                  An associative array will be used for wrapper class's own use
	* 
	*      @double_array: Boolean, to determine whether the associative array will be double dimensional or single
	*                     One use of double dimensional associative array is for Series Class, it needs to be the array as double dimensional
	*                     Optional parameter, default is set to false.
	* 
	* Returns: None
	* 
	*/
	private function process_params($props = array(), $class_name='', $prop_name='',$double_array=false){
		/**
		echo '<pre>';
		print_r($props);
		echo '</pre>';
			* 
			*/
		$obj = new $class_name();                                           //Creates the object of the class based on provided parameters

		foreach($props as $key => $ap){                                     //Checks for any renderer in the 1st degree of the array list
			//if($key == 'show')var_dump($ap);
//					$obj->$key = (!is_array($ap) && strstr($ap,'$.')) ? '###'.$ap.'###': 
//						((is_bool($ap) && $ap == false) ? '0:false': ($ap == true && is_bool($ap) ? '1:true' : $ap));
						$obj->$key = (!is_array($ap) && strstr($ap,'$.')) ? $ap : 
							((is_bool($ap) && $ap == false) ? '0:false': ($ap == true && is_bool($ap) ? '1:true' : $ap));
		}
			
		   
		//Check if the associative array is to be double dimension or not
		if($double_array) $this->plot_properties[$prop_name][] = $this->filter_array(get_object_vars($obj));    //if set true then make it double dimension
		else $this->plot_properties[$prop_name] = $this->filter_array(get_object_vars($obj));                   //if not then let it be single

	}
		
	/**
	* Filters arrays of properties supplied to use for the wrapper, filters those properties that are not set from the Objects created.
	* For example, Grid Object. All properties of this object might not have set from the wrapper object, therefore, we need to remove
	* them, so that JSON data later will not have any junk data or unused data.
	*
	* Params:
	*      @arr: Array, a set of properties, (required)
	* 
	* Returns: Array, filtered
	*/
	private function filter_array($arr){
		$temp = array();                                                                //assigns a temporary array
		foreach($arr as $k=>$v){
			// if($v == NULL || $v == '' || ($v == 0 && !is_string($v))) continue;         //Checks if the property is being used, if not then remove it here
			if($v === NULL || $v === '') continue;         //Checks if the property is being used, if not then remove it here
			$temp[$k] = ($v==='0:false') ? false : (($v === '1:true') ? true: $v);        //Coming in this line does mean that the object property is being used, so keep it
		}

		return $temp;                                                                   //returns the filtered object.
	}
	
		
	/**
	* Description:
	*	Sets the scriptpath
	* 
	* Arguments:	
	*      @path - String, required
	* 
	* Returns: None
	* 
	*/	
	public function set_scriptpath($path){
		$this->scriptpath = $path;                                      //setting up the scriptpath
	}
	
	/**
	* Sets the target div of jqplot Graph
	* 
	* Params:
	*      @tgt: String, required
	* 
	* Return: None
	*  
	*/
	public function set_target($tgt){
		$this->target = $tgt;                       	
		//return $this;
	}
	
		
	/* Summary
	   Sets phpChart default values
	   Description
	   Sets phpChart default values such as title, font size etc.
	   This method is used for convenience. The default properties
	   are:
	   
	   <table>
	   options            \description
	   -----------------  ----------------------------------------------
	   data               user�s data.
	   axesDefaults       default options that will be applied to all
	                       axes.
	   seriesDefaults     default options that will be applied to all
	                       series.
	   series             Array of series object options.
	   axes               up to 4 axes are supported, each with it�s
	                       own options, See Axis for axis specific
	                       options.
	   grid               See Grid for grid specific options.
	   legend             see \<$.jqplot.TableLegendRenderer\>
	   seriesColors       An array of CSS color specifications that
	                       will be applied, in order, to the series in
	                       the plot.
	   sortData           false to not sort the data passed in by the
	                       user.
	   fontSize           css spec for the font-size attribute.
	   title              Title object.
	   stackSeries        true or false, creates a stack or �mountain�
	                       plot.
	   defaultAxisStart   1-D data series are internally converted into
	                       2-D [x,y] data point arrays by jqPlot.<p />
	   </table>
	   
	   The complete reference to jqplot default properties can be
	   found at <extlink http://www.jqplot.com/docs/files/jqplot-core-js.html#jqPlot>http://www.jqplot.com/docs/files/jqplot-core-js.html#jqPlot</extlink>
	   
	   
	   Parameters
	   default :  phpChart default values
	   Example
				   <extlink http://phpchart.net/phpChart/examples/set_defaults.php>Set
	   Defaults Example</extlink>
	   Returns
	   None                                                                                                                                                */
	public function set_defaults($def=array()){
		foreach($def as $prop=>$val){                                       
			$this->options[$prop] = $val;                                   //sets the default value into the options Array
		}            
	}

	/* Returns
	   None
	   Description
	   Sets captureRightClick property. When enabled, the mouse
	   right click can be used to trigger events. It can be used
	   together with jqplotDataRightClick event to display data. See
	   Funnel Chart example for this usage.
	   Summary
	   Sets captureRightClick property
	   Parameters
	   capture_right_click :  boolean\: true or false
	   Example
				   <extlink http://phpchart.net/phpChart/examples/funnel_test.php>Funnel
	   Chart</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/bar_test.php>Bar
	   Chart</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/donut_test.php>Donut
	   Chart</extlink>                                                                      */
	public function set_capture_right_click($val){
		$this->options['captureRightClick'] = $val;                         //assigned captureRightClick property
	}

	/* 
	Summary
	Sets stackSeries property.
	Description
	Sets stackSeries property. The parameter value should be true or false indicating whether to stack the series. Only works for line and bar chart types.
	
	<image stack1>

	<image stack2>

	Parameters
	is_stacked:   boolean

	Example
				<extlink http://phpchart.net/phpChart/examples/bar_line_pie_stack.php>Bar Line Pie Stack</extlink>

				<extlink http://phpchart.net/phpChart/examples/filled_line.php>Filled Line</extlink>

	Returns
	None                                                                                        */
	public function set_stack_series($val){
		$this->options['stackSeries'] = $val;
	}

	/**
	* Internal Function. Cannot be called outside of class scope
	* Load jQplot plugins dynamically by parsing the jqplot options as string
	* It dynamically parses the json to obtain plugins so users dont' have to load the plugins manually.
	* 
	* Params:
	*      @plugins: Array
	* 
	* Returns: None
	*/
	private function load_jqplot_plugins($jqplot_options){
		// echo json_encode($this->options);
		$has_plugin = preg_match_all('/"plugin::([^"]*)"/i', $jqplot_options, $plugin_matches);
		//	echo 'matches: '.$has_plugin."\n";
		//	echo '<pre>';
		//	print_r($plugin_matches);
		//	echo '</pre>';
		if($has_plugin){
			$this->jqplot_plugins = array_merge($this->jqplot_plugins, array_map('strtolower', $plugin_matches[1]));
			$this->jqplot_plugins = array_unique($this->jqplot_plugins); // remove duplicates
			// echo '<pre>';
			// print_r($this->jqplot_plugins);
			// echo '</pre>';			
		}	
	}

				

	/* Summary
	   Adds non-renderer plugins manually
	   Description
	   Adds renderer plugins manually. Generally used for plugins
	   don't have renderer options. e.g. highlighter, cursor, zoom
	   etc.
	   Parameters
	   plugins :  Array. Name of one or more plugins 
	   Example
				   <extlink http://phpchart.net/phpChart/examples/zoom1.php>Zoom</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/banded_line.php>Banded
	   Line</extlink>
	   
				   <extlink http://phpchart.net/phpChart/examples/axis_labels_rotated_text.php>Axis
	   Labels Rotated Text</extlink>
	   Remarks
	   A list of non-renderer plugins can be found <extlink http://phpchart.net/examples/add-non-renderer-plugins/>Add
	   Non-renderer Plugins</extlink> phpChart website.
	   Returns
	   None                                                                                                            */
				
	public function add_plugins($plugins = array()){
		$this->jqplot_plugins = array_merge($this->jqplot_plugins, array_map('strtolower', $plugins));      
	}


	/**
	* Sets defaultTickFormatString property
	* 
	* Params: 
	*      @str: String
	* 
	* Returns: None
	* 
	*/
	public function set_default_tick_format_string($str){
		$this->options['defaultTickFormatString'] = $str;                     //sets defaultTickFormatString property
	}

	/**
	* Adds CSS and JS files dynamically
	* 
	* Params:
	*      @fileName: String, the file that will be added, (required)
	*      @fileType: String, the file Type, possible values are css and js, default none (required)
	*		@addToHeader: Boolean, insert between HTML Header tag (optional)
	* 
	* Returns: true
	*/
	private function addCSSJS($fileName='',$fileType='',$addToHeader=false){
		$fname = $fileName;                                             //set the fileName to a temporary variable
		if($fileName=='' || $fileType=='') die('addCSSJS method requires 2 parameters to be defined');  //check if second parameter sets properly

		if($fileType == 'plugins')                                      
			$fileName = $this->scriptpath.'js/plugins/'.$fileName;  //sets filepath for plugins
		else	
			$fileName = $this->scriptpath.'js/'.$fileName;          //sets filepath for other JS files

		if(!in_array($fname, $this->get_js_css())){                     //checks if the file aleady being added by a previous call, 
																		//if the file exists in this array, that means the file is
																		//already being loaded, therefore the attempt will fall 

			ob_start();

			if($addToHeader){
				if($fileType == 'css'){                                     //if the fileType is css then execute following javascript code
					echo "<script type='text/javascript'>
						var fileref=document.createElement('link');
						fileref.setAttribute('rel', 'stylesheet');
						fileref.setAttribute('type', 'text/css');
						fileref.setAttribute('href', '$fileName');
						document.getElementsByTagName('head')[0].appendChild(fileref)
						//document.getElementById('$this->target').appendChild(fileref)
					</script>";
				}
				else if($fileType == 'js' || $fileType == 'plugins'){       //if the fileType is js then execute following javascript code
					echo "<script type='text/javascript'>
						var fileref=document.createElement('script');
						fileref.setAttribute('type', 'text/javascript');
						fileref.setAttribute('src', '$fileName');
						//alert('$fileName');
						document.getElementsByTagName('head')[0].appendChild(fileref)
						//document.getElementById('$this->target').appendChild(fileref)
					</script>";
				}
			}else{
				if($fileType == 'css'){ 
					echo '<link rel="stylesheet" type="text/css" href="'. $fileName .'" />' ."\n";
				}
				else if($fileType == 'js' || $fileType == 'plugins'){ 
					if(strstr($fileName, 'excanvas.min.js')){
						echo '<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="'. $fileName .'"></script><![endif]-->' ."\n";
					}
					else if(strstr($fileName, 'jquery.min.js')){
						echo '<script type="text/javascript">if (typeof jQuery == "undefined"){document.write("<script src=\''. $fileName .'\' language=\'javascript\' type=\'text/javascript\'><\/script>");}</script>' ."\n";
					}
					else{
						echo '<script language="javascript" type="text/javascript" src="'. $fileName .'"></script>' ."\n";
					}
				}
			}
			
			$this->script_includeonce .= ob_get_contents();		// capture output into variable used by get_display
			ob_end_flush();


			//store javascript and css file
			$this->set_js_css($fname);                                  //once adding is done, call the set_js_css member function 
																		//to keep track of the files
		}

		return true;                                                    //returns boolean true
	}
	
	/* \ \ 
	   Description
	   Enable debug to view generated client-side jqplot script and
	   list of plugins used. Debug can also be set globally by
	   defining DEBUG constant, or use enable_debug function to set
	   individual phpChart object.
	   Summary
	   Enable debug
	   Parameters
	   debug :  boolean value\: true or false
	   Returns
	   None                                                         */
	public function enable_debug($debug){
		$this->debug = $debug;
	}

	/**
	* Include javscript files only once on a single web page.
	* It's achieved using static array variable $js_css[]
	* 
	*/
	public function display_script_includeonce($scripts=NULL,$type=''){
											
		if(is_array($scripts)){
			if($type == 'js'){
				foreach($scripts as $k => $js_filename){
					$this->addCSSJS($js_filename.'.min.js','js');
				}
			}
			else if($type == 'css'){
				foreach($scripts as $k => $css_filename){
					$this->addCSSJS($css_filename.'.min.css','css');
				}
			}
		}
		else {			
			$this->load_jqplot_plugins(json_encode($this->options));	
			if(count($this->jqplot_plugins) > 0){
				foreach($this->jqplot_plugins as $k => $plugin_name){
					$this->addCSSJS('jqplot.'.$plugin_name.'.min.js','plugins');
				}
			}
		}

		if($this->debug){
			echo '<link rel="stylesheet" type="text/css" href="'. $this->scriptpath .'css/debug.css" />';
			echo '<link rel="stylesheet" type="text/css" href="'. $this->scriptpath .'js/highlighter/styles/'. JS_HIGHLIGHT_CSS_STYLE .'.css" />';
			echo '<script src="'. $this->scriptpath .'js/highlighter/highlight.pack.js"></script>';
			echo '<script>hljs.initHighlightingOnLoad();</script>';

			echo '<script src="'. $this->scriptpath .'js/jquery-ui-1.8.16.custom.min.js"></script>';
			echo '<link rel="stylesheet" type="text/css" href="'. $this->scriptpath .'js/css/cupertino/jquery-ui-1.8.16.custom.css" />';
			}
		return true;
	}

	private function display_container($height,$width){
		$bindHTML = '<div id="bind_'.$this->target.'"><span id="bind_span_label_'.$this->target.'"></span><span id="bind_span_data_'.$this->target.'"></span></div>';
		$plotHTML = '<div id="'. $this->target .'" class="plot jqplot-target" style="width:'.$width.';height:'.$height.';"></div>' ."\n\n";
		echo $bindHTML.$plotHTML;
	}

	// beginning javascript output
	// Note the variables are declared here OUTSIDE the $(document).ready() for global reference
	private function display_script_begin(){
		if($this->debug){
			echo "\n". '<h3 style="color:#2779AA;">Renderer plugins used:</h3>';
			echo "\n".'<pre><code>';
			print_r($this->jqplot_plugins);
			echo '</code></pre>'."\n";
			echo '<br /><br /><br /><br /><hr size="1" />';
		}
		echo "\n". '<script '. (($this->debug)?'class="code" ':'') .' language="javascript" type="text/javascript"> ' ."\n";
		foreach($this->js_vars as $kv => $va){
			echo "var $va;". "\n";
		}
		echo "var ". $this->plot_properties_jsvarname .";"."\n";
		echo '$(document).ready(function(){ ' ."\n";
	}


	private function display_properties_main(){
		$this->jsCustom = '';
		$this->jsCustomAfter = '';
		$this->jsCustomOutsideJQuery = '';
				
		foreach($this->customJSAddOrder as $jk => $js_order){
			if($js_order == 'before') $this->jsCustom = $this->jsCustom."\n\n".$this->customJS[$jk]. "\n\n";
			else if($js_order == 'after') $this->jsCustomAfter = $this->jsCustomAfter."\n\n".$this->customJS[$jk]. "\n\n";
			else if($js_order == 'outside_jquery') $this->jsCustomOutsideJQuery = $this->jsCustomOutsideJQuery . "\n\n".$this->customJS[$jk]. "\n\n";
		}

		$jQplotDefaults = '';
		$jQplotDefaults .= "$.jqplot.config.enablePlugins = $this->enablePlugins;"."\n";
		$jQplotDefaults .= "$.jqplot.config.defaultHeight = $this->defaultHeight;"."\n";
		$jQplotDefaults .= "$.jqplot.config.defaultWidth  = $this->defaultWidth;"."\n";

		$jqplot_config = $this->get_config();
		if($jqplot_config != NULL){
			foreach($jqplot_config as $ck => $conf_val){
				$jQplotDefaults .= "$.jqplot.config.$ck = '$conf_val';"."\n";
			}
		}

		// Note that the js variables will be declare outside of document).ready() in display_properties_begin for global reference				
		$plot_properties = '';
		foreach($this->js_vars as $kv => $va){
			$plot_properties .= "$va = ".json_encode($this->data[$kv]). ";". "\n";	
		}
				
		// js plot_properties variable is now reused and passed as the 3rd parameter in jqPlot
		// Remove surrounding quotes in $.jqplot.<pluginname>, and user defined custome functions.
		// PHP regex modifiers: i - ignore case, e - envaluation of replacement as PHP code
		//$plot_propertiesTemp = preg_replace('/"(\$\.jqplot\.[^"]*)"/i', '$1', json_encode($this->options));
		$plot_propertiesTemp = preg_replace('/"plugin::([^"]*)"/i', '$.jqplot.$1', json_encode($this->options));
		$plot_properties .= $this->plot_properties_jsvarname ." = ". preg_replace('/"js::([^"]*)"/i', '$1', ($this->debug)?C_Utility_pC::indent_json($plot_propertiesTemp):$plot_propertiesTemp)."\n";
						
		//echo "alert(".json_encode($this->js_theme).");";
		switch ($this->render_type){
			case 'extend':
				//echo 'alert("came");';
				$plot_properties .= "\n".$this->jsCustom."\n"."\n".$jQplotDefaults.' _'.$this->target.'= $.jqplot("'. $this->target .'", '.
					json_encode($this->data) .', '.
					' $.extend(true, {}, '.json_encode($this->js_theme) .', '.
					$this->plot_properties_jsvarname .'));'."\n".$this->jsCustomAfter."\n";
				break;

			case 'json_data':
				$plot_properties .= "\n".$this->jsCustom."\n"."\n".$jQplotDefaults.' _'.$this->target.'= $.jqplot("'. $this->target .'", \''.
					$this->data .'\', '.
					$this->plot_properties_jsvarname .');'."\n".$this->jsCustomAfter."\n";
				break;

			case 'default':
			default :
				$plot_properties .= "\n".$this->jsCustom."\n"."\n".$jQplotDefaults.' _'.$this->target.'= $.jqplot("'. $this->target .'", '.
					json_encode($this->data) .', '.
					$this->plot_properties_jsvarname .');'."\n".$this->jsCustomAfter."\n";
				break;
		}

		// echo $jquerySetTimeOut = "setTimeout( function() { ". "\n". $plot_properties ."}, 200 );";
        echo $jquerySetTimeOut = $plot_properties;
	}

	/* Summary
	   Add user defined custom javascript used for custom event
	   handling.
	   Description
	   Use this method to add user defined javascript to phpChart.
	   By default, the custom javascript is added before the jqplot
	   object was generated. User can specify the add order in the
	   function second parameter. You can use custom javascript to
	   create interactive charts such as displaying additional data
	   when mouse over a series data.
	   
	   
	   
	   <image highlighter>
	   Parameters
	   js :        user defined javascript
	   addorder :  three options available\:
	               * "before"
	               * "after"
	               * "outside_jquery"
	               <p />add custom javascript before or after the
	               jqplot object, or outside the jquery. "before" is
	               the default value.
	   Example
	   <extlink http://phpchart.net/phpChart/examples/donut_test.php>Donut
	   Graph</extlink>
	   
	   <extlink http://phpchart.net/phpChart/examples/highlighter_2.php>Highlighter
	   2</extlink>
	   
	   <extlink http://phpchart.net/phpChart/examples/axis_label_new.php>Axis
	   Labels</extlink>
	   Remarks
	   In most cases, the custom javascript function can be simply
	   defined between \<script\> tag outside the phpChart code
	   without using this method, which is the same as using
	   "outside_jquery" as addorder parameter. Depending on the user
	   custom javascript scope required, different addorder value
	   may be needed.
	   Returns
	   None                                                                         */
	public function add_custom_js($js,$addorder='before'){
		$this->customJSAddOrder[] = $addorder;
		$this->customJS[] = $js;
	}

		/* Summary
		   Bind phpChart events with event handler.
		   Description
		   Use this method to bind phpChart event handler to phpChart
		   events. Some events such as jqplotDataHighlight and
		   jqplotDataUnHighlight requires using bind_js method for event
		   handling.
		   Parameters
		   event_name :  Name of the event
		   eventData :   data used for the event
		   bind_label :  binding label (optional)
		   bind_obj :    binding object (optional)
		   Example
				   <extlink http://phpchart.net/phpChart/examples/area_new.php>Area
		   Graph</extlink>
		   
				   <extlink http://phpchart.net/phpChart/examples/bar_test.php>Bar
		   Chart</extlink>
		   
				   <extlink http://phpchart.net/phpChart/examples/bubble_chart_2.php>Bubble
		   Chart</extlink>
		   
				   <extlink http://phpchart.net/phpChart/examples/funnel_test.php>Funnel
		   Chart</extlink>
		   Remarks
		   This is a more advanced feature. It's used often for dynamic
		   display based such as mouse over to display additional data
		   display etc. See examples for more details.
		   Returns
		   None                                                                                    */
	public function bind_js($event_name='', $eventData = NULL,$bind_label='',$bind_obj=''){

		if($event_name == 'custom'){
			echo "<script type='text/javascript'> $(document).ready(function (){ $eventData });</script>";
			return;
		}
		$bindDataShowHTML = '';
		if($eventData != NULL) {
			if(!is_array($eventData)) {
				echo 'Bind JS Error: event data supplied was not an array';
				return false;
			}
			$bindparams = '';
			$count = 1;
			foreach ($eventData as $key => $eData){
				if(count($eventData) <= 1){
					$bindDataShowHTML = $eData.'^ ';
					break;
				}
				if(!is_string($key)) $bindDataShowHTML .= $eData.': '.$eData;
				else $bindDataShowHTML .= $key.':^ +'.$eData .'+^, ';
					
				if($count <=3)$bindparams .= ','.$eData;
				$count++;
			}
		}


		$target_name = $this->target;
		if($bind_obj == '')$bind_obj= 'bind_span_data_'.$this->target;
		if($bind_label == '') $bind_label = '&nbsp;';            

		if(count($eventData) > 1) $bindDataShowHTML = str_replace("^","'",'^'.substr($bindDataShowHTML, 0,-4));
		else $bindDataShowHTML = str_replace("^","'",'^'.substr($bindDataShowHTML, 0,-1));

		$bindJS = "$(document).ready(function(){ ". "\n". 
			"$('#bind_span_label_$target_name').html('$bind_label'); ". "\n". 
				"$('#$target_name').bind('$event_name',
					function (ev$bindparams){
						$('#$bind_obj').html($bindDataShowHTML);
					}
				); });"."\n";


		//echo $bindJS;
		echo "<script type='text/javascript'>"."\n". $bindJS ."\n". "</script>"."\n";

	}



	private function display_script_end(){
		echo "\n". '});' ."\n";
		echo $this->jsCustomOutsideJQuery;
		echo '</script>' ."\n";
					if($this->debug) echo '<script type="text/javascript" src="'.  $this->scriptpath .'js/showjs.js"></script>' ."\n"."\n";
		echo '<div style="clear:both;">&nbsp;</div>';
	}	
	

	public function init(){}
	public function resetAxesScale(){}				
	public function reInitialize(){}				
	public function destroy(){}				
	public function replot(){}						
	public function redraw(){}												
	public function drawSeries(){}					
	public function moveSeriesToFront(){}			
	public function moveSeriesToBack(){}			
	public function restorePreviousSeriesOrder(){}
	public function restoreOriginalSeriesOrder(){}
		
	/* \ \ 
	   Description
	   Draw phpChart. It always outputs to an internal buffer first. It's should be last function to call.
	   Summary
	   Draw phpChart.
	   Parameters
	   width :   integer width default to 600 (optional)
	   height :  integer height default to 400 (optional)
	   extra_data :  NOT IN USE (optional)
	   render_content :  boolean. Whether to render the chart. If false, it renders to buffer only. Later the chart can be retrieved by get_display (optional)
	   Returns
	   None                                                 */
	public function draw($width=600,$height=400,$extra_data=array(),$render_content=true){
		$height = $height.'px';
		$width  = $width.'px';
		$this->extra_data = $extra_data;
		$this->jqplot_show_plugins($this->jqplot_plugins);                    //calls the member function: jqplot_show_plugins
		$this->wrap_jqplot();
			
		$this->display_script_includeonce();

		ob_start();

		$this->display_container($height,$width);
		$this->display_script_begin();
		$this->display_properties_main();
		$this->display_script_end();

		$this->script_body = ob_get_contents();		// capture output into variable used by get_display
		$this->script_body = preg_replace('/,\s*}/', '}', $this->script_body);	// remove trailing comma in JSON just in case

		ob_end_clean();			

		if($render_content){
			echo $this->script_body;
		}
	}

		/* \ \ 
	   Description
	   return the grid script include and body. It can be useful for MVC framework integration such as Drupal.
	   Summary
	   Get phpChart script.
	   Parameters
	   add_script_includeonce :   true or false. Default to true, whether to also return javascript include (optional)
	   Returns
	   script body                                                 */
	public function get_display($add_script_includeonce=true){
		if($add_script_includeonce){
			return $this->script_includeonce . $this->script_body;
		}else{
			return $this->script_body;
		}
	}
	
}
?>
