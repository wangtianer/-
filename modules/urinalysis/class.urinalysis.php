<?php

  class urinalysis extends module{
  
  
  
    function urinalysis(){
      $this->author = "darth_ali";
      $this->module = "urinalysis";
      $this->version = "0.1-".date("Y-m-d");
      $this->description = "CHITS Module - Urinalysis Examination";    
      
      $this->color = array('---','Yellow','Pale Yellow','Dark Yellow','Amber','Straw');
      $this->reaction = array('---','Acidic','Alkaline','Neutral');
      $this->transparency = array('---','Clear','St. Turbid','Turbid','Very Turbid');
      $this->gravity = array('---','1:000','1:005','1:010','1:015','1:020','1:025','1:030');
      $this->ph = array('---','5.0','6.0','6.5','7.0','7.5','8.0');
      
      $this->albumin = array('---','Negative','Positive','+','++','+++','++++');
      $this->sugar = array('---','Negative','Positive','+','++','+++','++++');      
      $this->pregnancy = array('---','Negative','Positive','Doubtful');      
    }
    
    // ----- STANDARD MODULE FUNCTIONS -----
    
    function init_deps(){
      module::set_dep($this->module,"module");
      module::set_dep($this->module,"lab");    
    }              
    
    
    function init_lang(){
    
    }
    
    function init_stats(){
    
    }
    
    function init_help(){
    
    
    }
    
    function init_menu(){
      if(func_num_args()>0):
        $arg_list = func_get_args();
      endif;
      
      module::set_detail($this->description,$this->version,$this->author,$this->module);
    }
    
    function init_sql(){
	module::execsql("CREATE TABLE IF NOT EXISTS `m_consult_lab_urinalysis` (
	  `consult_id` float NOT NULL,`request_id` float NOT NULL,`patient_id` float NOT NULL,`date_lab_exam` date NOT NULL,
	  `physical_color` text NOT NULL,`physical_reaction` text NOT NULL,`physical_transparency` text NOT NULL,`physical_gravity` text NOT NULL,
	  `physical_ph` text NOT NULL,`chem_albumin` varchar(10) NOT NULL,`chem_sugar` varchar(10) NOT NULL,`chem_pregnancy` varchar(10) NOT NULL,
	  `sediments_rbc` text NOT NULL,`sediments_pus` text NOT NULL,`sediments_epithelial` text NOT NULL,`sediments_urates` text NOT NULL,
	  `sediments_calcium` text NOT NULL,`sediments_fat` text NOT NULL,`sediments_phosphate` text NOT NULL,`sediments_uric` text NOT NULL,
	  `sediments_amorphous` text NOT NULL,`sediments_carbonates` text NOT NULL,`sediments_bacteria` text NOT NULL,
	  `sediments_mucus` text NOT NULL,`cast_coarsely` text NOT NULL,`cast_pus` text NOT NULL,`cast_hyaline` text NOT NULL,
	  `cast_finely` text NOT NULL,`cast_redcell` text NOT NULL,`cast_waxy` text NOT NULL,`release_flag` text NOT NULL,
	  `release_date` date NOT NULL,`user_id` int(11) NOT NULL
	) ENGINE=MyISAM DEFAULT CHARSET=latin1");    
    }
    
    function drop_tables(){
    	module::execsql("DROP TABLE m_consult_lab_urinalysis");
    
    }
    

    // --- CUSTOM-BUILT FUNCTIONS ---
    
    function _consult_lab_urinalysis(){
      if(func_num_args()>0):
        $arg_list = func_get_args();
        $menu_id = $arg_list[0];
        $post_vars = $arg_list[1];
        $get_vars = $arg_list[2];  
        $validuser = $arg_list[3];
        $isadmin = $arg_list[4];      
      endif;
                                                                  
      if($exitinfo=$this->missing_dependencies('urinalysis')):
        return print($exitinfo);
      endif;
                                                                                      
      $u = new urinalysis;
      
      if($_POST["submitlab"]):
                    
      endif;
      
      $u->form_consult_lab_urinalysis($menu_id,$post_vars,$get_vars);
      
                                                                                            
    
    }
    
    function _consult_lab_urinalysis_result(){
    
    }
    
    function form_consult_lab_urinalysis(){
      if(func_num_args()>0):
        $arg_list = func_get_args();
        $menu_id = $arg_list[0];
        $post_vars = $arg_list[1];
        $get_vars = $arg_list[2]; 
        $validuser = $arg_list[3];
        $isadmin = $arg_list[4];  
      endif;
      
      echo "<form action='$_SERVER[PHP_SELF]?page=$_GET[page]&menu_id=$_GET[menu_id]&consult_id=$_GET[consult_id]&ptmenu=$_GET[ptmenu]&module=$_GET[module]&request_id=$_GET[request_id]#$_GET'.'_form' method='POST' name='form_lab'>";
      echo "<a name='urinalysis'></a>";
      echo "<table border='1' width='550'>";
      echo "<tr><td colspan='2'>URINALYSIS</td></tr>";
      echo "<tr><td>PHYSICAL APPEARANCE</td><td>QUANT. CHEMICAL TEST</td></tr>";
      echo "<tr>";
      echo "<td>";
      echo "<table>";      
      echo "<tr><td class='boxtitle'>COLOR</td><td><select name='sel_color' value='1' class='tinylight'>";
      
      foreach($this->color as $key_color=>$value_color){
        echo "<option value='$value_color'>$value_color</option>";
      }      
      echo "</select></td></tr>";
      
      echo "<tr><td class='boxtitle'>REACTION</td><td><select name='sel_reaction' value='1'>";      
      foreach($this->reaction as $key_reaction=>$value_reaction){
        echo "<option value='$value_reaction'>$value_reaction</option>";
      }            
      echo "</select></td></tr>";
      
      echo "<tr><td class='boxtitle'>TRANSPARENCY</td><td><select name='sel_transparency' value='1'>";
      
      foreach($this->transparency as $key_trans=>$value_trans){
        echo "<option value='$value_trans'>$value_trans</option>";
      }
      
      echo "</select></td></tr>";
      
      echo "<tr><td class='boxtitle'>SPECIFIC GRAVITY</td><td><select name='sel_gravity' value='1'>";
      
      foreach($this->gravity as $key_gravity=>$value_gravity){
        echo "<option value='$value_gravity'>$value_gravity</option>";
      }      
      echo "</select></td></tr>";
      
      echo "<tr><td class='boxtitle'>pH</td><td><select name='sel_ph' value='1'>";
      
      foreach($this->ph as $key_ph=>$value_ph){
        echo "<option value='$value_ph'>$value_ph</option>";
      }            
      echo "</select></td></tr>";
      echo "</table>";
      echo "</td>";
      
      echo "<td valign='top'>";
      echo "<table>";      
      echo "<tr><td class='boxtitle'>ALBUMIN</td><td><select name='sel_albumin' value='1'>";
      
      
     foreach($this->albumin as $key_albumin=>$value_albumin){
       echo "<option value='$value_albumin'>$value_albumin</option>";     
     }     
     echo "</select></td></tr>";
     
     
     echo "<tr><td class='boxtitle'>SUGAR</td><td><select name='sel_sugar' value='1'>";
     
     foreach($this->sugar as $key_sugar=>$value_sugar){
       echo "<option value='$value_sugar'>$value_sugar</option>";
     }          
     echo "</select></td></tr>";     
     
     
     echo "<tr><td class='boxtitle'>PREGNANCY TEST</td><td><select name='sel_pregnancy' value='1'>";
     
     foreach($this->pregnancy as $key_pregnancy=>$value_pregnancy){
       echo "<option value='$value_pregnancy'>$value_pregnancy</option>";
     }     
      echo "</select></td></tr>";
      echo "</table>";
      echo "</td>";
      
      echo "</tr>";
      
      echo "<tr><td colspan='2'>SEDIMENTS</td></tr>";
      
      echo "<tr><td valign='top'>";
      echo "<table>";
      echo "<tr><td class='boxtitle'>RED BLOOD CELLS</td><td><input type='text' name='txt_red' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>PUS CELLS</td><td><input type='text' name='txt_pus' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>EPHITHELIAL CELLS</td><td><input type='text' name='txt_epithelial' size='5'></input></td></tr>";      
      echo "<tr><td class='boxtitle'>AMORPHOUS URATES</td><td><input type='text' name='txt_amorphous' size='5'></input></td></tr>";            
      echo "<tr><td class='boxtitle'>CALCIUM OXELATES</td><td><input type='text' name='txt_calcium' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>FAT GLOBULES</td><td><input type='text' name='txt_fat' size='5'></input></td></tr>";
      echo "</table>";
      echo "</td>";
      
      echo "<td class='boxtitle'>";
      echo "<table>";
      echo "<tr><td class='boxtitle'>TRIPLE PHOSPHATES</td><td><input type='text' name='txt_triple' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>URIC ACID CRYSTALS</td><td><input type='text' name='txt_uric' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>AMORPHOUS PHOSPATES</td><td><input type='text' name='txt_amorphouse_phosphate' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>CALCIUM CARBONATES</td><td><input type='text' name='txt_calcium' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>BACTERIA</td><td><input type='text' name='txt_bacteria' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>MUCUS THREADS</td><td><input type='text' name='txt_bacteria' size='5'></input></td></tr>";   
      echo "</table>";
      echo "</td>";
      
      echo "</tr>";
      
      echo "<tr>";
      echo "<td colspan='2'>CASTS</td></tr>";
      
      echo "<tr>";      
      echo "<td valign='top' class='boxtitle'>";
      echo "<table>";    
      echo "<tr><td class='boxtitle'>COARSELY GRANULAR CAST</td><td><input type='text' name='txt_granular' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>PUS CELLS CAST</td><td><input type='text' name='txt_pus' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>HYALINE CAST</td><td><input type='text' name='txt_hyaline' size='5'></input></td></tr>";            
      echo "</table>";
      echo "</td>";
      
      echo "<td class='boxtitle'>";
      echo "<table>";    
      echo "<tr><td class='boxtitle'>FINELY GRANULAR CAST</td><td><input type='text' name='txt_finely_cast' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>RED CELL CAST</td><td><input type='text' name='txt_red_cell' size='5'></input></td></tr>";
      echo "<tr><td class='boxtitle'>WAXY CAST</td><td><input type='text' name='txt_wax' size='5'></input></td></tr>";      
      echo "</table>";
      
      echo "</td>";
      
      echo "</tr>";
      
      
      echo "<tr valign='top'><td colspan='2'>";
      echo "<span class='boxtitle'>".LBL_RELEASE_FLAG."</span><br>";
      
      echo "<input type='checkbox' name='release_flag' value='1'/> ".INSTR_RELEASE_FLAG."<br />";
      echo "</td></tr>";      
                                                                                        
      echo "<tr><td colspan='2' align='center'>";
      
      if ($get_vars["request_id"]) {                                                      
          print "<input type='hidden' name='request_id' value='".$get_vars["request_id"]."'>";
                                                                      
          if ($_SESSION["priv_update"]) {
              print "<input type='submit' value = 'Update Lab Exam' class='textbox' name='submitlab' style='border: 1px solid #000000'>&nbsp; ";
          }           
          print "<input type='reset' value = 'Clear Lab Exam' class='textbox' name='submitlab' style='border: 1px solid #000000'> ";   
      }      
      echo "</td></tr>";            
            
      echo "</table>";
      echo "</form>";
                                                
    
    }
    
  
  
  
  }
?>