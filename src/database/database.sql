PRAGMA foreign_keys = ON;

.headers on
.mode column

-- DROPS
DROP TABLE IF EXISTS Person;
DROP TABLE IF EXISTS Message;
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
    id INT PRIMARY KEY,
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

-- Create the Message table
CREATE TABLE Message (
    id INT PRIMARY KEY,
    sending_date TEXT NOT NULL,
    TEXT_content TEXT NOT NULL,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    sender_id REFERENCES Person(id),
    receiver_id REFERENCES Person(id)
);

-- Create the Chef and Nutritionist tables with references to Person
CREATE TABLE Chef (
    id INT PRIMARY KEY,
    id REFERENCES Person(id)
);

CREATE TABLE Nutritionist (
    id INT PRIMARY KEY,
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
    chef_id INT,
    course_name TEXT,
    school_name TEXT,
    chef_id REFERENCES Chef(id),
    (course_name, school_name) REFERENCES Formation(course_name, school_name)
);

CREATE TABLE NutritionistFormation (
    nutritionist_id INT,
    course_name TEXT,
    school_name TEXT,
    nutritionist_id REFERENCES Nutritionist(id),
    (course_name, school_name) REFERENCES Formation(course_name, school_name)
);

-- Create the CommonUser table
CREATE TABLE CommonUser (
    id INT,
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
    nutritionist_id INT,
    common_user_id INT,
    nutritionist_id REFERENCES Nutritionist(id),
    common_user_id REFERENCES CommonUser(id)
);

-- Create the HealthGoal table
CREATE TABLE HealthGoal (
    name TEXT PRIMARY KEY
);

-- Create the UserHealthGoal table
CREATE TABLE UserHealthGoal (
    user INT,
    health_goal TEXT,
    user REFERENCES CommonUser(id),
    health_goal REFERENCES HealthGoal(name),
    PRIMARY KEY (user, health_goal)
);

-- Create the AllergyIntolerance table
CREATE TABLE AllergyIntolerance (
    name TEXT PRIMARY KEY
);

-- Create the UserAllergy table
CREATE TABLE UserAllergy (
    allergy TEXT,
    user INT,
    allergy REFERENCES AllergyIntolerance(name),
    user REFERENCES CommonUser(id),
    PRIMARY KEY (allergy, user)
);

-- Create the DietaryPreference table
CREATE TABLE DietaryPreference (
    name TEXT PRIMARY KEY
);

-- Create the UserDietPreference table
CREATE TABLE UserDietPreference (
    pref TEXT,
    user INT,
    pref REFERENCES DietaryPreference(name),
    user REFERENCES CommonUser(id),
    PRIMARY KEY (pref, user)
);

-- Create the Recipe table
CREATE TABLE Recipe (
    id INT PRIMARY KEY,
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
    chef INT NOT NULL,
    chef REFERENCES Chef(id),
    CHECK (preparation_time > 0),
    CHECK (number_of_servings > 0),
    CHECK (difficulty >= 0 AND difficulty <= 5)
);

-- Create the NutritionistApproval table
CREATE TABLE NutritionistApproval (
    nutritionist_id INT,
    recipe_id INT,
    approval_date TEXT NOT NULL,
    nutritionist_id REFERENCES Nutritionist(id),
     (recipe_id) REFERENCES Recipe(id)
);

-- Create the RecipeRanking table
CREATE TABLE RecipeRanking (
    user_id INT,
    recipe_id INT,
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
    recipe_id INT,
    cooking_technique TEXT,
    recipe_id REFERENCES Recipe(id),
    cooking_technique REFERENCES CookingTechnique(name),
    PRIMARY KEY (recipe_id, cooking_technique)
);

-- Create the FoodCategory table
CREATE TABLE FoodCategory (
    name TEXT PRIMARY KEY
);

-- Create the RecipeCategory table
CREATE TABLE RecipeCategory (
    category TEXT,
    recipe_id INT,
    category REFERENCES FoodCategory(name),
    recipe_id REFERENCES Recipe(id),
    PRIMARY KEY (category, recipe_id)
);

-- Create the RecipeDietaryPref table
CREATE TABLE RecipeDietaryPref (
    dietary_pref TEXT,
    recipe_id INT,
    dietary_pref REFERENCES DietaryPreference(name),
    recipe_id REFERENCES Recipe(id),
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
    ingredient_id INT,
    macronutrient TEXT,
    quantity_g REAL NOT NULL,
    ingredient_id REFERENCES Ingredient(id),
    macronutrient REFERENCES Macronutrient(name),
    PRIMARY KEY (ingredient_id, macronutrient)
);

-- Create the IngredientRecipe table
CREATE TABLE IngredientRecipe (
    ingredient_id INT,
    recipe_id INT,
    quantity REAL NOT NULL,
    measurement_unit TEXT NOT NULL,
    ingredient_id REFERENCES Ingredient(id),
    recipe_id REFERENCES Recipe(id),
    CHECK (quantity > 0)
);

-- Create the IngredientAllergyIntolerance table
CREATE TABLE IngredientAllergyIntolerance (
    ingredient_id INT,
    allergy_intolerance TEXT,
    ingredient_id REFERENCES Ingredient(id),
    allergy_intolerance REFERENCES AllergyIntolerance(name),
    PRIMARY KEY (ingredient_id, allergy_intolerance)
);

-- Create the PlanRecipe table
CREATE TABLE PlanRecipe (
    plan_id INT,
    recipe_id INT,
    day_week TEXT,
    portion REAL NOT NULL,
    time_meal TEXT,
    plan_id REFERENCES WeeklyPlan(id),
    recipe_id REFERENCES Recipe(id),
    CHECK (day_week IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')),
    CHECK (portion > 0),
    CHECK (time_meal IN ('Breakfast', 'Lunch', 'Dinner', 'Morning Snack', 'Afternoon Snack', 'Supper'))
);
