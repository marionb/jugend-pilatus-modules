<?php
namespace Contao;

class ModuleDownloadNewest
{
	/*
	 * Gets all of the Downloads from the DB
	 * Takes the Database object from the site -> if the class calling this functin inherits Module --> use $this->Database
	 * Returnes an array with all of the Download data from the DB
	 */
	public static function get_downloads($dataBase)
	{
		$arrNextDownloas = array();
		$objAus = $dataBase->prepare("SELECT subject  FROM  tl_newsletter ORDER BY tstamp DESC")->limit(1)->execute(time());
		while ($objAus->next()) {

			$arrNextDownloas[] = array(
				'subject'	=> $objAus->subject,
                'href'      => self::create_slug($objAus->subject)
			);
		}
		return $arrNextDownloas;
	}

    private static function create_slug($string)
    {
        $string = str_replace('-', '', $string);
        $string = str_replace('  ', ' ', $string);
        $string = strtolower($string);
        $slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
}
/**
 * Class ModuleFoehnAlle
 */
class ModuleFoehnNewest extends Module
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_download_foehn_newest';

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
		$arrNextDownload = ModuleDownloadNewest::get_downloads($this->Database);

		if (TL_MODE == 'FE') {
			$this->Template->fmdId = $this->id;
			$this->Template->Ausschreibung = $arrNextDownload;
		}

		$this->Template->arrNextDownloads = $arrNextDownload;
	}
}
