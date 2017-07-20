<?php
 
namespace Contao;
 
/**
 * Class ModuleAusschreibungListFull
 *
 * Front end module "cd list".
 */
class ModuleAusschreibungListFull extends Module
{
 
    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_ausschreibunglistfull';
    
    public function generate()
    {
    	if ($_SERVER['REQUEST_METHOD']=="POST" && \Environment::get('isAjaxRequest')) {
    		$this->myGenerateAjax();
    		exit;
    	}
    	elseif ($_SERVER['REQUEST_METHOD']=="GET") {
    		$this->myGenerateAjax();
    		exit;
    	}
    	return parent::generate();
    }
    
    public function myGenerateAjax()
    {
    	// Ajax Requests verarbeiten
    	if(\Environment::get('isAjaxRequest')) {
    		header('Content-Type: application/json; charset=UTF-8');

    		$url_query_fields = ["date_newest" => "isOlder", "date_oldest" => "isYunger", "type" => "normal", "teilnehmer" => "like"];
    		$sql_where_clause= $this->GET_SQLWhere_query_builder($url_query_fields, false);
    		
    		if($sql_where_clause){
    			$sql = "SELECT * FROM tl_ausschreibung WHERE" . $sql_where_clause . "ORDER BY start_date ASC";
    			$objAus = $this->Database->prepare($sql)->execute(time());
    		}
    		else {
    			echo json_encode("there is no value");
    			exit;
    		}
    		
    		$arrAus []= $this->generate_data_array($objAus);
    		
    		if($arrAus)
    		    echo json_encode($arrAus);
    		else 
    			echo json_encode("there is no value");
    		exit;
    	}

    }
    
    /**
     * Generate the module
     */
    protected function compile()
    {
    	//Determine the page on which the module is on
    	$current_page=$_SERVER['PHP_SELF'];
    	$berichte_page="berichte.html"; //TODO this should not be set in the code
    	$BASE_URL ="http://$_SERVER[HTTP_HOST]".strtok($_SERVER['REQUEST_URI'],'?');
    	$full_list;
    	$objAus;
    	$objQuery;
    	$arrEventTypes = [];
    	
    	//retrieve the search query from the GET statement in the URL
    	$url_query_fields = ["date_newest" => "isOlder", "date_oldest" => "isYunger", "id" => "normal", "type" => "normal", "teilnehmer" => "like"];
    	$sql_where_clause= $this->GET_SQLWhere_query_builder($url_query_fields);
    	$sql_select_clause = "SELECT *";
    	$sql_from_clause = "FROM tl_ausschreibung";
    	if(strpos($current_page, $berichte_page) == true) //this is the page containing the whole Ausschreibungs list
    	{
    		if($sql_where_clause!== '')
    		{
    			$sql = "SELECT * FROM tl_ausschreibung WHERE" . $sql_where_clause . "ORDER BY start_date ASC";
    		}
    		else
    		{
    			$sql ="SELECT * FROM tl_ausschreibung ORDER BY start_date ASC";
    		}
    		$objAus = $this->run_query($sql, $this->Database);
    		$full_list = true;
    		
    	}
    	else //if this is NOT the page containing the whole Ausschreibungs list
    	{
    		$sql = "SELECT * FROM tl_ausschreibung WHERE start_date >= UNIX_TIMESTAMP() ORDER BY start_date ASC";
    		//$objAus = $this->run_query($sqltmp, $this->Database, 3); //TODO there seems to be a bug when calling the function like this
    		$objAus = $this->Database->prepare($sql)->limit(3)->execute(time());
    		$full_list = false;
    	}
    	
    	$typeSQL = "SELECT Distinct type FROM tl_ausschreibung";
    	$objQuery = $this->run_query($typeSQL, $this->Database);
    	//Externalize this
    	while($objQuery->next())
    	{
    		array_push($arrEventTypes,$objQuery->type);
    	}
    	
    	//Return if no Ausschreibungen were found
    	if(!$objAus->numRows){ return;}
    	
    	$arrAus = array();
    	
    	while ($objAus->next()) {
    		$objIMG = null;
    		$objIMGText = null;
    		if($objAus->bilder != '')
    		{
    			$objModel = \FilesModel::findByUuid($objAus->bilder);
    			
    			if($objModel === null) //Identical: $objAus is identical to Null even if the type of null is not the same as $objAus
    			{
    				if(!\Validator::isUuid($objAus->bilder))
    				{
    					$objIMGText = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
    				}
    			}
    			elseif (is_file(TL_ROOT . '/' . $objModel->path))
    			{
    				  				
    				$objIMG = $objModel->path;
    			}
    		}
    		
    		//Deciper the text of the cost
    		$costs = "Werden zu einem sp&auml;teren Zeitpukt bekannt gegeben.";
    		$interval = 0;
    		if($objAus->kosten != null )
    		{
    			if($objAus->end_date != 0)
    			{
    				$begin = new \DateTime();
    				$end = new \DateTime();
    				$begin->setTimestamp((int)$objAus->start_date);
    				$end->setTimestamp((int)$objAus->end_date);
    				
    				$interval = $begin->diff($end, true);
    				$interval = (int)$interval->days;
    			}
    			
    			if($interval <= 2 || $objAus->show_price)
    			{
    				$costs = $objAus->kosten;
    			}   			
    		}
    		
    		$arrAus[] = array
    		(
    			'titel'				=> $objAus->titel,
                'start_date'		=> $this->datumswandler(date('Y-m-d', (int)$objAus->start_date)),
                'end_date'			=> $this->datumswandler_checkZero($objAus->end_date),
                'anmelde_schluss'	=> $this->datumswandler(date('Y-m-d', (int)$objAus->anmelde_schluss)),
    			'show_anmelde_schluss'=> $this->print_anmelde_schluss((int)$objAus->anmelde_schluss, 168),
				'ziel'				=> $objAus->ziel,
    			'schwierigkeit'		=> $objAus->schwierigkeit,
    			'route'				=> $objAus->route,
    			'vorname_org'		=> $objAus->vorname_org,
    			'name_org'			=> $objAus->name_org,
    			'leiter_verantwortlich' => $objAus->leiter_verantwortlich,
    			'leiter' 			=> $objAus->leiter,
                'text' 				=> $objAus->text,
    			'teaser' 			=> $objAus->teaser,
    			'schwierigkeit' 	=> $objAus->schwierigkeit,
    			'type' 			    => $objAus->type,
    			'treffpkt' 			=> $objAus->treffpkt, 
    			'rueckkehr' 		=> $objAus->rueckkehr, 
    			'verpflegung' 		=> $objAus->verpflegung,
    			'anforderung' 		=> $objAus->anforderung, 
    			'kosten' 			=> $costs, 
    			'material' 			=> $objAus->material,
    			'anmeldung' 		=> $objAus->anmeldung,
    			'bilder'			=> $objIMG,
    			'imgText'			=> $objIMGText,
    			'id'				=> $objAus->id,
    			'URL'				=> $BASE_URL . "?id=" . $objAus->id,
    			'teilnehmer'		=> $this->get_RadiobuttonRes($objAus->teilnehmer)
    		);
    	}
    	if (TL_MODE == 'FE') {
    		$this->Template->fmdId = $this->id;
    		$this->Template->full_list = $full_list;
    		$this->Template->Ausschreibung = $arrAus;
    		$this->Template->EventTypes = array_unique($arrEventTypes);
    	}
    	if($arrAus)
    		echo json_encode($arrAus);
    	else
    		echo json_encode("there is no value");
    }
    	
