<?php
//require_once('active_record.inc.php');
class Ingredient extends ActiveRecord{

  protected $allowedFields = Array(
      'id'=>'id',
      'name'=>'name',
      'description'=>'description',
      'added_by'=>'addedBy');

  protected $requiredFields = Array(
      'id'=>'id',
      'name'=>'name');

}


?>
