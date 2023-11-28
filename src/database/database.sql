
.headers on
.mode column
--heklo

-- DROPS
DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS Messages;
DROP TABLE IF EXISTS Chef;
DROP TABLE IF EXISTS Nutritionist;
DROP TABLE IF EXISTS Formation;
DROP TABLE IF EXISTS ChefFormation;
DROP TABLE IF EXISTS NutritionistFormation;
DROP TABLE IF EXISTS CommonUser;
DROP TABLE IF EXISTS WeeklyPlan;
DROP TABLE IF EXISTS HealthGoal;
DROP TABLE IF EXISTS UserHealthGoal;
DROP TABLE IF EXISTS AllergyIntolerance;
DROP TABLE IF EXISTS UserAllergy;
DROP TABLE IF EXISTS DietaryPreference;
DROP TABLE IF EXISTS UserDietPreference;
DROP TABLE IF EXISTS Recipe;
DROP TABLE IF EXISTS NutritionistApproval;
DROP TABLE IF EXISTS RecipeRanking;
DROP TABLE IF EXISTS CookingTechnique;
DROP TABLE IF EXISTS RecipeCookingTechnique;
DROP TABLE IF EXISTS FoodCategory;
DROP TABLE IF EXISTS RecipeCategory;
DROP TABLE IF EXISTS RecipeDietaryPref;
DROP TABLE IF EXISTS Ingredient;
DROP TABLE IF EXISTS Macronutrient;
DROP TABLE IF EXISTS IngredientMacronutrient;
DROP TABLE IF EXISTS IngredientRecipe;
DROP TABLE IF EXISTS IngredientAllergyIntolerance;
DROP TABLE IF EXISTS PlanRecipe;

-- CREATES

-- Create the Person table
CREATE TABLE Person (
    id INTEGER PRIMARY KEY AUTOINCREMENT ,
    username TEXT NOT NULL,
    first_name TEXT NOT NULL,
    surname TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL,
    birth_date TEXT,
    gender TEXT
);


-- Ensure uniqueness of usernames and emails
CREATE UNIQUE INDEX idx_unique_username ON Person (username);
CREATE UNIQUE INDEX idx_unique_email ON Person (email);

-- Create the Messages table
CREATE TABLE Messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sending_date TEXT NOT NULL,
    TEXT_content TEXT NOT NULL,
    sender_id REFERENCES Person(id),
    receiver_id REFERENCES Person(id)
);

-- Create the Chef and Nutritionist tables with references to Person
CREATE TABLE Chef (
    chef_id INT PRIMARY KEY REFERENCES Person(id)
);

CREATE TABLE Nutritionist (
    id REFERENCES Person(id)
);

-- Create the Formation table
CREATE TABLE Formation (
    course_name TEXT,
    school_name TEXT,
    academic_level TEXT NOT NULL,
    graduation_date TEXT NOT NULL, 
    PRIMARY KEY (course_name, school_name)
);


-- Create the ChefFormation and NutritionistFormation tables with references
CREATE TABLE ChefFormation (
    course_name TEXT,
    school_name TEXT,
    chef_id REFERENCES Chef(id),
    FOREIGN KEY (course_name, school_name) REFERENCES Formation(course_name, school_name)
);

CREATE TABLE NutritionistFormation (
    course_name TEXT,
    school_name TEXT,
    nutritionist_id REFERENCES Nutritionist(id),
    FOREIGN KEY (course_name, school_name) REFERENCES Formation(course_name, school_name)
);


-- Create the CommonUser table
CREATE TABLE CommonUser (
    height REAL ,
    current_weight REAL,
    ideal_weight REAL,
    id REFERENCES Person(id),
    CHECK (height > 0 AND height < 3),
    CHECK (current_weight > 0 AND current_weight < 600),
    CHECK (ideal_weight > 0 AND ideal_weight < 600)
);

-- Create the WeeklyPlan table
CREATE TABLE WeeklyPlan (
    id INT PRIMARY KEY,
    creation_date TEXT,
    total_kcal REAL, -- Total calories as a decimal
    nutritionist_id REFERENCES Nutritionist(id),
    common_user_id REFERENCES CommonUser(id)
);

-- Create the HealthGoal table
CREATE TABLE HealthGoal (
    name TEXT PRIMARY KEY
);

-- Create the UserHealthGoal table
CREATE TABLE UserHealthGoal (
    user_id INT REFERENCES CommonUser,
    health_goal_name TEXT REFERENCES HealthGoal,
    PRIMARY KEY (user_id, health_goal_name)
);


