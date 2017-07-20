<?php
namespace Contao;

class ModuleDownload
{
	/*
	  Takes a timestamp value and returens a string value of the following fromat: Week-Day,s DD. MM. YY
	 */
	protected static function datumswandler($Datum)
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
	
	/*
	 * Gets all of the Downloads from the DB
	 * Takes the Database object from the site -> if the class calling this functin inherits Module --> use $this->Database
	 * Returnes an array with all of the Download data from the DB
	 */
	public static function get_downloads($dataBase)
	{
		$arrNextDownloas = array();
		$objAus = $dataBase->execute("SELECT * FROM  tl_downloads WHERE (type = 'Foehn') ORDER BY tstamp DESC");
		while ($objAus->next()) {
			$var1;
			$objHref = null;
			if($objAus->href != '')
			{
				$objModel = \FilesModel::findByUuid($objAus->href);
				
				if($objModel === null) //Identical: $objAus is identical to Null even if the type of null is not the same as $objAus
				{
					if(!\Validator::isUuid($objAus->href))
					{
						$objHref = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
					}
				}
				elseif (is_file(TL_ROOT . '/' . $objModel->path))
				{
					
					$var1='passed if for path';
					$objHref = $objModel->path;
				}
			}
			
			$arrNextDownloas[] = array
			(
				'titel' 		=> $objAus->title,
				'type'			=> $objAus->type,
				'description'	=> $objAus->description,
				'href'			=> $objHref,
				'tstamp'		=> ModuleDownload::datumswandler(date('Y-m-d', (int)$objAus->tstamp)),
			);
		}
		return $arrNextDownloas;
	}
}
/**
 * Class ModuleFoehnAlle
 */
class ModuleFoehnAlle extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_download_foehn_alle';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		$arrNextDownloas = ModuleDownload::get_downloads($this->Database);
		
		if (TL_MODE == 'FE') {
			$this->Template->fmdId = $this->id;
			$this->Template->Ausschreibung = $arrNextDownloas;
		}
		$this->Template->arrNextDownloads = $arrNextDownloas;
	}
	
	
	
}