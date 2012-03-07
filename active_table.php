//<?php
//Abstract class ActiveTable{
//
//  // Database abstraction class for working with a whole table or a group of records
//  // The ActiveRecord class is a wrapper for a single database record.
//
//  // An array of ActiveRecords representing the currently selected database
//  // records.  Most accessor functions will either populate or return this
//  // array.
//
//  protected $selectedRecords = Array();
//  protected $tableName;
//  protected $idField;
//  protected $singleRecordClass;
//
//  protected $allowedFields = Array();
//  protected $requiredFields = Array();
//  protected $dbName;
//  protected $dbUser;
//  protected $dbPassword;
//  protected $dbHost;
//
//  public function __construct(){
//    // set the name of the single record class to the singular form
//    // of this class name
//    $this->singleRecordClass = Inflect::singularize(__CLASS__);
//  }
//
//  public function fetch($whereArgs, $options = Array()){
//    /* whereArgs is an associative array of arguments for the select query
//       returns a nested array of the ActiveRecords found.  If isArray is specified
//       the arguments are pushed to a function to generate a simple array.
//       whereArgs is structured as follows:
//       columnAlias => Array(
//       filterType => ColumnValue
//       );
//     *
//     * Acceptable filter types:
//     * 'LIKE'
//     * '>', '<', '<=', '>=', '='
//     * 'IN'
//     *
//     * Note: The AND conjunction is assumed
//     *
//     */
//
//    $defaultOptions = Array('recursive' => 2, 'isArray' => false, 'fields'=>Array('*'));
//    // combine user provided options with defaults, overriding defaults if user
//    // provides values for the same parameter
//    $options = merge_array($defaultOptions, $options);
//
//    if(!$options['isArray']){
//     return $this->fetchAsArray($whereArgs);
//    }
//    $dsn = "mysql:dbname={$this->dbName};host={$this->dbHost}";
//    $pdo = new PDO($dsn, $this->dbUser, $this->dbPassword);
//    if(is_array($whereArgs)){
//      // fetch a set of records based on the given arguments
//      $sql = "SELECT ";
//      $commaCount = count($options['fields']) - 1;
//      $loopCount = 0;
//      // Add fields requested to the select string
//      foreach($options['fields'] as $field){
//        $loopCount++;
//        $sql .= "$field";
//        if($loopCount > $commaCount){$sql .= ', ';}else{$sql .= ' ';}
//      }
//      $sql = 'WHERE ';
//      $parameters = Array();
//      foreach($whereArgs as $column -> $filterArray){
//        // for each column, append the appropriate filters
//        // to the query string
//        $x = count($filterArray)-1;
//        $y = 0;
//        foreach($filterArray as $type->$value){
//          $y++;
//          switch($type){
//            case 'IN':
//              $sql .= "$column IN(";
//              $i = count($val)++;
//              $j = 0;
//              foreach($value as $val){
//                $j++;
//                if($j>$i){$sql .= "?";}else{$sql .= "?, ";}
//                $parameters[] = $val;
//              }
//              $sql .= ")";
//            default:
//              $sql .= "$column $type ?";
//              $parameters[] = $value;
//          }
//          if($j<=$i){$sql .= " AND ";}
//        }
//        if($y<=$x){$sql .= " AND ";}
//      }
//    }else{
//      // Generate an error
//      $this->errors[] = "Argument provided for fetch must be an array; " . gettype($whereArgs) . " provided";
//      return false;
//    }
//    echo $sql;
//    $statement = $pdo->prepare($sql);
//    $statement->setFetchMode(PDO::FETCH_CLASS, $this->singleRecordClass);
//    // Populate the selectedRows array with ActiveRecords
//    while($row = $statement->fetch()){
//      $this->selectedRows[] = $row;
//    }
//    return $this->selectedRows;
//  }
//
//  private function fetchAsArray($whereArgs){
//
//  }
//
//  public function fetchAll(){
//    // returns an array containing all records
//  }
//
//}


?>