    	protected function datumswandler($Datum)
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
    	
    	protected function datumswandler_checkZero($Datum)
    	{
    		if((int)$Datum == 0)
    		{
    			return false;
    		}
    		else {return $this->datumswandler(date('Y-m-d', (int)$Datum));}
    	}
    	
    	/**
    	 * Resolve teilnehmer field
    	 * @value	string value
    	 * @return	if $value contains JO, KiBe, FaBe or J&SKids it returnes that particular value in a string
    	 */
    	protected function get_RadiobuttonRes($value)
    	{
    		$result = [];//['JO'=>false, 'KiBe'=>false, 'Fabe'=>false, 'Kids'=>false];
    		if(is_null($value)) { return NULL; }    		
    		if (preg_match('/\bJO\b/',$value)) { array_push($result, 'JO'); }
    		if (preg_match('/\bKiBe\b/', $value)) { array_push($result, 'KiBe'); }
    		if (preg_match('/\bFaBe\b/', $value)) { array_push($result, 'FaBe'); }
    		if (preg_match('/\bKids\b/', $value)) { array_push($result, 'J+SKids'); }    		
    		return $result;
    	}
    	
    	/*
    	 * function returnes checks if the anmelde_schluss lies in a given time range from now
    	 * @param anmelde_schluss: timestamp of the anmelde_schluss
    	 * @param difference: time range to be considered from now
    	 * @param return: true if the anmelde_schluss is within the timerange else false. Dates thate ade in the past fom now are all false
    	 */
    	protected function print_anmelde_schluss($anmelde_schluss, $difference) {
    		if($anmelde_schluss < time()) { return false; }

    		$tmp = ($anmelde_schluss - time())/3600;
    		if($tmp <= $difference) {
    			$unit = "";
    			if($tmp < 24) {
    				$tmp = round($tmp);
    				if($tmp == 1) { $unit = " Stunde"; }
    				else { $unit = " Stunden"; }
    					
    				return $tmp . $unit;
    			} 
    			else
    			{
    				$tmp = round($tmp/24);
    				if($tmp == 1)
    				{
    					$unit = " Tag";
    				}
    				else
    				{
    					$unit = " Tagen";
    				}
    				return $tmp . $unit;
    			}
    		}
    		else return false;

    	}
    	
