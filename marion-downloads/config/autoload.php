<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Modules
	'AjaxClassToCount'                 => 'system/modules/marion-downloads/modules/AjaxClassToCount.php',
	'Contao\ModuleFoehnAlle'           => 'system/modules/marion-downloads/modules/ModuleFoehnAlle.php',
	'Contao\ModuleJahresProgram'       => 'system/modules/marion-downloads/modules/ModuleJahresProgram.php',
	'Contao\ModuleJahresProgramArchiv' => 'system/modules/marion-downloads/modules/ModuleJahresProgramArchiv.php',
	'Contao\ModuleDownload'            => 'system/modules/marion-downloads/modules/ModuleDownload.php',
	'Contao\ModuleFoehnNewest'         => 'system/modules/marion-downloads/modules/ModuleFoehnNewest.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_download_foehn_alle'           => 'system/modules/marion-downloads/templates',
	'mod_download_jahresprogram'        => 'system/modules/marion-downloads/templates',
	'mod_download_jahresprogram_archiv' => 'system/modules/marion-downloads/templates',
	'mod_download_listing'              => 'system/modules/marion-downloads/templates',
	'mod_download_foehn_newest'         => 'system/modules/marion-downloads/templates',
	'mod_download_downloads'            => 'system/modules/marion-downloads/templates',
));
