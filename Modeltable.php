<?php namespace Prevald\Libraries;

 // Name:    		Prevald
 //
 // Created:  		2021-08-31
 //
 // Description:  	Generic abstract class to create a table in database. To be extended by specific classes.
 // 
 //
 // Requirements: 	PHP7.2 or above
 //
 // @package    	CodeIgniter4-Prevald
 // @author     	Greald Henstra <greator@ghvernuft.nl>
 // @license    	use at will, and at your own risk
 // @link       	will be on Github one day
 // @filesource

abstract class Modeltable
{
    // Force Extending class to define this method
    abstract protected function getTable();
    abstract protected function getTableFields();
    abstract protected function getPrimaryKey();

    // Common method
    public function tableSetUpOnce() 
    {        
		$table 			= $this->getTable();
		$tableFields 	= $this->getTableFields();
        $primaryKey 	= $this->getPrimaryKey(); 
        		
		$db = db_connect();
		if ($db->tableExists($table))
		{
		    return "\n<br/>".__METHOD__.__LINE__."\n". $table . " reeds aangetroffen.";
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