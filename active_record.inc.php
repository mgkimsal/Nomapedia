<?php

require_once('inflect.inc.php');
require_once('Inspekt.php');

class ActiveRecord {

  // Fields arrays define all fields (allowed_fields) and those that are required
  // to insert or update a record (required_fields).  They are formatted as an
  // associative array: $column_name_in_table=>$columnAliasForObject
  // all column properties except the primary key are publically accessible
  // but the validate() method is called before any CRUD operation to make sure
  // that the assigned values are valid for the database table
  protected $allowedFields = Array();
  protected $requiredFields = Array();
  protected $dbName = 'nomapedia';
  protected $dbUser = 'root';
  protected $dbPassword = 'root';
  protected $dbHost = 'localhost';
  protected $dbDriver = 'mysql';
  protected $createdField = 'dateCreated';
  protected $updatedField = 'dateUpdated';
  protected $dateTimeFormat = 'Y-m-d G:i:s';
  // idField defines the name of the primary key field
  protected $idField = 'id';
  // tableName defines the name of the table associated with the object
  protected $tableName;
  // arrays define the relations this object has with others:
  // hasMany defines which objects contain a foreign key to this object
  // e.g. if a User hasMany recipes then the recipe table contains a
  // recipe_id field
  protected $hasMany = Array();
  // belongsTo defines objects which contain a foreign key referencing another
  // object.  e.g. a Recipe belongs to a User because the Recipe table
  // contains a user_id field
  protected $belongsTo = Array();
  // has_one defines objects on the primary key side of a one-to-one relationship
  protected $hasOne = Array();
  // hasAndBelongsToMany defines objects with which this object has a many-to-many
  // relationship
  protected $hasAndBelongsToMany = Array();
  /* the validates array defines the set of validations to be performed on the 
   * class data before any CRUD operations are performed.  
   * 
   * Use as a wrapper layer for standard php filters when possible
   * 
   * -------------------------------------------
   * NOTE: 
   *      These validations are only a single layer of security and should be mirrored
   *      by DB-level validations if possible!
   * -------------------------------------------
   * the array is structered as follows:
   *  fieldName => 
   *      validationType => 
   *        value(boolean) OR
   *        nonDefaultMessage(optionsl),
   *        additionalOptions(options)
   *                
   * validationTypes:
   *  - size
   *    - additional options:
   *      maximum
   *      minimum
   *      equals
   *  - exists
   *    - true/false
   *  - isDate
   *    - true/false or additionalOptions
   *      - regex or dateTime function to check or force date format
   *  - isAlphaNumeric
   *    - true/false
   *  - isNumeric
   *    - true/false
   *  - isInteger
   *    - true/false
   *  - isEmail
   *    - true/false
   *  - isRegex
   *    - regexString:  checks the inputted value against a regex string and 
   *                    returns true on a match
   *  - isPassword
   *    - special case of isRegex to check for a validly formatted password
   *  - comparison
   *    matches values, as opposed to lengths as with size
   *    - >=, <=, <, >, =, !=, etc
   *  - between
   *    - checks that a value is between two other values, either numeric
   *      or alphabetically ordered characters
   *    - array containing the two values 
   * 
   * 
   */
  protected $validates = array();