    	/*
    	 * TODO
    	 */
    	protected function SQL_query_builder($select, $from, $where = null)
    	{
    		$query = $select." ".$from;
    		$query = $query.($where)?" ".$where:"";
    	}
    	
    	/*
    	 * Search the GET/POST terms and build a wher clause for a sql query
    	 * @param $url_query_fields		an array of key value paires containg the allowed query terms that are searched for in the GET string
    	 * @param $get					if true the where clause is built on parameters of a GET request. Else the where clause is built for POST. 
    	 * @return 						a string containing the where clause from the GET param
    	 */
    	protected function GET_SQLWhere_query_builder($url_query_fields, $get = true)
    	{
    		$sql_where_clause = '';
    		foreach ($url_query_fields as $term => $value)
    		{
    			$GET_array = "";
    			
    			if($get)
    			{
    				//$url_query_fields[$term]= true;
    				//get an array of all the query results for one query terms (query results are comma separated)
    				$GET_array = ($_GET[$term] != NULL)? explode(',', $_GET[$term]): "";
    			}
    			else {
    				$GET_array = ($_POST[$term]!= NULL)? explode(',', $_POST[$term]): "";
    			}
    			
    			if($GET_array != "") {
    				    			
    				//generate an sql statement using the array above
    				$formated_sql = array();
    				foreach ($GET_array as $GET_result)
    				{
    					$queryColumn = $term;
    					//echo "-----".$url_query_fields[$term]."----";
    					//echo "bjhbj " . strcmp($url_query_fields[$term], 'isYunger');
    					if (strcmp($url_query_fields[$term], "like") === 0)
    					{
    						$where_equation = $this->like_query($queryColumn, $GET_result);
    					}
    					elseif (strcmp($url_query_fields[$term], "isOlder") === 0)
    					{
    						$queryColumn = "start_date";
    						$where_equation = $this->date_setter($queryColumn, $GET_result, true);
    					}
    					elseif (strcmp($url_query_fields[$term], "isYunger") === 0)
    					{
    						$queryColumn = "start_date";
    						$where_equation = $this->date_setter($queryColumn, $GET_result, false);
    					}
    					else
    					{
    						$where_equation = sprintf("%s = '%s'", mysql_escape_string($queryColumn), mysql_escape_string($GET_result));
    					}
    					array_push($formated_sql, $where_equation);
    		
    				}
    				if($sql_where_clause !== '')
    				{
    					$sql_where_clause .= ' AND ' . '(' . implode(' OR ',$formated_sql) . ')';
    				}
    				else $sql_where_clause = '(' . implode(' OR ',$formated_sql) . ')';
    			}
    		}
    		return $sql_where_clause;
    	}
    	
    	protected function like_query($column, $GET_result)
    	{
    		return sprintf("%s LIKE '%%%s%%'", mysql_escape_string($column), $GET_result);
    	}
    	
    	/*
    	 * Create query when a time/date limit is given
    	 * @column		DB column on which the query is done
    	 * @Get_result	the get parameter from the DB
    	 * @isOlder		determines wether the returned DB results are older or younger thatn the given date
    	 * @return		returns a string containing the where clause from the date query in the Get string
    	 */
    	protected function date_setter($column, $Get_result, $isOlder)
    	{
    		$timestamp = strtotime($Get_result);
    		$compare = ($isOlder)?'>=':'<=';
    		$tmp = sprintf("%s %s '%s'", $column, $compare , $timestamp);
    		return $tmp;
    	}
    	
    	/*
    	 * @sql_query	string containing the sql query to be executed
    	 * @database	database connection to execute the query
    	 * @limit		limit the amount of results returned: default = false
    	 * @return		returns the query result
    	 */
    	private function run_query($sql_query, $database, $limit=false)
    	{
    		if(!$database){
    			echo "no DB given!!!";
    			return 0;
    		}
    		if($limit)
    		{
    			return $database->prepare($sql_query)->limit($limit)->execute(time());
    		}
    		return $database->prepare($sql_query)->execute(time());
    	}
    	