-- Create the AllergyIntolerance table
CREATE TABLE AllergyIntolerance (
    name TEXT PRIMARY KEY
);

-- Create the UserAllergy table
CREATE TABLE UserAllergy (
    allergy TEXT REFERENCES AllergyIntolerance,
    user INT REFERENCES CommonUser,
    PRIMARY KEY (allergy, user)
);

-- Create the DietaryPreference table
CREATE TABLE DietaryPreference (
    name TEXT PRIMARY KEY
);

-- Create the UserDietPreference table
CREATE TABLE UserDietPreference (
    pref TEXT REFERENCES DietaryPreference,
    user INT REFERENCES CommonUser,
    PRIMARY KEY (pref, user)
);

-- Create the Recipe table
CREATE TABLE Recipe (
    id INT PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    preparation_time INT NOT NULL,
    difficulty INT NOT NULL,
    number_of_servings INT NOT NULL,
    image TEXT NOT NULL,
    preparation_method TEXT NOT NULL,
    submission_date TEXT NOT NULL,
    energy REAL,  -- Total energy as a decimal
    carbohydrates REAL,  -- Total carbohydrates as a decimal
    protein REAL,  -- Total protein as a decimal
    fat REAL,  -- Total fat as a decimal
    chef REFERENCES Chef(id),
    CHECK (preparation_time > 0),
    CHECK (number_of_servings > 0),
    CHECK (difficulty >= 0 AND difficulty <= 5)
);

-- Create the NutritionistApproval table
CREATE TABLE NutritionistApproval (
    recipe_id INT REFERENCES Recipe,
    approval_date TEXT NOT NULL,
    nutritionist_id INT REFERENCES Nutritionist,
    PRIMARY KEY (recipe_id, nutritionist_id)
    
);

-- Create the RecipeRanking table
CREATE TABLE RecipeRanking (
    ranking_date TEXT NOT NULL,
    ranking_value INT NOT NULL,
    comment TEXT,
    user_id REFERENCES CommonUser(id),
    recipe_id REFERENCES Recipe(id),
    CHECK (ranking_value >= 0 AND ranking_value <= 5)
);

-- Create the CookingTechnique table
CREATE TABLE CookingTechnique (
    name TEXT PRIMARY KEY,
    difficulty INT NOT NULL,
    method_description TEXT NOT NULL,
    CHECK (difficulty >= 0 AND difficulty <= 5)
);

-- Create the RecipeCookingTechnique table
CREATE TABLE RecipeCookingTechnique (
    recipe_id INT REFERENCES Recipe(id),
    cooking_technique TEXT REFERENCES CookingTechnique(name),
    PRIMARY KEY (recipe_id, cooking_technique)
);

-- Create the FoodCategory table
CREATE TABLE FoodCategory (
    name TEXT PRIMARY KEY
);

-- Create the RecipeCategory table
CREATE TABLE RecipeCategory (
    category TEXT REFERENCES FoodCategory,
    recipe_id INT REFERENCES Recipe,
    PRIMARY KEY (category, recipe_id)
);

-- Create the RecipeDietaryPref table
CREATE TABLE RecipeDietaryPref (
    dietary_pref TEXT REFERENCES DietaryPreference,
    recipe_id INT REFERENCES Recipe,
    PRIMARY KEY (dietary_pref, recipe_id)
);

-- Create the Ingredient table
CREATE TABLE Ingredient (
    id INT PRIMARY KEY,
    name TEXT NOT NULL,
    UNIQUE (name)
);

-- Create the Macronutrient table
CREATE TABLE Macronutrient (
    name TEXT PRIMARY KEY,
    kcal_per_gram REAL NOT NULL,
    CHECK (kcal_per_gram > 0)
);

-- Create the IngredientMacronutrient table
CREATE TABLE IngredientMacronutrient (
    quantity_g REAL NOT NULL,
    ingredient_id INT REFERENCES Ingredient(id),
    macronutrient TEXT REFERENCES Macronutrient(name),
    PRIMARY KEY (ingredient_id, macronutrient)
);

-- Create the IngredientRecipe table
CREATE TABLE IngredientRecipe (
    quantity REAL NOT NULL,
    measurement_unit TEXT NOT NULL,
    ingredient_id REFERENCES Ingredient(id),
    recipe_id REFERENCES Recipe(id),
    CHECK (quantity > 0)
);

