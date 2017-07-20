<?php

class ModuleTile extends Module
{
  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'mod_Tile';
  
  public function generate()
  {
	return parent::generate();
  }
	
  protected function compile()
  {
  	
  	$href [] = array 
  	(
			'foehn'		=> 'http://100-jahre.jugend-pilatus.ch',
  			'touren' 	=> 'index.php/ausschreibungen.html',
  			'bericht'	=> 'index.php/berichte.html',
  			'portrait'	=> 'index.php/PortraitKontakt.html',
  	);
    $this->Template->href = $href;
  }
}


?>
