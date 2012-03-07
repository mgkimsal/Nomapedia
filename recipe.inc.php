<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of recipe
 *
 * @author Josh
 */
require_once('active_record.inc.php');

class Recipe extends ActiveRecord {

  protected $allowedFields = Array(
      'id' => 'id',
      'title' => 'title',
      'description' => 'description',
      'userId' => 'userId',
      'dateCreated' => 'dateCreated'
  );
  protected $requiredFields = Array(
      'id' => 'id',
      'title' => 'title',
      'description' => 'description',
      'userId' => 'userId',
      'dateCreated' => 'dateCreated'
  );
  protected $hasMany = array(
      
  );
  protected $belongsTo = array(
      'User'
  );
  protected $hasAndBelongsToMany = array(
      'Ingredient'=>'ingredientsrecipes'
  );
  protected $hasOne = array(
  );
  protected $validates = array(
      // iterate through the fields.  check if the 'rule' index exists.  If it does not
      // then multiple rules have been applied to the field and the function must
      // jump down one further level to iterate through the separate rules for the
      // field
      'id' => array(
          'rule1' => array(
              'rule' => 'exists'
          ),
          'rule2' => array(
              'rule' => 'isInteger',
              'message' => 'Primary key must be an integer'
          )
      ),
      'title' => array(
          'rule1' => array(
              'rule' => 'isAlphaNumeric'
          ),
          'rule2' => array(
              'rule' => 'exists'
          )
      ),
      'userId' => array(
          'rule1' => array(
              'rule' => 'exists'
          ),
          'rule2' => array(
              'rule' => 'isInteger'
          )
      ),
      'dateCreated' => array(
          'rule' => 'isDate'
      )
  );

}

?>
