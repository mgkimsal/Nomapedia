<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Josh
 */
require_once('active_record.inc.php');

class User extends ActiveRecord {

  protected $allowedFields = Array(
      'id' => 'id',
      'handle' => 'handle',
      'email' => 'email',
      'dateCreated' => 'dateCreated',
      'personId' => 'personId'
  );
  protected $requiredFields = Array(
      'id' => 'id',
      'name' => 'name',
      'email' => 'email',
      'dateCreated' => 'dateCreated',
      'personId' => 'personId'
  );
  protected $hasMany = array(
      'Ingredient', 'Recipe'
  );
  protected $belongsTo = array(
      'Person'
  );
  protected $hasAndBelongsToMany = array(
  );
  protected $hasOne = array(
  );

}

?>
