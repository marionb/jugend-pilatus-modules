<?php
 
namespace Contao;
 
/**
 * Class ModuleAusschreibungList
 *
 * Front end module "bericht list".
 */
class ModuleBerichtList extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_berichtlist';
 
 
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
    	
    	$current_page=$_SERVER['PHP_SELF'];
    	$berichte_page="berichte.html";
    	$full_list;
    	
    	if(strpos($current_page, $berichte_page) == false)
    	{
    		$objAus = $this->Database->prepare("SELECT * FROM tl_bericht ORDER BY tstamp DESC")->limit(3)->execute(time());
    		$full_list = false;
    		
    	}
    	else 
    	{
    		$objAus = $this->Database->prepare("SELECT * FROM tl_bericht ORDER BY tstamp DESC")->execute(time());
    		$full_list = true;
    	}	
    	
    	while ($objAus->next()) {
    	    //retrieve image for overview
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
            
    		$arrAus[] = array
    		(
    		    'id'			=> $objAus->id,
    		    'title'			=> $objAus->titel,
                'image'			=> $objIMG,
				'teaser'		=> $objAus->teaser,
                'text'			=> $objAus->text,
    			'full_list'		=> $full_list
    		);
    	}
    	if (TL_MODE == 'FE') {
    		$this->Template->full_list=$full_list;
    		$this->Template->fmdId = $this->id;
    		$this->Template->Berichte = $arrAus;
    	}
    }           
}