  public function __construct($id = 0, $options = array()) {
    /*  the $id variable is used to retrieve a matching db record
     *  $options acceptable values:
     *  recursion => default 1
     *  asArray => defaault true
     */

    $defaultConstructOptions = array(
        'recursion' => 1,
        'asArray' => true
    );
    // merge the given options with the default options
    $options = array_merge($defaultConstructOptions, $options);
    $this->allowedFields = array_merge($this->allowedFields, array($this->createdField =>
            $this->createdField, $this->updatedField => $this->updatedField));

    // Set the table name to the plural form of the class name
    if (is_null($this->tableName)) {
      $this->tableName = Inflect::pluralize(lcfirst(get_class($this)));
    }

    if ($id == 0) {
      // If new record, initialize all elements of the allowedFields array
      // as class properties
      foreach ($this->allowedFields as $fieldName => $propertyName) {
        $this->$propertyName = null;
      }
    } else {
      // If existing record query the database and populate this object's
      // properties with the values
      $tempObject = $this->fetch(
                      array(
                          $this->idField => array(
                              '=' => $id
                          )
                      ), array(
                  'recursion' => $options['recursion'],
                  'asArray' => $options['asArray']
                      )
      );
//      echo '<pre>';
//       var_dump($tempObject);
//      echo '</pre>';
      if ($options['asArray']) {
        foreach ($this->allowedFields as $fieldName => $fieldAlias) {
          $this->$fieldAlias = $tempObject[0][$fieldAlias];
        }
      } else {
        foreach ($this->allowedFields as $fieldName => $fieldAlias) {
          $this->$fieldAlias = $tempObject[0]->$fieldAlias;
        }
      }
    }
  }

