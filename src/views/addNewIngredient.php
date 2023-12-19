<?php
function addNewIngredient($recipeId){
    ?>
    <div class="card" id="addNewIngredient">
        <h2>Or Add New Ingredient</h2>
        <form action="../actions/actionAddNewIngredient.php" method="POST">
            <input type="hidden" name="recipeId" value="<?= $recipeId ?>" />
            <label for="name">Ingredient Name </label>
            <input type="text" name="name" placeholder="Ingredient Name" required="true">
            <div class="macronutrients">
                <label for="carbohydrate"> Carbohydrate g / 100g </label>
                <input type="number" name="carbohydrate" placeholder="Carbohydrate" min="0" step="0.00001">
                <label for="protein"> Protein g / 100g </label>
                <input type="number" name="protein" placeholder="Protein" min="0" step="0.00001">
                <label for="fat"> Fat g / 100g </label>
                <input type="number" name="fat" placeholder="Fat" min="0" step="0.00001">
            </div>
            <div class="quantity-recipe">
                <label for="quantity"> Quantity in this recipe </label>
                <input type="number" name="quantity" placeholder="Enter quantity" min="0" step="0.00001" required>
                <select name="unit">
                    <option value="g">g</option>
                    <option value="kg">kg</option>
                    <option value="mL">mL</option>
                    <option value="L">L</option>
                </select>
            </div>
            <button id="addNewIngredientBt" type="submit" name="addNewIngBt" value="true">Add New Ingredient</button>
        </form>
    </div>

<?php    
}
?>