-- Create the IngredientAllergyIntolerance table
CREATE TABLE IngredientAllergyIntolerance (
    ingredient_id REFERENCES Ingredient(id),
    allergy_intolerance REFERENCES AllergyIntolerance(name),
    PRIMARY KEY (ingredient_id, allergy_intolerance)
);

-- Create the PlanRecipe table
CREATE TABLE PlanRecipe (
    day_week TEXT,
    portion REAL NOT NULL,
    time_meal TEXT,
    plan_id REFERENCES WeeklyPlan(id),
    recipe_id REFERENCES Recipe(id),
    CHECK (day_week IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')),
    CHECK (portion > 0),
    CHECK (time_meal IN ('Breakfast', 'Lunch', 'Dinner', 'Morning Snack', 'Afternoon Snack', 'Supper'))
);

-- Users
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('john_doe', 'John', 'Doe', 'john.doe@email.com', 'jdP@ssword123', '1990-05-20', 'male');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('alice_smith', 'Alice', 'Smith', 'alice.smith@email.com', 'aS!789xyz', '1988-12-15', 'female');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('robert_jones', 'Robert', 'Jones', 'robert.jones@email.com', 'Rj456pass', '1975-08-02', 'male');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('sara_miller', 'Sara', 'Miller', 'sara.miller@email.com', 'saraPass!23', '1995-04-10', 'female');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('michael_brown', 'Michael', 'Brown', 'michael.brown@email.com', 'Mb_987Pass', '1983-11-28', 'male');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('emily_wilson', 'Emily', 'Wilson', 'emily.wilson@email.com', 'EwP@ss456', '1992-09-08', 'female');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('alex_turner', 'Alex', 'Turner', 'alex.turner@email.com', 'ATurner_789', '1980-07-17', 'male');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender)VALUES ('laura_smith', 'Laura', 'Smith', 'laura.smith@email.com', 'lauraPass!321', '1998-03-25', 'female');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender) VALUES ('david_clark', 'David', 'Clark', 'david.clark@email.com', 'DcPass_567', '1978-06-12', 'male');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender) VALUES ('jessica_taylor', 'Jessica', 'Taylor', 'jessica.taylor@email.com', 'JTaylor@987', '1987-02-19', 'female');

-- Messagess
INSERT INTO Messages (id, sending_date, TEXT_content, sender_id, receiver_id) VALUES (1, '2023-01-15 08:30:00', 'Just tried a new recipe for pasta carbonara - it was delicious!', 2, 3);
INSERT INTO Messages (id, sending_date, TEXT_content, sender_id, receiver_id)VALUES (2, '2023-02-20 14:45:00', 'Thank you great sushi recipe', 4, 1);
INSERT INTO Messages (id, sending_date, TEXT_content, sender_id, receiver_id) VALUES (3, '2023-03-10 18:20:00', 'Thinking of making homemade pizza tonight. Any toppings suggestions?', 1, 5);

-- Chefs
INSERT INTO Chef VALUES (1);
INSERT INTO Chef VALUES (2);
INSERT INTO Chef VALUES (3);

-- Nutritionist
INSERT INTO Nutritionist VALUES (1);
INSERT INTO Nutritionist VALUES (2);

-- Weekly Plan
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES (1, '2023-01-15', 2000, 1, 6);
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES (2, '2023-01-20', 1800, 2, 7);
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES (3, '2023-01-25', 2200,2, 8);

-- Recipe
INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef) VALUES (1, 'Pasta Carbonara', 30, 2, 4, 'https://www.recipetineats.com/wp-content/uploads/2019/08/Spaghetti-Carbonara_5-SQ.jpg', '1. Cook the pasta in a large pot of salted boiling water until al dente. Drain and reserve 1 cup of the pasta cooking water. 2. Meanwhile, place the pancetta in a large skillet and cook over medium heat until crispy, about 8 minutes. Remove the pancetta from the pan and set aside. 3. Add the olive oil to the pan with the pancetta drippings. Add the garlic and cook for 30 seconds. Add the cooked pasta to the pan, then add the eggs, cheese, salt and pepper. Toss well to coat evenly, adding the reserved pasta water a little at a time as needed to make a creamy sauce. Stir in the pancetta and parsley. Serve immediately.', '2023-01-15', 2000, 200, 100, 50, 1);
INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef) VALUES (2, 'Sauteed Vegetables', 30, 2, 4, 'https://www.recipetineats.com/wp-content/uploads/2019/08/Spaghetti-Carbonara_5-SQ.jpg', '1. Cook the pasta in a large pot of salted boiling water until al dente. Drain and reserve 1 cup of the pasta cooking water. 2. Meanwhile, place the pancetta in a large skillet and cook over medium heat until crispy, about 8 minutes. Remove the pancetta from the pan and set aside. 3. Add the olive oil to the pan with the pancetta drippings. Add the garlic and cook for 30 seconds. Add the cooked pasta to the pan, then add the eggs, cheese, salt and pepper. Toss well to coat evenly, adding the reserved pasta water a little at a time as needed to make a creamy sauce. Stir in the pancetta and parsley. Serve immediately.', '2023-01-15', 2000, 200, 100, 50, 1);


