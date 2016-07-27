<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 /** \brief Clase para el manejo en general de los Paros
	*
	* En esta clase se definen los metodos para el manejo de un formulario
	* <b>"Formulario"</b>.
	*
	* @author	Miguel Peralta
	* @version	1.0
	* @date		Ene 08, 2015
	*
	* 
	*/
class Formulario extends PEAR  {
    
    var $name;
    var $id;
    var $action;
    var $method;
    var $class;
    var $onsubmit;
    var $form;
    var $input;
    var $type;
    var $label;
    var $value;
    var $oForm;
    var $cForm;
    var $radio;
    var $checkbox;
    var $select;
    var $texto;
    var $fieldset;
    var $legend;
    var $widht;
    var $color;
    var $bgcolor;
    var $url_imagen;
    var $img;
    
    function openform($name='form1', $method='post', $action='#', $class='', $onsubmit='',$color=''){
            $this->action = $action;
            $this->method = $method;
            $this->name = $name;
            $this->class = $class;
            $this->onsubmit = $onsubmit;
            $this->color=$color;
           
            $this->oform = "<form style='background-color:$this->color'name='".$this->name."' action='".$this->action."' method='".$this->method."' class='".$this->class."' onsubmit='".$this->onsubmit."'>";
            return $this->oform;
        }
        function addInput($type, $name, $label='',$value=''){
            $this->type = $type;
            $this->name = $name;
            $this->label= $label;
            $this->value = $value;
     
            if($this->type == "submit" || $this->type=="reset"){
                $this->input = "<label></label>";
            }
            else{
                $this->input= "<label>".$this->label."</label><br>";
            }
           
            $this->input .= "<input type='".$this->type."' name='".$this->name."' value='".$this->value."' id='".$this->name."'/>";
           
            return $this->input;
        }
        function addcheckradio($type,$name,$values,$selected=0){
       
            unset($this->radio);
           
            $this->value = $values;
            $this->selected = $selected;
            $this->type = $type;
           
            if ($this->type=="checkbox"){
                $this->name = $name."[]";
            }
            else{
                $this->name = $name;
            }
           
            $c=1;  
            while(list($val,$l)=each($this->value)){   
                if ($c==$this->selected){
                    $this->check = " checked/>";
                }
                else{
                    $this->check = " />";
                }
               
                $this->radio .=  "<label>".$this->value[$val]."</label><input type='".$this->type."' name='".$this->name."' value='".$val."'".$this->check."<br>";
                $c++;
            }
            return  $this->radio;
        }
        function addTextarea($name, $cols=20, $rows=5, $label='',$value=''){
            $this->name=$name;
            $this->row= $rows;
            $this->col= $cols;
            $this->value = $value;
            $this->label = $label;
           
            $this->textarea = "<label>".$this->label."</label><br><textarea name='".$this->name."' cols='".$this->col."' rows='".$this->row."'>".$this->value."</textarea>";
            return $this->textarea;
        }
        function addSelect($name, $values, $label='', $multiple=0){
           
            $this->values=$values;
            $this->name=$name;
            $this->label=$label;
           
            if($multiple==1){
                $this->select = "<label>".$this->label."</label><br><select name='".$this->name."[]' multiple='multiple'>";
            }
            else{
                $this->select = "<label>".$this->label."</label><br><select name='".$this->name."'>";
            }
           
            while(list($values, $text)=each($this->values))
            {      
                $this->select .= "<option value='".$values."'>".$this->values[$values]."</option>";
            }
                $this->select  .= "</select>";
     
            return $this->select;
        }
        function addLabel( $text, $color='#000000',$id){
            
            $this->texto= $text;
            $this->color= $color;
            $this->id=$id;
            
           
            $this->label = "<label id='$this->id' style='color:$this->color'>".$this->texto."</label>";
            return $this->label;
        }
        function addImage($url_imagen){
            $this->url_imagen=$url_imagen;
            
            $this->img="<img src='$this->url_imagen'>";
            return $this->img;
        }
        
        function openfieldset($texto,$width='300',$color){
            $this->legend=$texto;
            $this->width=$width;
            $this->color=$color;
            
            $this->fieldset="<fieldset style='width:".$this->width."px ;'><legend style='color:".$this->color."'>".$this->legend."</legend>";
            return $this->fieldset;
        }
        function closefieldset(){
           
            $this->fieldset="</fieldset>";
            return $this->fieldset;
        }
        function closeform(){
            $this->cform = "</form>";
            return $this->cform;
        }

}

