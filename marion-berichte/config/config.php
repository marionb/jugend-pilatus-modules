<?php
 
/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['bericht'] = array(
	'tables' => array('tl_bericht'),
	'icon'   => 'system/modules/marion-berichte/html/checkmark.png'
);

/**
 * Definition eines Frontend Moduls
*/
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
		(
				'BerichtList' 			=> 'ModuleBerichtList',
				'BerichtListShort'		=> 'ModuleBerichtListShort'
		));