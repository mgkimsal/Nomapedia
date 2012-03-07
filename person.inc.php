<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of person
 *
 * @author Josh
 */
require_once('active_record.inc.php');
class Person extends ActiveRecord {
  protected $allowedFields = Array(
      'id' => 'id',
      'firstName' => 'firstName',
      'lastName' => 'lastName',
      'dateCreated' => 'dateCreated'
  );
  protected $requiredFields = Array(
      'id' => 'id',
      'firstName' => 'firstName',
      'lastName' => 'lastName',
      'dateCreated' => 'dateCreated'
  );
  protected $hasMany = array(
      'User'
  );
  protected $belongsTo = array(
  );
  protected $hasAndBelongsToMany = array(
  );
  protected $hasOne = array(
  );
}
?>
