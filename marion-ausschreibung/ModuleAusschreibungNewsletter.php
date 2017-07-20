<?php
 
namespace Contao;
 
/**
 * Class ModuleAusschreibungListFull
 *
 * Front end module "cd list".
 */
class ModuleAusschreibungListFull extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_ausschreibunglistfull';
    
    /**
     * Generate the module
     */
    protected function compile()
    {
    	//Determine the page on which the module is on
    	$current_page=$_SERVER['PHP_SELF'];
    	$berichte_page="berichte.html"; //TODO
    	$full_list;
    	$objAus;
    	 
    	if(strpos($current_page, $berichte_page) == false)
    	{
    		$objAus = $this->Database->prepare("SELECT * FROM tl_ausschreibung WHERE start_date >= UNIX_TIMESTAMP() ORDER BY start_date ASC")->limit(3)->execute(time());
    		$full_list = false;
    	}
    	else
    	{
    		$objAus = $this->Database->prepare("SELECT * FROM tl_ausschreibung ORDER BY start_date ASC")->execute(time());
    		$full_list = true;
    	}
    	    	
    	//Return if no Ausschreibungen were found
    	if(!$objAus-numRows){ return;}
    	
    	$arrAus = array();
    	
    	while ($objAus->next()) {
    		$objIMG = null;
    		$objIMGText = null;
    		if($objAus->bilder != '')
    		{
    			$objModel = \FilesModel::findByUuid($objAus->bilder);
    			
    			if($objModel === null) //Identical: $objAus is identical to Null even if the type of null is not the same as $objAus
    			{
    				if(!\Validator::isUuid($objAus->bilder))
    				{
    					$objIMGText = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
    				}
    			}
    			elseif (is_file(TL_ROOT . '/' . $objModel->path))
    			{
    				  				
    				$objIMG = $objModel->path;
    			}
    		}
    		
    		//Deciper the text of the cost
    		$costs = "Werden zu einem sp&auml;teren Zeitpukt bekannt gegeben.";
    		$interval = 0;
    		if($objAus->kosten != null )
    		{
    			if($objAus->end_date != 0)
    			{
    				$begin=new \DateTime();
    				$end = new \DateTime();
    				$begin->setTimestamp((int)$objAus->start_date);
    				$end->setTimestamp((int)$objAus->end_date);
    				
    				$interval = $begin->diff($end, true);
    				$interval = (int)$interval->days;
    			}
    			
    			if($interval <= 2 || $objAus->show_price)
    			{
    				$costs = $objAus->kosten;
    			}   			
    		}
    		
    		$arrAus[] = array
    		(
    			'titel'				=> $objAus->titel,
                'start_date'		=> $this->datumswandler(date('Y-m-d', (int)$objAus->start_date)),
                'end_date'			=> $this->datumswandler_checkZero($objAus->end_date),
                'anmelde_schluss'	=> $this->datumswandler(date('Y-m-d', (int)$objAus->anmelde_schluss)),
				'ziel'				=> $objAus->ziel,
    			'schwierigkeit'		=> $objAus->schwierigkeit,
    			'route'				=> $objAus->route,
    			'vorname_org'		=> $objAus->vorname_org,
    			'name_org'			=> $objAus->name_org,
    			'leiter_verantwortlich' => $objAus->leiter_verantwortlich,
    			'leiter' 			=> $objAus->leiter,
                'text' 				=> $objAus->text,
    			'teaser' 			=> $objAus->teaser,
    			'schwierigkeit' 	=> $objAus->schwierigkeit,
    			'route' 			=> $objAus->route,
    			'text' 				=> $objAus->text,
    			'treffpkt' 			=> $objAus->treffpkt, 
    			'rueckkehr' 		=> $objAus->rueckkehr, 
    			'verpflegung' 		=> $objAus->verpflegung,
    			'anforderung' 		=> $objAus->anforderung, 
    			'kosten' 			=> $costs, 
    			'material' 			=> $objAus->material,
    			'anmeldung' 		=> $objAus->anmeldung,
    			'bilder'			=> $objIMG,
    			'imgText'			=> $objIMGText,
    			'id'				=> $objAus->id,
    			'teilnehmer'		=> $this->get_RadiobuttonRes($objAus->teilnehmer)
    		);
    	}
    	if (TL_MODE == 'FE') {
    		$this->Template->fmdId = $this->id;
    		$this->Template->full_list = $full_list;
    		$this->Template->Ausschreibung = $arrAus;
    	} 
    }
    	
    	protected function datumswandler($Datum)
    	{
    	
    		$Tag = substr($Datum, 8, 2); //Nimmt die 2 Zeichen rechts des 8. Zeichens(=Zeichen 9 und 10)
    		$Monat = substr($Datum, 5, 2); //Nimmt die 2 Zeichen rechts des 5. Zeichens(=Zeichen 6 und 7)
    		$Jahr = substr($Datum, 0, 4); //Gibt die 4-stellige Jahreszahl z.B 2007)
    	
    		$WochentagEnglisch = date("l", mktime(0, 0, 0, $Monat, $Tag, $Jahr));
    	
    		$WochentagArray = array(
    				'Monday' => "Mo",
    				'Tuesday' => "Di",
    				'Wednesday' => "Mi",
    				'Thursday' => "Do",
    				'Friday' => "Fr",
    				'Saturday' => "Sa",
    				'Sunday' => "So"
    		);
    		$WochentagDeutsch = $WochentagArray[$WochentagEnglisch];
    	
    		$Jahr = substr($Datum, 2, 2); //Gibt die 2-stellige Jahreszahl z.B. "07")
    	
    		$Datum = $WochentagDeutsch . ', ' . $Tag . '.' . $Monat . '.' . $Jahr; //Haengt die Variablen zum fertigen Datum zusammen
    		return $Datum;
    	}
    	
    	protected function datumswandler_checkZero($Datum)
    	{
    		if((int)$Datum == 0)
    		{
    			return false;
    		}
    		else {return $this->datumswandler(date('Y-m-d', (int)$Datum));}
    	}
    	
    	/**
    	 * Resolve teilnehmer field
    	 */
    	protected function get_RadiobuttonRes($value)
    	{
    		$result = [];
    		if(is_null($value))
    		{
    			return NULL;
    		}    		
    		if (preg_match('/\bJO\b/',$value))
    		{
    			array_push($result, "JO");
    		}
    		if (preg_match("/\bKiBe\b/", $value))
    		{
    			array_push($result, "KiBe");
    		}
    		if (preg_match('/\bFaBe\b/', $value))
    		{
    			array_push($result, "FaBe");
    		}
    		if (preg_match('/\bKids\b/', $value))
    		{
    			array_push($result, "J+S Kids");
    		}
    		return $result;
    	}
            
}