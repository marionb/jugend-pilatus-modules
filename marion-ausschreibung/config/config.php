<?php
 
/**
 * Back end modules
 */
$GLOBALS['BE_MOD']['content']['ausschreibung'] = array(
	'tables' => array('tl_ausschreibung'),
	'icon'   => 'system/modules/marion-ausschreibung/html/checkmark.png'
);

/**
 * Definition eines Frontend Moduls
*/
array_insert($GLOBALS['FE_MOD']['miscellaneous'], 0, array
		(
				'AusschreibungList' => 'ModuleAusschreibungList',
				'AusschreibungListFull' => 'ModuleAusschreibungListFull'
		));