    	/*
    	 * generate an array that can be used in the html template with JS from the DB data
    	 * @param {} dataObj the data object that was returned by the DB query
    	 */
        private function generate_data_array($dataObj) {
        	if(!$dataObj->numRows){ return;}
        	 
        	$arrObj = array();
        	 
        	while ($dataObj->next()) {
        		$objIMG = null;
        		$objIMGText = null;
        		
        		//TODO: Place this in a separate function for better readability --> $this->getImage()
        		if($dataObj->bilder != '') {
        			$objModel = \FilesModel::findByUuid($dataObj->bilder);
        			 
        			if($objModel === null) {
        				if(!\Validator::isUuid($dataObj->bilder)) {
        					$objIMGText = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
        				}
        			} elseif (is_file(TL_ROOT . '/' . $objModel->path)) {
        				$objIMG = $objModel->path;
        			}
        		}
                //TODO: Test this function
        		$cost = $this->get_costs($dataObj->show_price, $dataObj->start_date, $dataObj->end_date, $dataObj->kosten);

        		$arrObj[] = array
        		(
        				'titel'					=> $dataObj->titel,
						'date'					=> $this->render_date($dataObj->start_date, $dataObj->end_date),
        				'anmelde_schluss'		=> $this->datumswandler(date('Y-m-d', (int)$dataObj->anmelde_schluss)),
        				'show_anmelde_schluss'	=> $this->print_anmelde_schluss((int)$dataObj->anmelde_schluss, 168),
        				'ziel'					=> $dataObj->ziel,
        				'schwierigkeit'			=> $dataObj->schwierigkeit,
        				'route'					=> $dataObj->route,
        				'vorname_org'			=> $dataObj->vorname_org,
        				'name_org'				=> $dataObj->name_org,
        				'leiter_verantwortlich' => $dataObj->leiter_verantwortlich,
        				'leiter' 				=> $dataObj->leiter,
        				'text' 					=> $dataObj->text,
        				'teaser' 				=> $dataObj->teaser,
        				'schwierigkeit'		 	=> $dataObj->schwierigkeit,
        				'type' 			   		=> $dataObj->type,
        				'treffpkt' 				=> $dataObj->treffpkt,
        				'rueckkehr' 			=> $dataObj->rueckkehr,
        				'verpflegung' 			=> $dataObj->verpflegung,
        				'anforderung' 			=> $dataObj->anforderung,
        				'kosten' 				=> $cost,
        				'material' 				=> $dataObj->material,
        				'anmeldung' 			=> $dataObj->anmeldung,
        				'bilder'				=> $objIMG,
        				'imgText'				=> $objIMGText,
        				'id'					=> $dataObj->id,
        				'URL'					=> $BASE_URL . "?id=" . $dataObj->id,
        				'teilnehmer'			=> $this->get_RadiobuttonRes($dataObj->teilnehmer)
        		);        	
        	}
        	return $arrObj;
        	
        }
        
        /**
         * render the date start + end
         * @param {date} start_date The starting date of the Event
         * @param {date|null} end_date The ending date of the Event
         */
        private function render_date($start_date, $end_date) {
        	$start = $this->datumswandler(date('Y-m-d', (int)$start_date));
        	$end = $this->datumswandler_checkZero($end_date);
       		$textDate = ($end !== false)? " bis " . $end : "";
       		return $start . $textDate;

        }
        
        /**
         * Get Images TODO
         */
        /*private function getImage() {
        	//TODO
        }*/
        
        
        /**
         * Deciper the text for the cost.
         * @param {bool} showCost True if costs of an Event are free to show
         * @param {int} beginnDate Starting date of the Event
         * @param {int=} endDate Ending date of the Event. If there is no end date the Event is assumed to be only one Day
         * @param {int=} costs The costs of the event. Can be null if no cost is given
         * @return {string|int} If the cost is not validated or not available a string with an apropriate text is returned. Othervies an int with the cost of the Event
         */
        private function get_costs($showCost, $beginnDate, $endDate = null, $costs = null) {
        	$showCostsLater = "Werden zu einem sp&auml;teren Zeitpukt bekannt gegeben.";
        	$interval = 0;
        	
        	//nothing to be shown so returne right away
        	if($costs === null) {
        		return $showCostsLater;
        	}
        	
        	if(endDate !== null) {
        		$begin = new \DateTime();
        		$end = new \DateTime();
        		$begin->setTimestamp((int) $beginnDate);
        		$end->setTimestamp((int) $endDate);
        		$interval = $begin->diff($end, true);
        		$interval = (int)$interval->days;
        	}
        	
        	if($interval <= 2 || $showCost){
        		return $costs;
        	} else {return $showCostsLater;}
        }
}