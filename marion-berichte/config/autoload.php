<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'Contao\ModuleBerichtList'      => 'system/modules/marion-berichte/ModuleBerichtList.php',
	'Contao\ModuleBerichtListShort' => 'system/modules/marion-berichte/ModuleBerichtListShort.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_berichtlist'      => 'system/modules/marion-berichte/templates',
	'mod_berichtlistshort' => 'system/modules/marion-berichte/templates',
));
