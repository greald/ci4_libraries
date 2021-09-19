<?php namespace myApp\Libraries;

 // Name:    		Modeltable
 //
 // Created:  		2021-08-31
 //
 // Description:  	Generic abstract class to generate a table in database. To be extended by specific Model classes.
 // 
 //
 // Requirements: 	Codeigniter 4, PHP7.2 or above
 //
 // @package    	
 // @author     	Greald Henstra <greator@ghvernuft.nl>
 // @license    	use at will, and at your own risk
 // @link       	will be on Github one day
 // @filesource

abstract class Modeltable
{
    // Force Extending class to define this method
    abstract public function getTable();
    abstract public function getTableFields();
    abstract public function getPrimaryKey();

    // Common properties
    protected $already = FALSE;
    
    // Common methods
    public function tableSetUpOnce() 
    {        
		$table 			= $this->getTable();
		$tableFields 	= $this->getTableFields();
        $primaryKey 	= $this->getPrimaryKey(); 
        		
		$db = db_connect();
		if ($db->tableExists($table))
		{
		    $this->already = TRUE;
		    return "\n<br/>".__METHOD__.__LINE__."\n". $table . " already there.";
		}
		else
		{
			$forge = \Config\Database::forge();
			
			$forge	->addField($tableFields)
					->addPrimaryKey($primaryKey)
					->createTable($table, TRUE); // TRUE : CREATE TABLE IF NOT EXISTS table_name			
			
			$Qaincr = "ALTER TABLE `".$table.
				"` CHANGE `".$primaryKey.
				"` `".$primaryKey.
				"` ".$tableFields[$primaryKey]['type'].
				"(".
				$tableFields[$primaryKey]['constraint'].
				") UNSIGNED NOT NULL AUTO_INCREMENT; ";
			// echo "\n<br/>".__METHOD__.__LINE__."\n". $Qaincr;	
			return $db->query($Qaincr);		
		}
    }
}
