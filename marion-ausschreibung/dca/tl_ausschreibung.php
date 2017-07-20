<?php 
 
/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that
 * specializes in accessibility and generates W3C-compliant HTML code. It
 * provides a wide range of functionality to develop professional websites
 * including a built-in search engine, form generator, file and user manager,
 * CSS engine, multi-language support and many more. For more information and
 * additional TYPOlight applications like the TYPOlight MVC Framework please
 * visit the project website http://www.typolight.org.
 *
 * This is the data container array for table tl_ausschreibung.
 *
 * PHP version 5
 * @copyright  marion baumgartner
 * @author     marion baumgartner
 * @package    Ausschreibung
 * @license    GPL
 * @filesource
 */


/**
 * Table tl_ausschreibung
 */
$GLOBALS['TL_DCA']['tl_ausschreibung'] = array(

       // Config
       'config' => array(
              'dataContainer' => 'Table', //=> Tabel, File or Folder
              'enableVersioning' => true, //Erlaubt das anlegen einer neuen Version beim Speichern eines Datensatzes
			  /*
			   * Bestimmt die Konfiguration der Datenbank
			   */
              'sql' => array(
                     'keys' => array(
                            'id' => 'primary',
                     )
              )
       ),

       // List
       'list' => array(
              'sorting' => array(              		
                     'mode' 			=> 2, //Sortierung nach einem festen Feld
                     'fields'			=> array('titel', 'start_date', 'end_date', 'anmelde_schluss', 'ziel', 'route', 'teilnehmer', 'type', 'show_price'),
                     'flag' 			=> 5, //Sort by day ascending
                     'panelLayout' 		=> 'filter,sort;search,limit',
                     //'disableGrouping' 	=> true 
              ),
              'label' => array(
              		'fields'		=> array('titel', 'vorname_org', 'name_org', 'show_price'),
                    'showColumns'   => true,
              		//'maxCharacters' => 5
                    //'format' => '%s %s %s price: %s' //TODO
              ),
              'global_operations' => array( //Bearbeitungsfelder unterhalb der Filterfelder
                     'all' => array(
                            'label' => &$GLOBALS['TL_LANG']['MSC']['all'],
                            'href' => 'act=select',
                            'class' => 'header_edit_all',
                            'attributes' => 'onclick="Backend.getScrollOffset()"accesskey="e"'
                     )
              ),
              'operations' => array(
                     'edit' => array(
                            'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['edit'],
                            'href' => 'act=edit',
                            'icon' => 'edit.gif'
                     ),
                     'copy' => array(
                            'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['copy'],
                            'href' => 'act=copy',
                            'icon' => 'copy.gif'
                     ),
                     'delete' => array(
                            'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['delete'],
                            'href' => 'act=delete',
                            'icon' => 'delete.gif',
                            'attributes' => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"'
                     ),
                     'show' => array(
                            'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['show'],
                            'href' => 'act=show',
                            'icon' => 'show.gif'
                     ),
              )
       ),
       /*---------------Palettes-----------------*/
       'palettes' => array(
              '__selector__' => array(),
              'default' => '{Titel}, titel; {Zeit}, start_date, end_date, anmelde_schluss; {Tourenbeschrieb}, teaser, text, ziel, schwierigkeit, route, teilnehmer, beginner, type; {Angaben zum Organisator (Diese Person ist zustaendig fuer die Administration)}, vorname_org, name_org; {Leitung und Verantwortliche}, leiter_verantwortlich, leiter; {Detailangaben falls bereits bekannt}, treffpkt, rueckkehr, anforderung, verpflegung, material, anmeldung; {Kosten}, kosten, show_price; {Bilder hoch laden}, bilder',
       ),
       /*----------------Fields-------------------*/
       'fields' => array(
				'id' => array(
					'sql'           => "int(10) unsigned NOT NULL auto_increment"
				),
				'tstamp' => array(
					'sql'           => "int(10) unsigned NOT NULL default '0'"
				),
              	'titel' => array(
					'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['titel'],
					'exclude'                 => true, //blendet das feld fuer regulaere Nutzer aus
					'search'                  => true,
					'inputType'               => 'text',
					'eval'                    => array('maxlength'=>50, 'tl_class'=>'long', 'mandatory'=>'true'),
					'sql'                     => "varchar(50) NOT NULL default ''"
				),
				'start_date'				=> array(
                     'exclude' 				=> true,
                     'label' 				=> &$GLOBALS['TL_LANG']['tl_ausschreibung']['start_date'],
                     'inputType' 			=> 'text',
                     'search' 				=> true,
                     'sorting' 				=> true,
                     'eval' 				=> array(
                            'mandatory' 	=> true,
                            'datepicker' 	=> true,
                            'rgxp' 			=> 'date'
                     ),
					 'sql'					=> "int(10) unsigned NULL"
				),
				'end_date' => array(
                     'exclude' => true,
                     'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['end_date'],
                     'inputType' => 'text',
                     'search' => true,
                     'sorting' => true,
                     'eval' => array(
                            'mandatory' => false,
                            'datepicker' => true,
                            'rgxp' => 'date'
                     ),
					 'sql'					=> "int(10) unsigned NULL"
				),
				'anmelde_schluss' => array(
                     'exclude' => true,
                     'label' => &$GLOBALS['TL_LANG']['tl_ausschreibung']['anmelde_schluss'],
                     'inputType' => 'text',
                     'search' => true,
                     'sorting' => true,
                     'filter' 				  => true,
                     'eval' => array(
                            'mandatory' => true,
                            'datepicker' => true,
                            'rgxp' => 'date'
                     ),
					 'sql'					=> "int(10) unsigned NULL"
				),
				'teaser' => array(
					'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['teaser'],
					'exclude'                 => true,
					'search'                  => true,
					'inputType'               => 'textarea',
					'eval'                    => array(
							'rte'			  => 'tinyCustom',
							'maxlength'		  => 1000,
							'tl_class'		  =>'long',
							'mandatory'		  => true
							),
					'sql'                     => "text NOT NULL"
				),
       		    'text' => array(
       		    		'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['text'],
       		    		'exclude'                 => true,
       		    		'search'                  => false,
       		    		'inputType'               => 'textarea',
       		    		'eval'                    => array(
       		    				'rte'		=> 'tinyCustom',
       		    				'allowHtml'	=> false,
       		    				'tl_class'	=> 'long'
       		    		        ),
       		    		'sql'                     => 'text NULL'
       		    ),
				'type'  => array
				(
					'label'     => &$GLOBALS['TL_LANG']['tl_ausschreibung']['type'],
					'inputType' => 'select',
					'exclude'   => true,
					'sorting'   => true,
					'options'   => array('Skitour', 'Hochtour', 'Skihochtour', 'Klettern', 'Alpinklettern', 'Wandern', 'Plausch'),
					'eval'      => array(
						'includeBlankOption' => true,
						//'submitOnChange'     => true,
						'mandatory'          => true,
						'tl_class'           => 'w50'
					),
					'sql'       => "varchar(20) NOT NULL default ''"
				),
       		    'ziel' => array(
       		    		'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['ziel'],
       		    		'exclude'                 => true,
       		    		'search'                  => true,
       		    		'inputType'               => 'text',
       		    		'eval'                    => array(
       		    				'maxlength'		  => 100,
       		    				'tl_class'		  =>'long',
       		    				'mandatory'		  => true
       		    		),
       		    		'sql'                     => "varchar(100) NOT NULL default ''"
       		    ),
       		'schwierigkeit' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['schwierigkeit'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 100,
       						'tl_class'		  =>'long',
       						'mandatory'		  => true
       				),
       				'sql'                     => "varchar(100) NOT NULL default ''"
       		),
       		'route' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['route'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 500,
       						'tl_class'		  =>'long',
       						'mandatory'		  =>true
       				),
       				'sql'                     => "varchar(500) NOT NULL default ''"
       		),
       		'teilnehmer'  => array
       		(
       				'label'     => &$GLOBALS['TL_LANG']['tl_ausschreibung']['teilnehmer'],
       				'inputType' => 'checkbox',
       				'exclude'   => true,
       				'sorting'   => true,
       				//'flag'      => 1,
       				'options'   => array('JO', 'KiBe', 'FaBe', 'J+S Kids'),
       				//'reference' => &$GLOBALS['TL_LANG']['tl_ausschreibung'],
       				'eval'      => array(
       						'includeBlankOption' => false,
       						//'submitOnChange'     => true,
       						'mandatory'          => true,
       						'multiple'			 => true,
       						'size'				 => 4,
       						'fieldType' 		 => 'checkbox',
       						'tl_class'           => 'w50'
       				),
       				'sql'       => "blob NULL" //"varchar(30) NOT NULL default ''"
       		),
       		'name_org' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['name_org'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 50,
       						'tl_class'		  =>'long',
       						'mandatory'		  =>true
       				),
       				'sql'                     => "varchar(50) NOT NULL default ''"
       		),
       		'vorname_org' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['vorname_org'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 50,
       						'tl_class'		  =>'long',
       						'mandatory'		  =>true
       				),
       				'sql'                     => "varchar(50) NOT NULL default ''"
       		),
       		'leiter_verantwortlich' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['leiter_verantwortlich'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 50,
       						'tl_class'		  =>'long',
       						'mandatory'		  => true
       				),
       				'sql'                     => "varchar(50) NOT NULL default ''"
       		),
       		'leiter' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['leiter'],
       				'exclude'                 => true,
       				'search'                  => false,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'       => 200,
       						'lt_class'        => 'long',
       						'mandatory'       => false
       						),
       				'sql'                     => "varchar(200) NOT NULL default ''"
       		),
       		'treffpkt' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['treffpkt'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 100,
       						'tl_class'		  =>'long',
       						'mandatory'		  => false
       				),
       				'sql'                     => "varchar(100) NOT NULL default ''"
       		),
       		'rueckkehr' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['rueckkehr'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 100,
       						'tl_class'		  =>'long',
       						'mandatory'		  => false
       				),
       				'sql'                     => "varchar(100) NOT NULL default ''"
       		),
       		'verpflegung' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['verpflegung'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'textarea',
       				'eval'                    => array(
       						'rte'			  => 'tinyCustom',
       						'allowHtml'		  => false,
       						'maxlength'		  => 500,
       						'tl_class'		  =>'long',
       						'mandatory'		  => false
       				),
       				'sql'                     => "varchar(500) NOT NULL default ''"
       		),
       		'anforderung' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['anforderung'],
       				'exclude'                 => true,
       				'search'                  => true,
       				'inputType'               => 'text',
       				'eval'                    => array(
       						'maxlength'		  => 200,
       						'tl_class'		  =>'long',
       						'mandatory'		  => false
       				),
       				'sql'                     => "varchar(200) NOT NULL default ''"
       		),
       		'kosten' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['kosten'],
       				'exclude'                 => true,       				
       				'search'                  => false,
       				'inputType'               => 'textarea',
       				'eval'                    => array(
       						'rte'		=> 'tinyFlash',
       						'allowHtml'	=> false,
       						'maxlength' => 200,
       						'mandatory'	=> false,
       						'tl_class'	=> 'long'
       				),
       				'sql'                     => "varchar(200) NOT NULL default ''"
       		),
       		'material' => array(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['material'],
       				'exclude'                 => true,
       				'search'                  => false,
       				'inputType'               => 'textarea',
       				'eval'                    => array(
       						'rte'		=> 'tinyCustom',
       						'tl_class'	=> 'long',
       						'allowHtml'	=> false,
       						'decodeEntities'	=> true,
       						'maxlength' => 5000,
       						'mandatory'	=> false),
       				'default'				  =>
       				"****Anpassen und nicht gebrauchtes Material L&ouml;schen****<br/>"
       				.PHP_EOL.
       				"<br/>Kletterausr&uuml;stung:<br/>"
       				.PHP_EOL.
       				"Gst&auml;ltli*, Kletterfinken*, Magnesia, Helm*, 3 Schraubkarabiner*, Abseilger&auml;t*, Prusik*, Selbstsicherungsschlinge*, ev. Sandalen zum Sichern<br/>"
       				.PHP_EOL.
       				"wenn vorhanden: Expressschlingen, Seil, Bandschlingen, Friends und Keile<br/>"
       				.PHP_EOL.
       				"<br/>Hochtourenausr&uuml;stung:<br/>"
       				.PHP_EOL.
       				"Gst&auml;ltli*, Helm*, 3 Schraubkarabiner*, Steigeise*, Pickel*, Eisschrauben, Abseilger&auml;t*, Prusik*, Selbstsicherungsschlinge*, 3 Expressschlingen, Bandschlingen, einige Friends und Keile<br/>"
       				.PHP_EOL.
       				"<br/>Winter:<br/>"
       				.PHP_EOL.
       				"F&uuml;r Skifahrer: Tourenski (mit Harscheisen und angepassten Fellen), Skitourenschuhe, Skist&ouml;cke, Rucksack<br/>"
       				.PHP_EOL.
       				"F&uuml;r Snowboarder: Snowboard, Schneeschuhen, Rucksack mit Board-Befestigungsm&ouml;glichkeit, Teleskop-St&ouml;cke<br/>"
       				.PHP_EOL.
       				"F&uuml;r alle: LVS (Lawinenversch&uuml;tteten- Suchger&auml;t), Lawinenschaufel, Lawinensonde<br/>"
       				.PHP_EOL.
       				"<br/>pers&ouml;nliches Material:<br/>"
       				.PHP_EOL.
       				"gute und eingelaufene Berg- oder Wanderschuhe, Sonnencreme, -Brille und -Hut, Regenjacke, warme Kleider (Jacke (Fleece), Kappe und Handschuhe, Badesachen, SAC-Ausweis, H&uuml;ttenschlafsack, Stirnlampe, Toilettenartikel, pers. Medikamente, Oropax, Taschengeld f&uuml;r Extras in der H&uuml;tte, ev. Fotoapparat<br/>"
       				.PHP_EOL.
       				"<br/>Campingmaterial:<br/>"
       				.PHP_EOL.
       				"Schlafsack und M&auml;tteli, Zelt (bei der Anmeldung angeben), Teller, Becher und Besteck, Abtrocknungstuch",
       				'sql'                     => "text NOT NULL default ''"
       		),     		
			'anmeldung' => array(
					'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['anmeldung'],
					'exclude'                 => true,
       				'search'                  => false,
       				'inputType'               => 'textarea',
       				'eval'                    => array(
       						'rte'			  => 'tinyCustom',
       						'tl_class'        => 'long',
       						'allowHtml'		  => false,
       						'decodeEntities'  => true,
       						'mandatory'       => true),
       				'sql'                     => "text NOT NULL default ''"
       		),
       		'bilder' => array
       		(
       				'label'                   => &$GLOBALS['TL_LANG']['tl_ausschreibung']['bilder'],
       				'exclude'                 => true,
       				'inputType'               => 'fileTree',
       				'eval'                    => array('fieldType'=>'radio', 'files'=>true, 'filesOnly'=>true, 'extensions'=>$GLOBALS['TL_CONFIG']['validImageTypes']),
       				'sql'                     => "binary(16) NULL"
       		), 		
       		'beginner'  => array
       		(
       				'label'     => &$GLOBALS['TL_LANG']['tl_ausschreibung']['beginner'],
       				'inputType' => 'checkbox',
       				'exclude'   => true,
       				'sorting'   => true,
       				'search'    => true,
       				'eval'      => array(
       						'includeBlankOption' => false,
       						'mandatory'          => false,
       						'isBoolean'          => true,
       						'fieldType'          => 'checkbox'
       				),
       				'sql'       => "BOOLEAN NULL"
       		),
       		'show_price'=> array(
       				'label'					  => &$GLOBALS['TL_LANG']['tl_ausschreibung']['show_price'],
       				'exclude'				  => true,       				
       				'inputType' 			  => 'checkbox',
       				'sorting'   			  => true,
       				'eval'					  => array(
       						
       						'includeBlankOption'	=> false,
       						'mandatory'				=> false,
       						'isBoolean'				=> true,
       						'fieldType'				=> 'checkbox',
       				),
       				//'sql'       			  => "BOOLEAN NULL"//"tinyint default 0" //"varchar(30) NOT NULL default ''"
       		)
       )
);


