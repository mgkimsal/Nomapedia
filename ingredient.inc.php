<?php
require_once('active_record.inc.php');
class Ingredient extends ActiveRecord{

  protected $allowedFields = Array(
      'id'=>'id',
      'name'=>'name',
      'description'=>'description',
      'userId'=>'userId');

  protected $requiredFields = Array(
      'id'=>'id',
      'name'=>'name');

  protected $hasMany = array(

  );

  protected $belongsTo = array(
    'User'
  );
  
  protected $hasAndBelongsToMany = array(
    'Recipe'=>'ingredientsrecipes'
  );

  protected $hasOne = array(

  );

}