  public function create() {
    // Adds a new record to the database table and sets the id property
    // of the instantiated object
    try {
      if ($this->validate(array($this->idField, 'dateCreated'))) {
        // insert new record with column values matching this object's
        // properties
        $pdo = $this->getConnection();
        $sql = "INSERT INTO $this->tableName (";
        $valString = '';
        $parameters = array();
        $x = count($this->allowedFields);
        $y = 0;
        foreach ($this->allowedFields as $fieldName => $fieldAlias) {
          $y++;
          if ($fieldAlias == $this->idField OR $fieldAlias == $this->createdField OR $fieldAlias == $this->updatedField) {
            continue;
          }
            $sql .= "$fieldName, ";
            $valString .= "?, ";
            $parameters[] = $this->$fieldAlias;
        }
        $valString .= "?, ?";
        $sql .= "{$this->createdField}, {$this->updatedField}) VALUES ($valString)";
        $date = date($this->dateTimeFormat);
        $parameters[] = $date;
        $parameters[] = $date;
        echo $sql;
        $statement = $pdo->prepare($sql);

        $pdo->beginTransaction();
        if ($statement->execute($parameters)) {
          $this->{$this->idField} = $pdo->lastInsertId();
          $pdo->commit();
          return true;
        } else {
          $this->errors[] = $statement->errInfo();
          $pdo->rollback();
          return false;
        }
      } else {
        $this->errors[] = 'Could not insert new record. Validation failed';
        return false;
      }
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  public function update() {
    try {
      if ($this->validate()) {

        $pdo = $this->getConnection();
        $sql = "UPDATE $this->tableName SET ";
        $parameters = array();
        $x = count($this->allowedFields);
        $y = 0;
        foreach ($this->allowedFields as $fieldName => $fieldAlias) {
          $y++;
          if ($fieldAlias == $this->idField) {
            continue;
          }
          if ($y < $x) {
            $sql .= "$fieldName = ?, ";
            $parameters[] = $this->$fieldAlias;
          } else {
            $sql .= "$fieldName = ?, {$this->updatedField} = ?";
            $parameters[] = $this->$fieldAlias;
            $date = date($this->dateTimeFormat);
            $parameters[] = $date;
            $this->{$this->updatedField} = $date;
          }
        }
        $sql .= " WHERE {$this->idField} = ?";
        $parameters[] = $this->{$this->idField};
        echo $sql;
        $statement = $pdo->prepare($sql);

        $pdo->beginTransaction();
        if ($statement->execute($parameters)) {
          $this->{$this->idField} = $pdo->lastInsertId();
          $pdo->commit();
          return true;
        } else {
          $this->errors[] = $statement->errInfo();
          $pdo->rollback();
          return false;
        }
      } else {
        $this->errors[] = 'Could not update record. Validation failed';
        return false;
      }
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  public function delete($id = 0) {
    try {
      $pdo = $this->getConnection();
      $id = ($id == 0) ? $this->{$this->allowedFields[$this->idField]} : $id;
      // insert new record with column values matching this object's
      // properties

      $sql = "DELETE FROM {$this->tableName} WHERE {$this->idField} = ?";
      $parameters = array();
      $parameters[] = $id;
      echo $sql;
      $statement = $pdo->prepare($sql);
      $pdo->beginTransaction();
      if ($statement->execute($parameters)) {
        $pdo->commit();
        unset($this);
        return true;
      } else {
        $this->errors[] = $statement->errInfo();
        $pdo->rollback();
        return false;
      }
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  public function validate($exceptions = array()) {
    try {
      // iterate through each field and check the corresponding validation rules
      // in the validates array
      $isValid = true;
      foreach ($this->validates as $fieldName => $validationRule) {
        $value = $this->$fieldName;
        if (in_array($fieldName, $exceptions)) {
          continue;
        }
        if (array_key_exists('rule', $validationRule)) {
          // iterate or call recursively
          $isValid = $this->validateRule($fieldName, $validationRule) ? $isValid : false;
        } else {
          foreach ($validationRule as $validation) {
            $isValid = $this->validateRule($fieldName, $validation) ? $isValid : false;
          }
        }
      }

      return $isValid;
    } catch (Exception $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  public function fetch($whereArgs = null, $options = array()) {
    /* whereArgs is an associative array of arguments for the select query
      returns a nested array of the ActiveRecords found.  If isArray is specified
      the arguments are pushed to a function to generate a simple array.
      whereArgs is structured as follows:
      columnAlias => Array(
      filterType => ColumnValue
      );
     *
     * Acceptable filter types:
     * 'LIKE'
     * '>', '<', '<=', '>=', '='
     * 'IN'
     *
     * Note: The AND conjunction is assumed
     *
     */
    try {
      $parameters = Array();
      $defaultOptions = Array('recursion' => 2, 'asArray' => false, 'fields' => Array('*'));
      // combine user provided options with defaults, overriding defaults if user
      // provides values for the same parameter
      $options = array_merge($defaultOptions, $options);
      $recursion = $options['recursion'];
//    echo '<pre>';
//    print_r($defaultOptions);
//    print_r($options);
//    echo '</pre>';

      $dsn = "mysql:dbname={$this->dbName};host={$this->dbHost}";
      $pdo = new PDO($dsn, $this->dbUser, $this->dbPassword);

      // fetch a set of records based on the given arguments
      $sql = "SELECT ";
      $commaCount = count($options['fields']) - 1;
      $loopCount = 0;
      // Add fields requested to the select string
      foreach ($options['fields'] as $field) {
        $loopCount++;
        $sql .= "$field";
        if ($commaCount > $loopCount) {
          $sql .= ', ';
        } else {
          $sql .= ' ';
        }
      }
      $sql .= "FROM {$this->tableName}";

      if ($options['habtmJoin']) {
        foreach ($options['habtmJoin'] as $classReferenced => $joinTable) {
          $sql .= " JOIN $joinTable ON {$this->tableName}.{$this->idField} = $joinTable." . Inflect::singularize($this->tableName) . 'Id ';
        }
      }
      if (is_array($whereArgs)) {
//      echo '<pre>';
//      print_r($whereArgs);
//      echo '</pre>';
        $sql .= ' WHERE ';
        $x = count($whereArgs) - 1;
        $y = 0;
        foreach ($whereArgs as $column => $filter) {
          // for each column, append the appropriate filters
          // to the query string

          $y++;
          $a = count($filter) - 1;
          $b = 0;
          foreach ($filter as $type => $value) {
            // for each filter, check the type and append accordingly
            // if 'IN', iterate through the 'IN' array and populate the
            // IN() structure
            $b++;
            switch ($type) {
              case 'IN':
                $sql .= "$column IN(";
                $i = count($value) - 1;
                $j = 0;
                foreach ($value as $val) {
                  $j++;
                  if ($j > $i) {
                    $sql .= "?";
                  } else {
                    $sql .= "?, ";
                  }
                  $parameters[] = $val;
                }
                $sql .= ")";
                break;
              default:
                $sql .= "$column $type ?";
                $parameters[] = $value;
            }
            if ($b <= $a) {
              // if this is not the last filter for this column
              // append an AND before the next filter
              $sql .= ' AND ';
            }
          }

          if ($y <= $x) {
            // If this is the last column to be filtered, append an AND
            // before the next.
            $sql .= " AND ";
          }
        }
      }

//    echo $sql . ";<br/>";
      $statement = $pdo->prepare($sql);
      $statement->execute($parameters);
      if ($options['asArray']) {
        $selectedRows = $this->fetchAsArray($statement, $options);
      } else {
        $selectedRows = $this->fetchAsObject($statement, $options);
        //$statement->setFetchMode(PDO::FETCH_CLASS, get_class($this));
      }
      return $selectedRows;
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  private function fetchAsArray($statement, $options) {
    try {
      $recursion = $options['recursion'];
      $statement->setFetchMode(PDO::FETCH_ASSOC);
      $selectedRows = array();
      while ($row = $statement->fetch()) {
        // remove extraneous field names from join tables
        foreach ($row as $key => $value) {
          $thisClassField = Inflect::singularize($this->tableName) . 'Id';
          if ($key == $thisClassField) {
            $row['id'] = $row[$key];
            unset($row[$key]);
          }
          foreach ($this->hasAndBelongsToMany as $classReferenced => $joinTable) {
            $refClassField = Inflect::singularize(lcFirst($classReferenced)) . 'Id';
            if (isset($row[$refClassField])) {
              unset($row[$refClassField]);
            }
          }
        }

        // check if any recursive fetches are to be performed
        if ($recursion > 0) {
          // iterate through each row and check to see if it is a foreign key
          // referencing another table(is in the belongsTo array).
          // If it is append an array element with index [pluralClass]
          // which contains an with the values of the referenced record by recursively
          // calling this function and decrementing the 'recursion' option by 1
          foreach ($row as $key => $value) {
            // if the field is a foreign key to another table, fetch the record
            // referenced and append to the output array
            // this relies on the naming convention: singularizedForeignTableNameId
            // for the foreign key field


            if (in_array(ucfirst(str_replace('Id', '', $key)), $this->belongsTo)) {
              // instantiate an object of the proper class
              // and calls the fetch method again, incrementing the recursion level
              // down by one and appending the result returned to the column element
              $className = ucfirst(str_replace('Id', '', $key));
              $referencedClass = new $className;
              $row[str_replace('Id', '', $key)] = $referencedClass->fetch(array(
                          'id' => array(
                              '=' => $value
                          )
                              ), array(
                          'recursion' => $recursion - 1,
                          'asArray' => true,
                          'fields' => Array('*')
                      ));
            }
          }
          foreach ($this->hasAndBelongsToMany as $referencedClass => $joinTableName) {
            //
//          echo "Referenced Class:" . $referencedClass;
            $refClass = new $referencedClass;
            $thisTableKey = Inflect::singularize($this->tableName) . 'Id';
            $row[Inflect::pluralize(lcfirst($referencedClass))] = $refClass->fetch(array(
                        $thisTableKey => array(
                            '=' => $row[$this->idField]
                            )), array(
                        'recursion' => $recursion - 1,
                        'asArray' => true,
                        'fields' => Array('*'),
                        'habtmJoin' => array(__CLASS__ => $joinTableName)
                            )
            );
          }


          foreach ($this->hasMany as $referencingClass) {
            // instantiates an object of the class referenced by
            // and queries the class using fetch to return all matching records
            // for this object
            $className = ucfirst(str_replace('Id', '', $key));
            $refClass = new $referencingClass;
            $referencedTableKey = Inflect::singularize(lcfirst($this->tableName)) . 'Id';
            $row[Inflect::pluralize(lcfirst($referencingClass))] = $refClass->fetch(array(
                        $referencedTableKey => array(
                            '=' => $row[$this->idField]
                            )), array(
                        'recursion' => $recursion - 1,
                        'asArray' => true,
                        'fields' => Array('*')
                            )
            );
          }
        }

        $selectedRows[] = $row;
      }
      return $selectedRows;
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  private function fetchAsObject($statement, $options) {
    try {
      $recursion = $options['recursion'];
      $statement->setFetchMode(PDO::FETCH_OBJ);
      $selectedObjects = array();
      while ($row = $statement->fetch()) {
        foreach ($row as $key => $value) {
          $thisClassField = Inflect::singularize($this->tableName) . 'Id';
          if ($key == $thisClassField) {
            $row->id = $row->$key;
            unset($row->$key);
          }
          foreach ($this->hasAndBelongsToMany as $classReferenced => $joinTable) {
            $refClassField = Inflect::singularize(lcFirst($classReferenced)) . 'Id';
            if (isset($row->$refClassField)) {
              unset($row->$refClassField);
            }
          }
        }
        // check if any recursive fetches are to be performed
        if ($recursion > 0) {
          // iterate through each row and check to see if it is a foreign key
          // referencing another table(is in the belongsTo array).
          // If it is append an array element with index [pluralClass]
          // which contains an with the values of the referenced record by recursively
          // calling this function and decrementing the 'recursion' option by 1
          foreach ($row as $key => $value) {
            // if the field is a foreign key to another table, fetch the record
            // referenced and append to the output array
            // this relies on the naming convention: singularizedForeignTableNameId
            // for the foreign key field
            if (in_array(ucfirst(str_replace('Id', '', $key)), $this->belongsTo)) {
              // instantiate an object of the proper class
              // and calls the fetch method again, incrementing the recursion level
              // down by one and appending the result returned to the column element
              $className = ucfirst(str_replace('Id', '', $key));
              $referencedClass = new $className;
              $keyField = Inflect::pluralize(str_replace('Id', '', $key));
              $row->$keyField = $referencedClass->fetch(array(
                          'id' => array(
                              '=' => $value
                          )
                              ), array(
                          'recursion' => $recursion - 1,
                          'asArray' => false,
                          'fields' => Array('*')
                      ));
            }
          }
          foreach ($this->hasAndBelongsToMany as $referencedClass => $joinTableName) {
            //
//          echo "Referenced Class:" . $referencedClass;
            $refClass = new $referencedClass;
            $thisTableKey = Inflect::singularize($this->tableName) . 'Id';
            $referencedClassPlural = Inflect::pluralize(lcfirst($referencedClass));
            $row->$referencedClassPlural = $refClass->fetch(array(
                        $thisTableKey => array(
                            '=' => $row->{$this->idField}
                            )), array(
                        'recursion' => $recursion - 1,
                        'asArray' => true,
                        'fields' => Array('*'),
                        'habtmJoin' => array(__CLASS__ => $joinTableName)
                            )
            );
          }
          foreach ($this->hasMany as $referencingClass) {
            // instantiates an object of the class referenced by
            // and queries the class using fetch to return all matching records
            // for this object
            $className = ucfirst(str_replace('Id', '', $key));
            $refClass = new $referencingClass;
            $referencedTableKey = Inflect::singularize(lcfirst($this->tableName)) . 'Id';
            $referencingClassPlural = Inflect::pluralize(lcfirst($referencingClass));
            $row->$referencingClassPlural = $refClass->fetch(array(
                        $referencedTableKey => array(
                            '=' => $row->{$this->idField}
                            )), array(
                        'recursion' => $recursion - 1,
                        'asArray' => false,
                        'fields' => Array('*')
                            )
            );
          }
        }
        //$thisClassPlural = Inflect::pluralize(lcfirst(__CLASS__));
        $selectedRows[] = $row;
      }
      return $selectedRows;
    } catch (PDOException $e) {
      $this->errors[] = 'Exception caught! Error Code: ' . $e->getCode()
              . ' Error: ' . $e->getMessage();
      return false;
    }
  }

  private function getConnection() {
    $pdo = new PDO("mysql:dbname={$this->dbName};host={$this->dbHost};", $this->dbUser, $this->dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  private function validateRule($field, $ruleArray) {
    $value = $this->$field;
    $rule = $ruleArray['rule'];
    $useDefaultMessage = isset($ruleArray['message']);
    switch ($rule) {
      case 'exists':
        if ($value != '') {
          return true;
        } else {
          // i love the ternary operator...
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "That field cannot be empty.";
          return false;
        }
        break;
      case 'isNumeric':
        if (filter_var($this->$field, FILTER_VALIDATE_FLOAT)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be numeric";
          return false;
        }
        break;
      case 'isAlphaNumeric':
        if (Inspekt::isAlnum($this->$field)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be alphanumeric";
          return false;
        }
        break;
      case 'isEmail':
        if (filter_var($this->$field, FILTER_VALIDATE_EMAIL)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be a valid email address";
          return false;
        }
        break;
      case 'isPassword':
        break;
      case 'isDate':
        if (Inspekt::isDate($this->$field)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be valid date";
          return false;
        }
        return;
        break;
      case 'isUrl':
        if (filter_var($this->$field, FILTER_VALIDATE_URL)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be valid URL";
          return false;
        }
        break;
      case 'isInteger':
        if (filter_var($this->$field, FILTER_VALIDATE_INT)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be an integer";
          return false;
        }
        break;
      case 'isRegex':
        if (Inspekt::isRegex($this->$field, $ruleArray['pattern'])) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Field does not fit the required pattern";
          return false;
        }
        break;
      case 'between':
        $maxVal = $ruleArray['between'][1];
        $minVal = $ruleArray['between'][0];
        if (($value >= $minVal) && ($value <= $maxVal)) {
          return true;
        } else {
          $this->errors['Validation'][] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be between $minVal and $maxVal";
          return false;
        }
        break;
      case 'maxLength':
        $maxLength = $ruleArray['maxLength'];
        if ($maxLength >= strlen($this->$field)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value cannot be more than $maxLength characters";
          return false;
        }
        break;
      case 'minLength':
        $minLength = $ruleArray['minLength'];
        if ($minLength <= strlen($this->$field)) {
          return true;
        } else {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Value must be at least $minLength characters";
          return false;
        }
        break;
      case 'comparison':
        $operator = $ruleArray['comparison'][0];
        $comparator = $ruleArray['comparison'][1];
        $result = false;
        switch ($operator) {
          case '=':
            $result = ($this->$field == $comparator) ? true : false;
            break;
          case '<':
            $result = ($this->$field < $comparator) ? true : false;
            break;
          case '>':
            $result = ($this->$field > $comparator) ? true : false;
            break;
          case '<=':
            $result = ($this->$field <= $comparator) ? true : false;
            break;
          case '>=':
            $result = ($this->$field >= $comparator) ? true : false;
            break;
          case '!=':
            $result = ($this->$field != $comparator) ? true : false;
        }
        if (!$result) {
          $this->errors['Validation'][$field] = ($useDefaultMessage) ?
                  $ruleArray['message'] :
                  "Rule could not be validated: Field $operator $comparator";
        }
        return $result;
    }
  }

  public static function createForm($id = 0){
    if($id == 0){
      // create form to insert a new record
      $className = get_called_class();
      $instance = new $className($id);
      echo get_class($instance);
      $output = "<form action='' method=''>\r\n";
      foreach($instance->allowedFields as $fieldName => $fieldAlias){
        $output .= "\t <label for='$fieldAlias'>$fieldAlias</label><br/>\r\n";
        $output .= "\t<input id='$fieldAlias' name='$fieldAlias' /><br/>\r\n";
      }
      $output .= "</form>";
      echo $output;
    }else{
      // create form to edit an existing record
      $className = get_called_class();
      $instance = new $className($id);
      echo get_class($instance);
      $output = "<form action='' method=''>\r\n";
      foreach($instance->allowedFields as $fieldName => $fieldAlias){
        $output .= "\t <label for='$fieldAlias'>$fieldAlias</label><br/>\r\n";
        $output .= "\t<input id='$fieldAlias' name='$fieldAlias' value='{$instance->$fieldAlias}'/><br/>\r\n";
      }
      $output .= "</form>";
      echo $output;

    }
  }

}

?>