/*callblack klasse*/

class tl_ausschreibung extends Backend
{

       public function __construct()
       {

              parent::__construct();
              $this->import('BackendUser', 'User');

              // datum to string 
              $sql = $this->Database->execute("SELECT * FROM tl_ausschreibung");
              while ($sql->next())
              {
                     if (strstr($sql->end_date, '.') && strstr($sql->start_date, '.'))
                     {
                            $start = mktime(0, 0, 0, substr($sql->start_date, 3, 2), substr($sql->start_date, 0, 2), substr($sql->start_date, 6, 4));
                            $end = mktime(0, 0, 0, substr($sql->end_date, 3, 2), substr($sql->end_date, 0, 2), substr($sql->end_date, 6, 4));
                            $set = array(
                                   "start_date" => $start,
                                   "end_date" => $end
                            );
                            $sqlUpd = $this->Database->prepare("UPDATE tl_ausschreibung %s WHERE id=?")->set($set)->execute($sql->id);
                     }

              }
       }

       public function stripTagsSaveCallback($feldwert)
       {

              $feldwert = str_replace(';', ',', $feldwert);
              return $feldwert;

       }


    

       //formatiert das Datum vom unixTimestamp in Y-m-d
       public function formatDate($var, DataContainer $dc)
       {

              $datum = date("Y-m-d", $var);
              return $datum;
       }

       public function hideEndDateWhenEmpty(DataContainer $dc)
       {

              //Wenn fuer das End-Datum nichts angegeben wird, wird dafuer automatisch das Start-Datum eingetragen
              $date = $this->Database->prepare("SELECT id, start_date FROM tl_ausschreibung WHERE start_date!='' AND end_date=''")->execute();
              while ($row = $date->next())
              {
                     $end_date = $this->Database->prepare("UPDATE tl_ausschreibung SET end_date = ? WHERE id = ?");
                     $end_date->execute($row->start_date, $row->id);
              }
              //Wenn end-datum leer ist, wird es ausgeblendet, das ist der Fall beim Erstellen neuer Anlaesse
              if ($dc->id != "" && $this->Input->get('mode') != 'csv_import')
              {

                     $date = $this->Database->prepare("SELECT start_date FROM tl_ausschreibung WHERE id = ?")->execute($dc->id);
                     $date->fetchAssoc();
                     if ($date->start_date == "")
                     {
                            $GLOBALS['TL_DCA']['tl_ausschreibung']['palettes']['default'] = 'start_date, art, ort, wettkampfform; zeit, trainer; kommentar; phase, trainingsstunden';
                     }
              }

       }
}
?>