<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2015 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	'ModuleTile' => 'system/modules/marion-Tile-FE/ModuleTile.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_Tile' => 'system/modules/marion-Tile-FE/templates',
));
