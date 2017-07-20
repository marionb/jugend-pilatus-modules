<?php
 
namespace Contao;
 
/**
 * Class ModuleAusschreibungList
 *
 * Front end module "cd list".
 */
class ModuleAusschreibungList extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_ausschreibunglist';
 
 
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['ausschreibung_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->date = $this->date;
            $objTemplate->href = 'contao/main.php?do=themes&table=tl_module&act=edit&id=' . $this->id;
 
            return $objTemplate->parse();
        }
 
        return parent::generate();
    }
 
 
    
    
    
    
    
    /**
     * Generate the module
     */
    protected function compile()
    {
        
    	$arrNextEvent = array();
    	$objAus = $this->Database->prepare("SELECT * FROM tl_ausschreibung WHERE start_date >= NOW() ORDER BY start_date")->limit(3)->execute(time());
    	
    	while ($objAus->next()) {
    		$arrNextEvent[] = array
    		(
    			'titel' 		=> $objAus->titel,
                'start_date' 	=> $this->datumswandler(date('Y-m-d', (int)$objAus->start_date)),
                'end_date' 		=> $this->datumswandler_checkZero($objAus->end_date),
                'anmelde_schluss' => $objAus->anmelde_schluss,
				'teaser' 		=> $objAus->teaser,
    		);
    	}
    	$this->Template->arrNextEvent = $arrNextEvent;
    	}
    	
    	public function datumswandler($Datum)
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
    	
    	public function datumswandler_checkZero($Datum)
    	{
    		if((int)$Datum == 0)
    		{
    			return false;
    		}
    		else {return $this->datumswandler(date('Y-m-d', (int)$Datum));}
    	}
            
}