-- Plan Recipe
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.0, 'Breakfast', 1, 1);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.0, 'Breakfast', 1, 2);

-- Formations
INSERT INTO Formation (course_name, school_name, academic_level, graduation_date)
VALUES ('Nutricionsim', 'International Nutricionism Institute', 'Bachelors Degree', '2022-05-25');

INSERT INTO Formation (course_name, school_name, academic_level, graduation_date)
VALUES ('Pastry and Baking', 'Le Cordon Bleu', 'Associate Degree', '2021-12-15');

INSERT INTO Formation (course_name, school_name, academic_level, graduation_date)
VALUES ('Nutricionism', 'Nutricionism Institute of America', 'Masters Degree', '2023-03-10');

INSERT INTO Formation (course_name, school_name, academic_level, graduation_date)
VALUES ('Food Science', 'University of Gastronomic Sciences', 'Bachelors Degree', '2020-08-30');

INSERT INTO Formation (course_name, school_name, academic_level, graduation_date)
VALUES ('Wine pairings', 'University of Gastronomic Sciences', 'Bachelors Degree', '2020-08-30');

-- Chef Formations
INSERT INTO ChefFormation VALUES (1,'Pastry and Baking', 'Le Cordon Bleu');
INSERT INTO ChefFormation VALUES (2,'Food Science', 'University of Gastronomic Sciences');
INSERT INTO ChefFormation VALUES (3,'Wine pairings', 'University of Gastronomic Sciences');

-- Nutritionist Formations
INSERT INTO NutritionistFormation VALUES ('Nutricionsim', 'International Nutricionism Institute', 1);
INSERT INTO NutritionistFormation VALUES ('Nutricionism', 'Nutricionism Institute of America', 2);

-- Insert Statements for CommonUser Table
INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (6, 1.75, 70.5, 68.0);

INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (7, 1.60, 55.0, 50.0);

INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (8, 1.80, 90.0, 85.0);

INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (9, 1.68, 63.5, 60.0);

INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (10, 1.90, 80.0, 75.0);

INSERT INTO HealthGoal 
VALUES ('Weight Loss');
INSERT INTO HealthGoal 
VALUES ('Weight Gain');
INSERT INTO HealthGoal 
VALUES ('Muscle Building');
INSERT INTO HealthGoal 
VALUES ('Cardiovascular Fitness');

INSERT INTO UserHealthGoal (user_id, health_goal_name)
VALUES (6, 'Weight Loss');

INSERT INTO UserHealthGoal (user_id, health_goal_name)
VALUES (7, 'Muscle Building');

INSERT INTO UserHealthGoal (user_id, health_goal_name)
VALUES (8, 'Cardiovascular Fitness');

-- Insert Statements for AllergyIntolerance Table
INSERT INTO AllergyIntolerance (name) VALUES ('Peanuts');
INSERT INTO AllergyIntolerance (name) VALUES ('Shellfish');
INSERT INTO AllergyIntolerance (name) VALUES ('Gluten');

-- Insert Statements for UserAllergy Table
INSERT INTO UserAllergy (allergy, user)
VALUES ('Peanuts', 8);

INSERT INTO UserAllergy (allergy, user)
VALUES ('Shellfish', 9);

INSERT INTO UserAllergy (allergy, user)
VALUES ('Gluten', 10);

-- Insert Statements for DietaryPreference Table
INSERT INTO DietaryPreference (name) VALUES ('Vegetarian');
INSERT INTO DietaryPreference (name) VALUES ('Vegan');
INSERT INTO DietaryPreference (name) VALUES ('Paleo');


-- Insert Statements for UserDietPreference Table
INSERT INTO UserDietPreference (pref, user) VALUES ('Vegetarian', 6);
INSERT INTO UserDietPreference (pref, user) VALUES ('Vegan', 8);
INSERT INTO UserDietPreference (pref, user) VALUES ('Paleo', 9);

