<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MDS extends PEAR{
    
    
    function getAllProjects(){
            global $mds;

                    $sql = "select * from pf_product_family ";
          
            //Basic::EventLog("projects->getAllRecords: ".$sql);
            $res =& $mds->query($sql);
            return $res;
    }
     function getAllProjectsById($id){
            global $mds;

                    $sql = "select * from pf_product_family where pf_bu_id='$id'";
          
            //Basic::EventLog("projects->getAllRecords: ".$sql);
            $res =& $mds->query($sql);
            return $res;
    }
    function getAllDivisions(){
            global $mds;

                    $sql = "select * from bu_business_unit";
          
            //Basic::EventLog("projects->getAllRecords: ".$sql);
            $res =& $mds->query($sql);
            return $res;
    }
    
     function printSelectProjects($execFunction, $id = 0){         
                 
                $arreglo =& self::getAllProjectsById($id);
                
                    $html = "<h5>Proyecto:</h5>
                    <select id='project' name='project' onChange=\"xajax_$execFunction(document.getElementById('project').value);\">
                    <option value='0'> --Seleccionar--</option>";
                         while ($row=$arreglo->fetchRow()) {
                         $html .= "<option value='".$row['pf_id']."'>".$row['pf_name']."</option>"; }

                      $html .= "</select>";
             
            //Basic::EventLog("Projects->printSelect: ".$html);
            return $html;
        }
        
        function printSelectDivision($execFunction=null){
    
                $arreglo =& self::getAllDivisions();
                
                    $html = "<h5>Business Unit:</h5>
                    <select id='pfamily' name='pfamily' onChange=\"xajax_$execFunction(document.getElementById('pfamily').value);\">
                    <option value='0'> -- None --</option>";
                    while ($row=$arreglo->fetchRow()) {
                     $html .= "<option value='".$row['bu_id']."'>".$row['bu_name']."</option>"; }

                      $html .= "</select>";
 return $html;
    
}


}