<?php

session_start();

ob_start();

require('./fpdf/fpdf.php');


$db_conn = mysql_connect("localhost","$_SESSION[dbuser]","$_SESSION[dbpass]");
mysql_select_db($_SESSION[dbname]);

class PDF extends FPDF
{
	var $widths;
	var $aligns;
	var $page;	
	
	
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C'; //sets the alignment of text inside the cell
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}


function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}


function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}


function Header()
{        
    
    if($_SESSION[ques_no]==92 || $_SESSION[ques_no]==93):  //header for TB M and Q reports
    
    
    $this->q_report_header();
    
    $arr_gender = array();
    $this->SetFont('Arial','B','15');
    $this->Cell(340,8,'M O R B I D I T Y   D I S E A S E   R E P O R T',1,1,C);
    
    $this->SetFont('Arial','','8');
    $w = array(60,16,16,16,16,16,16,16,16,16,16,16,16,16,16,16,16,24);    
    $this->SetWidths($w);
    $label = array('DISEASE','ICD CODE','Under 1','1-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50-54','55-59','60-64','65&above','TOTAL');
    $this->Row($label);
    
    $w = array(60,16,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,12,12);        
    array_push($arr_gender,' ',' ');
    
    for($i=0;$i<16;$i++){
        array_push($arr_gender,'M','F');
    }
    
    $this->SetWidths($w);
    $this->Row($arr_gender);
    
    elseif($_SESSION[ques_no]==94): //header for TB summary table
        $this->SetFont('Arial','B','15');
        $this->Cell(340,8,'M O R B I D I T Y   D I S E A S E   R E P O R T',1,1,C);
    
        $this->SetFont('Arial','','8');
        $w = array(60,16,16,16,16,16,16,16,16,16,16,16,16,16,16,16,16,24);    
        $this->SetWidths($w);
        $label = array('DISEASE','ICD CODE','Under 1','1-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50-54','55-59','60-64','65&above','TOTAL');
        $this->Row($label);
    
        $w = array(60,16,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,8,12,12);        
        array_push($arr_gender,' ',' ');
    
        for($i=0;$i<16;$i++){
            array_push($arr_gender,'M','F');
        }
    
        $this->SetWidths($w);
        $this->Row($arr_gender);        
    
    else:
    
    endif;
    
    
    
}

function q_report_header(){
    
    $this->SetFont('Arial','B','12');
    $taon = $_SESSION[year];
    if($_SESSION[ques]==70):   //morbidity weekly report
        $freq = 'FHSIS REPORT FOR THE WEEK: ';
        $freq_val = $_SESSION[week];        
    elseif($_SESSION[ques]==71)://morbidity monthly report
        $freq = 'FHSIS REPORT FOR THE MONTH: ';
        $freq_val = date('F',mktime(0,0,0,$_SESSION[smonth],1,0));
    elseif($_SESSION[ques]==72):
        $freq = 'FHSIS REPORT FOR THE QUARTER: ';
        $freq_val = $_SESSION[quarter];
    elseif($_SESSION[ques]==73):
        $freq = 'FHSIS ANNUAL REPORT FOR THE YEAR: ';
        $freq_val = $_SESSION[year];
    else:    
    endif;
    
    $this->show_header_freq($freq,$freq_val);
    $this->show_header_bhs();
    $this->show_header_rhu();
    $this->show_header_lgu();
    $this->show_header_province();
    $this->Ln();
    
}

function show_header_freq($freq,$freq_val){
    if($_SESSION[ques]==73):
        $this->Cell(0,5,$freq.$freq_val."          YEAR: ".$_SESSION[year],0,1,L);            
    else:
        $this->Cell(0,5,$freq.$freq_val."          YEAR: ".$_SESSION[year],0,1,L);    
    endif;
}

function show_header_bhs(){    
    if($_SESSION[ques]==70 || $_SESSION[ques]==71):  //applies only to W-BHS and M2 reports
        $this->Cell(0,5,'NAME OF BHS/BHC - Brgy '.$this->get_brgy(),0,1,L);    
    endif;        
}

function show_header_rhu(){
    if($_SESSION[ques]==70 || $_SESSION[ques]==71):   //applies only to W-BHS and M2 reports
        $this->Cell(0,5,'CATCHMENT RHU/BHS: '.$_SESSION[datanode][name],0,1,L);        
    endif;
}

function show_header_lgu(){
    if($_SESSION[ques]==72 || $_SESSION[ques]==73): //applies only to Q2 and A2 reports
        $this->Cell(0,5,'MUNICIPALITY/CITY OF: '.$_SESSION[lgu],0,1,L);
    endif;
}

function show_header_province(){
    if($_SESSION[ques]==72 || $_SESSION[ques]==73): //applies only to Q2 and A2 reports
        $this->Cell(0,5,'PROVINCE: '.$_SESSION[province],0,1,L);
    endif;
}




function show_tb(){
    switch($_SESSION[ques]){
        case '90':
            $this->process_tb_symp();
            break;
            
        case '92':
            $this->process_tb_monthly();
            break;
            
        case '93':
            $this->process_tb_quarterly();
            break;
            
        default:
        
            break;    
    }            
}


function process_tb_symp(){}

function process_tb_monthly(){


}

function get_brgy(){  //returns the barangay is CSV format. to be used in WHERE clause for determining barangay residence of patient
    $arr_brgy = array();
     
    if(in_array('all',$_SESSION[brgy])):
        $q_brgy = mysql_query("SELECT barangay_id FROM m_lib_barangay ORDER by barangay_id ASC") or die("Cannot query 252". mysql_error());
        while(list($brgy_id) = mysql_fetch_array($q_brgy)){            
            array_push($arr_brgy,$brgy_id);
        }
    else:
        $arr_brgy = $_SESSION[brgy];
    endif;
    
    $str_brgy = implode(',',$arr_brgy);
    
    return $str_brgy;
        
}       

function sanitize_brgy(){
    if(func_num_args()>0):
        $args = func_get_args();
        $query = $args[0];
        $brgy = $args[1];        
        
    endif;
        
    $arr_count = array();
        
    
    if(mysql_num_rows($query)!=0): 
        while($r_query = mysql_fetch_array($query)){
            if($this->get_px_brgy($r_query[patient_id],$brgy)):
                array_push($arr_count,$r_query);
            endif;
        }
    endif;
    
    return $arr_count;
}


function get_px_brgy(){

        if(func_num_args()>0):
                $arg_list = func_get_args();
                $pxid = $arg_list[0];
                $str = $arg_list[1];
        endif;
        
        
	$q_px = mysql_query("SELECT a.barangay_id FROM m_family_address a, m_family_members b WHERE b.patient_id='$pxid' AND b.family_id=a.family_id AND a.barangay_id IN ($str)") or die("cannot query 389: ".mysql_error());
                
        if(mysql_num_rows($q_px)!=0):
                
                return 1;
        else:   
                return ;
        endif; 
}



function Footer(){
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,$this->PageNo().'/{nb}',0,0,'C');
} 



}

$pdf = new PDF('L','mm','Legal');

$pdf->AliasNbPages();
$pdf->SetFont('Arial','',10);

$pdf->AddPage();

$pdf->show_tb();

//$pdf->AddPage();
//$pdf->show_fp_summary();
$pdf->Output();

?>