-- Insert Statements for Recipe Table
INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (1, 'Spaghetti Bolognese', 30, 3, 4, 'spaghetti_image.jpg', 'Cook spaghetti and prepare Bolognese sauce.', '2023-06-15', 500.5, 65.2, 30.0, 15.8, 1);

INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (2, 'Grilled Salmon', 20, 2, 2, 'salmon_image.jpg', 'Season salmon and grill until cooked.', '2023-06-18', 350.2, 2.5, 40.8, 18.3, 2);

INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (3, 'Vegetable Stir-Fry', 15, 1, 3, 'stir_fry_image.jpg', 'Stir-fry assorted vegetables in a wok.', '2023-06-20', 180.7, 20.0, 8.9, 9.5, 3);

-- Insert Statements for NutritionistApproval Table
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (1, '2023-06-16', 1);
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (2, '2023-06-19', 2);
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (3, '2023-06-21', 2);

-- Insert Statements for RecipeRanking Table
INSERT INTO RecipeRanking (ranking_date, ranking_value, comment, user_id, recipe_id)
VALUES ('2023-06-25', 4, 'Delicious!', 8, 1);

INSERT INTO RecipeRanking (ranking_date, ranking_value, comment, user_id, recipe_id)
VALUES ('2023-06-26', 5, 'Amazing recipe!', 9, 2);

INSERT INTO RecipeRanking (ranking_date, ranking_value, comment, user_id, recipe_id)
VALUES ('2023-06-27', 3, 'Good, but could use more seasoning.', 10, 3);

-- Insert Statements for CookingTechnique Table
INSERT INTO CookingTechnique (name, difficulty, method_description)
VALUES ('Grilling', 2, 'Cooking food directly over an open flame or heat source.');

INSERT INTO CookingTechnique (name, difficulty, method_description)
VALUES ('Sautéing', 3, 'Cooking food quickly in a small amount of oil over medium-high heat.');

INSERT INTO CookingTechnique (name, difficulty, method_description)
VALUES ('Braising', 4, 'Cooking food slowly in a covered pot with added liquid.');

-- Insert Statements for RecipeCookingTechnique Table
INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (1, 'Grilling');

INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (2, 'Sautéing');

INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (3, 'Braising');

-- Insert Statements for FoodCategory Table
INSERT INTO FoodCategory (name) VALUES ('Vegetables');
INSERT INTO FoodCategory (name) VALUES ('Protein');
INSERT INTO FoodCategory (name) VALUES ('Dairy');

-- Insert Statements for RecipeCategory Table
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Vegetables', 1);
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Protein', 2);
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Dairy', 3);

-- Insert Statements for RecipeDietaryPref Table
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Vegetarian', 1);
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Vegan', 2);
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Paleo', 3);

-- Insert Statements for Ingredient Table
INSERT INTO Ingredient (id, name) VALUES (1, 'Tomato');
INSERT INTO Ingredient (id, name) VALUES (2, 'Chicken Breast');
INSERT INTO Ingredient (id, name) VALUES (3, 'Quinoa');

-- Insert Statements for Macronutrient Table
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Protein', 4.0);
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Carbohydrate', 4.0);
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Fat', 9.0);

-- Insert Statements for IngredientMacronutrient Table
INSERT INTO IngredientMacronutrient (quantity_g, ingredient_id, macronutrient) VALUES (10, 1, 'Carbohydrate');
INSERT INTO IngredientMacronutrient (quantity_g, ingredient_id, macronutrient) VALUES (150, 2, 'Protein');
INSERT INTO IngredientMacronutrient (quantity_g, ingredient_id, macronutrient) VALUES (20, 3, 'Fat');

-- Insert Statements for IngredientRecipe Table
INSERT INTO IngredientRecipe (quantity, measurement_unit, ingredient_id, recipe_id) VALUES (200, 'grams', 1, 1);
INSERT INTO IngredientRecipe (quantity, measurement_unit, ingredient_id, recipe_id) VALUES (300, 'grams', 2, 2);
INSERT INTO IngredientRecipe (quantity, measurement_unit, ingredient_id, recipe_id) VALUES (150, 'grams', 3, 3);

-- Insert Statements for IngredientAllergyIntolerance Table
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (1, 'Peanuts');
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (2, 'Shellfish');
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (3, 'Gluten');

-- Insert Statements for PlanRecipe Table
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.5, 'Lunch', 1, 1);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Wednesday', 2.0, 'Dinner', 2, 2);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Friday', 1.0, 'Breakfast', 3, 3);
