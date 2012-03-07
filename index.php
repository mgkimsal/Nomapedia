<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once('ingredient.inc.php');
require_once('user.inc.php');
require_once('person.inc.php');
require_once('recipe.inc.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <!-- This section will later be separated into a head include file -->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="jquery.js"></script>
    <script src="tablesorter.juery.js"></script>
    <title>This is the ultimate food encyclopedia</title>
  </head>
  <body>
    <div id="wrapper">
      <div id="header">
        <!-- this section will later be broken off into a links bar include-->
        <div id="links_bar">
          <ul>
            <li>Home</li>
            <li>Recipes</li>
            <li>Ingredients</li>
            <li>Cooks</li>
            <li>Blog</li>
          </ul>
          <div id="search_bar">
            <input type="text" name="search_query" id="search_query" />
            <button type="button" id="search_button">Search</button>
          </div>
        </div>
      </div>
      <div id="content-wrapper">
        <div id="content">
          <h1>All Things Food</h1>
          <p>
            Welcome to All Things Food - the ultimate reference source and discussion forum
            for, well, all things food.  Search for anything up in the right hand corner there
            or explore recipes and ingredients.  All things are interconnected and you'll find that everything
            you may want to know more about will be a link to useful information.
          </p>
          <p>
<!--          <form action='' method="POST">
            <label for="'id">id:</label>
            <input id="an id" name="an id" />
            
          </form>-->
            <?php
//            $recipe = new Recipe();
              Recipe::createForm();
              Recipe::createForm(1);
//            $recipe->title = 'Lasagna';
//            $recipe->description = 'Yummy';
//            $recipe->userId = 1;

//            if($recipe->create()){
//              echo '<pre>';
//              var_dump($recipe);
//              echo '</pre>';
//            }else{
//              print_r($recipe->errors);
//            }
//            $ingredients = $ingredient->fetch(null, array('recursion'=>2, 'asArray'=>false));

            
            ?>
          </p>
          <div id="latest_additions">
            <h2>Here are the latest updates</h2>
            <!-- insert here a function to pull up the last 5 additions
            (recipes, ingredients, whatever) with short summaries of the contents.
            -->
          </div>
        </div>
      </div>

      <div id="footer">

      </div>

    </div>

<?php
?>
  </body>
</html>
