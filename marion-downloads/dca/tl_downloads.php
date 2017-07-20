<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Table tl_downloads
 */
$GLOBALS['TL_DCA']['tl_downloads'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		),
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
			'mode'                    => 1,
			'fields'                  => array('title', 'sort_order'),
			'flag'                    => 11,
			'panelLayout'             => 'sort,search,limit'
		),
		'label' => array
		(
			'fields'                  => array('title'),
			'format'                  => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_downloads']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_downloads']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_downloads']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif',
				'attributes'          => 'style="margin-right:3px"'
			)
		)
	),

	// Palettes
	'palettes' => array
	(
		'default'                     => '{title_legend},title,description;{download_legend},href,type,sort_order'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_downloads']['title'],
			'inputType'               => 'text',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'search'                  => true,
			'eval'                    => array('mandatory'=>true, 'unique'=>true, 'decodeEntities'=>true, 'maxlength'=>255, 'tl_class'=>'long'),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
		'type'  => array
		(
					'label'     => &$GLOBALS['TL_LANG']['tl_downloads']['type'],
					'inputType' => 'radio',
					'exclude'   => true,
					'sorting'   => true,
					'options'   => array('Download', 'Foehn', 'Jahresprogram'),
					'eval'      => array(
							'includeBlankOption' => false,
							'mandatory'          => true,
							'multiple'			 => false,
							'size'				 => 2,
							'fieldType' 		 => 'radio',
							'tl_class'           => 'w50'
					),
					'sql'       => "blob NULL"
		),
		'description' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_downloads']['description'],
			'inputType'               => 'textarea',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 11,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false, 'decodeEntities'=>true, 'tl_class'=>'long', 'allowHtml' => true),
			'sql'                     => "text NULL"
		),
			'sort_order' => array
			(
					'label'                   => &$GLOBALS['TL_LANG']['tl_downloads']['sort_order'],
					'inputType'               => 'text',
					'exclude'                 => true,
					'sorting'                 => true,
					'flag'                    => 1,
					'search'                  => false,
					'eval'                    => array('mandatory'=>false),
					'sql'                     => "varchar(125) NOT NULL default '0'"
			),
        'count' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_downloads']['count'],
			'inputType'               => 'hidden',
			'exclude'                 => true,
			'sorting'                 => true,
			'flag'                    => 1,
			'search'                  => false,
			'eval'                    => array('mandatory'=>false),
			'sql'                     => "int(16) NOT NULL default '0'"
		),
		'href' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_downloads']['href'],
			'exclude'                 => true,
			'inputType'               => 'fileTree',
            'search'                  => true,
			'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['allowedDownload'], 'mandatory'=>true),
			'sql'                     => "binary(16) NULL",
		)
	)
);

