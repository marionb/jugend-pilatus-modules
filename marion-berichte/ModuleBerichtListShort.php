<?php
 
namespace Contao;
 
/**
 * Class ModuleAusschreibungList
 *
 * Front end module "bericht list".
 */
class ModuleBerichtListShort extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_berichtlistshort';
 
 
    /**
     * Display a wildcard in the back end
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');
 
            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['bericht_list'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
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
        
    	//die ganze Tabelle
    	$arrAus = array();
    	$objAus = $this->Database->execute("SELECT * FROM tl_bericht ORDER BY titel ASC");//TODO ORDER BY erfassungs datum
    	
    	while ($objAus->next()) {
            
    		$arrAus[] = array
    		(
    		    'id'=> $objAus->id,
    		    'title' => $objAus->titel,//todo check name
				'teaser' => $objAus->teaser,
                'text' => $objAus->text
    		);
    	}
    	if (TL_MODE == 'FE') {
    		$this->Template->fmdId = $this->id;
    		$this->Template->Berichte = $arrAus;
    	}
    }           
}