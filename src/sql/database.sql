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
DROP TABLE IF EXISTS RecipeRating;
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
    gender TEXT,
    profile_photo TEXT
);


-- Ensure uniqueness of usernames and emails
CREATE UNIQUE INDEX idx_unique_username ON Person (username);
CREATE UNIQUE INDEX idx_unique_email ON Person (email);

-- Create the Messages table
CREATE TABLE Messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    sending_date TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    content TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    sender_id INT REFERENCES Person(id),
    receiver_id INT REFERENCES Person(id)
);

-- Create the Chef and Nutritionist tables with references to Person
CREATE TABLE Chef (
    chef_id INT PRIMARY KEY REFERENCES Person(id)
);

CREATE TABLE Nutritionist (
    nutri_id INT PRIMARY KEY REFERENCES Person(id)
);

-- Create the Formation table
CREATE TABLE Formation (
    user_id INT PRIMARY KEY REFERENCES Person(id),
    course_name TEXT,
    school_name TEXT,
    academic_level TEXT NOT NULL,
    graduation_date TEXT NOT NULL 
    
);


-- Create the ChefFormation and NutritionistFormation tables with references
CREATE TABLE ChefFormation (
    course_name TEXT,
    school_name TEXT,
    chef_id INT REFERENCES Chef(chef_id),
    FOREIGN KEY (course_name, school_name) REFERENCES Formation(course_name, school_name)
);

CREATE TABLE NutritionistFormation (
    course_name TEXT,
    school_name TEXT,
    nutritionist_id INT REFERENCES Nutritionist(nutri_id),
    FOREIGN KEY (course_name, school_name) REFERENCES Formation(course_name, school_name)
);


-- Create the CommonUser table
CREATE TABLE CommonUser (
    height REAL ,
    current_weight REAL,
    ideal_weight REAL,
    id INT PRIMARY KEY REFERENCES Person(id),
    CHECK (height > 0 AND height < 3),
    CHECK (current_weight > 0 AND current_weight < 600),
    CHECK (ideal_weight > 0 AND ideal_weight < 600)
);

-- Create the WeeklyPlan table
CREATE TABLE WeeklyPlan (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    creation_date TEXT,
    total_kcal REAL, -- Total calories as a decimal
    nutritionist_id INT REFERENCES Nutritionist(nutri_id),
    common_user_id INT REFERENCES CommonUser(id)
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
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    preparation_time INT NOT NULL,
    difficulty INT NOT NULL,
    number_of_servings INT NOT NULL,
    image TEXT NOT NULL,
    preparation_method TEXT NOT NULL,
    submission_date TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    energy REAL,  -- Total energy as a decimal
    carbohydrates REAL,  -- Total carbohydrates as a decimal
    protein REAL,  -- Total protein as a decimal
    fat REAL,  -- Total fat as a decimal
    chef INT REFERENCES Chef(id),
    CHECK (preparation_time > 0),
    CHECK (number_of_servings > 0),
    CHECK (difficulty >= 0 AND difficulty <= 5)
);

-- Create the NutritionistApproval table
CREATE TABLE NutritionistApproval (
    recipe_id INT REFERENCES Recipe,
    approval_date TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    nutritionist_id INT REFERENCES Nutritionist,
    PRIMARY KEY (recipe_id, nutritionist_id)
    
);

-- Create the RecipeRating table
CREATE TABLE RecipeRating (
    rating_date TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rating_value INT NOT NULL,
    comment TEXT,
    user_id INT REFERENCES CommonUser(id),
    recipe_id INT REFERENCES Recipe(id),
    CHECK (rating_value >= 0 AND rating_value <= 5)
);

-- Create the CookingTechnique table
CREATE TABLE CookingTechnique (
    name TEXT PRIMARY KEY
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
    id INTEGER PRIMARY KEY AUTOINCREMENT,
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
    ingredient_id INT REFERENCES Ingredient(id),
    recipe_id INT REFERENCES Recipe(id),
    CHECK (quantity > 0)
);

-- Create the IngredientAllergyIntolerance table
CREATE TABLE IngredientAllergyIntolerance (
    ingredient_id INT REFERENCES Ingredient(id),
    allergy_intolerance TEXT REFERENCES AllergyIntolerance(name),
    PRIMARY KEY (ingredient_id, allergy_intolerance)
);

-- Create the PlanRecipe table
CREATE TABLE PlanRecipe (
    day_week TEXT,
    portion REAL NOT NULL,
    time_meal TEXT,
    plan_id INT,
    recipe_id INT,
    FOREIGN KEY (plan_id) REFERENCES WeeklyPlan(id),
    FOREIGN KEY (recipe_id) REFERENCES Recipe(id),
    CHECK (day_week IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')),
    CHECK (portion > 0),
    CHECK (time_meal IN ('Breakfast', 'Lunch', 'Dinner', 'Morning Snack', 'Afternoon Snack', 'Supper'))
);

-- Users
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('john_doe', 'John', 'Doe', 'john.doe@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1990-05-20', 'male', '../img/users/1.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('alice_smith', 'Alice', 'Smith', 'alice.smith@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1988-12-15', 'female', '../img/users/2.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('robert_jones', 'Robert', 'Jones', 'robert.jones@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1975-08-02', 'male', '../img/users/3.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('sara_miller', 'Sara', 'Miller', 'sara.miller@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1995-04-10', 'female', '../img/users/4.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('michael_brown', 'Michael', 'Brown', 'michael.brown@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1983-11-28', 'male', '../img/users/5.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('emily_wilson', 'Emily', 'Wilson', 'emily.wilson@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1992-09-08', 'female', '../img/users/6.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('alex_turner', 'Alex', 'Turner', 'alex.turner@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1980-07-17', 'male', '../img/users/7.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo)VALUES ('laura_smith', 'Laura', 'Smith', 'laura.smith@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1998-03-25', 'female', '../img/users/8.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo) VALUES ('david_clark', 'David', 'Clark', 'david.clark@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1978-06-12', 'male', '../img/users/9.jpg');
INSERT INTO Person (username, first_name, surname, email, password, birth_date, gender, profile_photo) VALUES ('jessica_taylor', 'Jessica', 'Taylor', 'jessica.taylor@email.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', '1987-02-19', 'female', '../img/users/10.jpg');

-- Messagess
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (1, '2023-01-15 08:30:00', 'Just tried a new recipe for pasta carbonara - it was delicious!', 0, 2, 3);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id)VALUES (2, '2023-02-20 14:45:00', 'Thank you great sushi recipe', 1, 4, 1);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (3, '2023-03-10 18:20:00', 'Thinking of making homemade pizza tonight. Any toppings suggestions?', 0, 1, 5);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (4, '2023-03-10 18:20:00', 'Hello! I am looking for a plan that will help me improve my overall fitness and health. Can you help me?', 1, 9, 4);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (5, '2023-03-11 17:34:00', 'Sure! Do you have any allergy or dietary preference?', 1, 4, 9);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (6, '2023-03-11 18:10:00', 'No, I can eat anything. I am only allergic to peanuts.', 1, 9, 4);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (7, '2023-03-11 18:11:00', 'I also like a treat or a comfort meal once in a while.', 1, 9, 4);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (8, '2023-03-12 10:53:00', 'I got you! I will make you a plan. Please give me some feedback afterwards.', 1, 4, 9);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (9, '2023-03-12 12:30:00', 'Sure! Thank you for your help.', 0, 9, 4);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (10, '2023-03-12 12:32:00', 'Looking forward to starting my new plan!', 0, 9, 4);
INSERT INTO Messages (id, sending_date, content, is_read, sender_id, receiver_id) VALUES (11, '2023-12-12 12:32:00', 'You are welcome!', 1, 1, 4);


-- Chefs
INSERT INTO Chef VALUES (1);
INSERT INTO Chef VALUES (2);
INSERT INTO Chef VALUES (3);

-- Nutritionist
INSERT INTO Nutritionist VALUES (4);
INSERT INTO Nutritionist VALUES (5);

-- Weekly Plan
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES (1, '2023-01-15', 2123, 4, 6);
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES (2, '2023-01-20', 1800, 4, 7);
INSERT INTO WeeklyPlan (id, creation_date, total_kcal, nutritionist_id, common_user_id) VALUES 
(3, '2023-01-25', 2200,5, 8),
(4, '2023-01-25', 2500,4, 9);


-- Plan Recipe
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.0, 'Breakfast', 1, 1);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.0, 'Breakfast', 1, 2);

-- Formations
INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date)
VALUES (4,'Nutricionsim', 'International Nutricionism Institute', 'Bachelors Degree', '2022-05-25');

INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date)
VALUES (1,'Pastry and Baking', 'Le Cordon Bleu', 'Associate Degree', '2021-12-15');

INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date)
VALUES (5,'Nutricionism', 'Nutricionism Institute of America', 'Masters Degree', '2023-03-10');

INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date)
VALUES (2,'Food Science', 'University of Gastronomic Sciences', 'Bachelors Degree', '2020-08-30');

INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date)
VALUES (3,'Wine pairings', 'University of Gastronomic Sciences', 'Bachelors Degree', '2020-08-30');

-- Chef Formations
INSERT INTO ChefFormation VALUES ('Pastry and Baking', 'Le Cordon Bleu',1);
INSERT INTO ChefFormation VALUES ('Food Science', 'University of Gastronomic Sciences',2);
INSERT INTO ChefFormation VALUES ('Wine pairings', 'University of Gastronomic Sciences',3);

-- Nutritionist Formations
INSERT INTO NutritionistFormation VALUES ('Nutricionsim', 'International Nutricionism Institute', 4);
INSERT INTO NutritionistFormation VALUES ('Nutricionism', 'Nutricionism Institute of America', 5);

-- Insert Statements for CommonUser Table
INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (6, 1.75, 70.5, 68.0);

INSERT INTO CommonUser (id, height, current_weight, ideal_weight)
VALUES (7, 1.90, 55.0, 50.0);

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
VALUES (1, 'Spaghetti Bolognese', 60, 3, 6, '../img/recipes/1.jpg', '
Put a large saucepan on a medium heat and add 1 tbsp olive oil. <br>
Add 4 finely chopped bacon rashers and fry for 10 mins until golden and crisp.<br>
Reduce the heat and add the 2 onions, 2 carrots, 2 celery sticks, 2 garlic cloves and the leaves from 2-3 sprigs rosemary, all finely chopped, then fry for 10 mins. Stir the veg often until it softens.<br>
Increase the heat to medium-high, add 500g beef mince and cook stirring for 3-4 mins until the meat is browned all over.<br>
Add 2 tins plum tomatoes, the finely chopped leaves from ¾ small pack basil, 1 tsp dried oregano, 2 bay leaves, 2 tbsp tomato purée, 1 beef stock cube, 1 deseeded and finely chopped red chilli (if using), 125ml red wine and 6 halved cherry tomatoes. Stir with a wooden spoon, breaking up the plum tomatoes.<br> <br>
Bring to the boil, reduce to a gentle simmer and cover with a lid. Cook for 1 hr 15 mins stirring occasionally, until you have a rich, thick sauce.
<br>
Add the 75g grated parmesan, check the seasoning and stir. <br>
<br>
When the bolognese is nearly finished, cook 400g spaghetti following the pack instructions.<br>
<br>
Drain the spaghetti and either stir into the bolognese sauce, or serve the sauce on top. Serve with more grated parmesan, the remaining basil leaves and crusty bread, if you like.', '2023-06-15', 624.5, 65.2, 30.0, 15.8, 1);
INSERT INTO Recipe 
VALUES (2, 'Chicken Alfredo Pasta', 45, 2, 4, '../img/recipes/2.jpg', '
Start by boiling a large pot of salted water for the pasta. Cook 400g of fettuccine according to the package instructions until al dente. Drain and set aside.<br>

In a large skillet, heat 2 tbsp of olive oil over medium-high heat. Add 500g of boneless, skinless chicken breasts, cut into bite-sized pieces. Cook until browned and cooked through, about 5-7 minutes.<br>

Add 3 cloves of minced garlic and cook for 1 minute until fragrant. Pour in 1 cup of heavy cream, 1 cup of grated Parmesan cheese, and 1/2 cup of unsalted butter. Stir continuously until the cheese is melted and the sauce is smooth.
<br>
Season the sauce with salt, black pepper, and a pinch of nutmeg for flavor. If the sauce is too thick, you can add a little pasta cooking water to reach your desired consistency.
<br>
Add the cooked fettuccine to the skillet, tossing to coat the pasta evenly in the Alfredo sauce. Cook for an additional 2-3 minutes until everything is heated through.
<br>
Serve the Chicken Alfredo Pasta hot, garnished with chopped fresh parsley and extra Parmesan cheese.', '2023-06-20', 850.0, 45.5, 42.0, 60.2, 1);

INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (3, 'Healthy Pancakes', 20, 2, 4, '../img/recipes/3.jpg', '
In a mixing bowl, combine 1 cup of whole wheat flour, 1 tablespoon of baking powder, and a pinch of salt.
<br>
In a separate bowl, whisk together 1 cup of low-fat milk, 2 tablespoons of Greek yogurt, 1 tablespoon of honey, and 2 tablespoons of melted coconut oil.
<br>
Pour the wet ingredients into the dry ingredients and stir until just combined. Be careful not to overmix; a few lumps are okay.
<br>
Heat a non-stick griddle or skillet over medium heat. Lightly grease with cooking spray or a small amount of coconut oil.
<br>
For each pancake, pour 1/4 cup of batter onto the griddle. Cook until bubbles form on the surface, then flip and cook until golden brown on the other side.
<br>
Serve the pancakes with fresh berries, a drizzle of honey, and a sprinkle of chopped nuts for a delicious and healthy breakfast.', '2023-07-05', 300.0, 35.0, 10.0, 12.5, 1);
INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (4, 'Greek Yogurt Parfait', 10, 1, 2, '../img/recipes/4.jpg', '
In a glass or a bowl, layer 1 cup of Greek yogurt.
<br>
Add a layer of mixed berries (strawberries, blueberries, and raspberries).
<br>
Sprinkle 2 tablespoons of granola over the berries.
<br>
Repeat the layers until you reach the top, finishing with a dollop of Greek yogurt on top.
<br>
Drizzle 1 tablespoon of honey over the parfait for sweetness.
<br>
Optional: Garnish with a few mint leaves for freshness.
<br>
Serve immediately and enjoy this quick and healthy Greek Yogurt Parfait!', '2023-07-15', 250.0, 30.0, 15.0, 8.0, 1);
INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (5, 'Grilled Salmon', 20, 2, 2, '../img/recipes/5.jpg', '1. Preheat the grill to medium-high heat.<br>
2. Pat the salmon fillet dry with paper towels and place it on a cutting board.<br>
3. Season both sides of the salmon with salt and black pepper.<br>
4. Brush olive oil over the salmon to prevent sticking.<br>
5. Place the salmon on the preheated grill grates, skin-side down.<br>
6. Grill for about 4-5 minutes per side or until the salmon is cooked to your desired level of doneness.<br>
7. Remove the salmon from the grill and let it rest for a few minutes before serving.', '2023-06-18', 350.2, 2.5, 40.8, 18.3, 2);

INSERT INTO Recipe (id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, carbohydrates, protein, fat, chef)
VALUES (6, 'Vegetable Stir-Fry', 15, 1, 3, '../img/recipes/6.jpg', '1. Wash and prepare assorted vegetables such as bell peppers, broccoli, and carrots. <br>
2. Heat vegetable oil in a wok or large skillet over medium-high heat.<br>
3. Add minced ginger and garlic to the hot oil and sauté for about 30 seconds until fragrant.<br>
4. Add the prepared vegetables to the wok and stir-fry for 3-4 minutes until they are crisp-tender.<br>
5. Drizzle soy sauce over the vegetables and continue to stir-fry for an additional 2 minutes.<br>
6. Adjust the seasoning as needed and ensure all vegetables are evenly coated in the sauce.<br>
7. Remove from heat and serve the vegetable stir-fry immediately. Optionally, garnish with chopped green onions or sesame seeds.', '2023-06-20', 180.7, 20.0, 8.9, 9.5, 3);


-- Insert Statements for NutritionistApproval Table
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (1, '2023-06-16', 4);
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (2, '2023-06-19', 4);
INSERT INTO NutritionistApproval (recipe_id, approval_date, nutritionist_id) VALUES (3, '2023-06-21', 5);

-- Insert Statements for RecipeRating Table
INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-25', 4, 'Delicious!', 8, 1);

INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-26', 5, 'Amazing recipe!', 9, 2);

INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-27', 3, 'Good, but could use more seasoning.', 10, 3);
INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-25', 4, 'This dish was absolutely delicious! The combination of flavors and textures was a delight to my taste buds. I especially loved the use of fresh herbs, which added a burst of freshness to every bite.', 8, 1);

-- Insert Statement 2
INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-26', 5, 'I tried this recipe for a family dinner, and it was a huge hit! The flavors were well-balanced, and the presentation was stunning. The instructions were easy to follow, making the cooking process enjoyable. My family insisted that I add it to our regular dinner rotation.', 10, 3);

-- Insert Statement 3
INSERT INTO RecipeRating (rating_date, rating_value, comment, user_id, recipe_id)
VALUES ('2023-06-27', 3, 'While this recipe was good, I felt it could use a bit more spice to suit my taste preferences. The cooking instructions were clear, and the final result was satisfying. I might experiment with additional seasonings next time. Overall, a decent dish.', 6, 5);


-- Insert Statements for CookingTechnique Table
INSERT INTO CookingTechnique (name)
VALUES ('Grilling');

INSERT INTO CookingTechnique (name)
VALUES ('Sautéing');

INSERT INTO CookingTechnique (name)
VALUES ('Braising');

-- Insert Statements for RecipeCookingTechnique Table
INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (1, 'Sautéing');

INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (2, 'Sautéing');

INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique)
VALUES (3, 'Braising');

-- Insert Statements for FoodCategory Table
INSERT INTO FoodCategory (name) VALUES ('Meat');
INSERT INTO FoodCategory (name) VALUES ('Protein');
INSERT INTO FoodCategory (name) VALUES ('Dairy');

-- Insert Statements for RecipeCategory Table
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Pasta', 1);
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Protein', 2);
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Dairy', 3);
INSERT INTO RecipeCategory (category, recipe_id) VALUES ('Dairy', 2);


-- Insert Statements for RecipeDietaryPref Table
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Mediterranean', 1);
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Keto', 2);
INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES ('Paleo', 3);

-- Insert Statements for Ingredient Table

INSERT INTO Ingredient (id, name) VALUES 
(1, 'Tomato'),
(2, 'Chicken Breast'),
(3, 'Olive oil'),
(4, 'Bacon'),
(5, 'Onions'),
(6, 'Carrots'),
(7, 'Celery sticks'),
(8, 'Garlic cloves'),
(9, 'Beef'),
(10, 'Tomato purée'),
(11, 'Beef stock cube'),
(12, 'Red chilli'),
(13, 'Red wine'),
(14, 'Fettuccine'),
(15, 'Heavy cream'),
(16, 'Parmesan cheese'),
(17, 'Unsalted butter'),
(18, 'Nutmeg'),
(19, 'Whole wheat flour'),
(20, 'Baking powder'),
(21, 'Low-fat milk'),
(22, 'Greek yogurt'),
(23, 'Honey'),
(24, 'Coconut oil'),
(25, 'Fresh berries'),
(26, 'Chopped nuts'),
(27, 'Granola'),
(28, 'Salmon fillet'),
(29, 'Bell peppers'),
(30, 'Soy sauce'),
(31, 'Brocolli');




-- Insert Statements for Macronutrient Table
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Protein', 4.0);
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Carbohydrate', 4.0);
INSERT INTO Macronutrient (name, kcal_per_gram) VALUES ('Fat', 9.0);

-- Insert Statements for IngredientMacronutrient Table
INSERT INTO IngredientMacronutrient (quantity_g, ingredient_id, macronutrient) VALUES 
(10, 1, 'Carbohydrate'), (2, 1, 'Protein'), (0.5, 1, 'Fat'),
(0, 2, 'Carbohydrate'), (31, 2, 'Protein'), (3.6, 2, 'Fat'),
(0, 3, 'Carbohydrate'), (0, 3, 'Protein'), (13.5, 3, 'Fat'),
(0, 4, 'Carbohydrate'), (3, 4, 'Protein'), (6.3, 4, 'Fat'),
(14, 5, 'Carbohydrate'), (1, 5, 'Protein'), (0.1, 5, 'Fat'),
(12, 6, 'Carbohydrate'), (1, 6, 'Protein'), (0.3, 6, 'Fat'),
(3, 7, 'Carbohydrate'), (0, 7, 'Protein'), (0.1, 7, 'Fat'),
(15, 8, 'Carbohydrate'), (3, 8, 'Protein'), (0.5, 8, 'Fat'),
(0, 9, 'Carbohydrate'), (20, 9, 'Protein'), (20, 9, 'Fat'),
(30, 10, 'Carbohydrate'), (3, 10, 'Protein'), (0.5, 10, 'Fat'),
(0, 11, 'Carbohydrate'), (0, 11, 'Protein'), (0, 11, 'Fat'),
(3, 12, 'Carbohydrate'), (1, 12, 'Protein'), (0.1, 12, 'Fat'),
(3, 13, 'Carbohydrate'), (0, 13, 'Protein'), (0, 13, 'Fat'),
(75, 14, 'Carbohydrate'), (8, 14, 'Protein'), (1, 14, 'Fat'),
(3, 15, 'Carbohydrate'), (2, 15, 'Protein'), (50, 15, 'Fat'),
(2, 16, 'Carbohydrate'), (20, 16, 'Protein'), (15, 16, 'Fat'),
(0, 17, 'Carbohydrate'), (0, 17, 'Protein'), (82, 17, 'Fat'),
(2, 18, 'Carbohydrate'), (0, 18, 'Protein'), (1, 18, 'Fat'),
(86, 19, 'Carbohydrate'), (16, 19, 'Protein'), (1.6, 19, 'Fat'),
(48, 20, 'Carbohydrate'), (1, 20, 'Protein'), (0, 20, 'Fat'),
(12, 21, 'Carbohydrate'), (8, 21, 'Protein'), (0.4, 21, 'Fat'),
(6, 22, 'Carbohydrate'), (4, 22, 'Protein'), (10, 22, 'Fat'),
(17, 23, 'Carbohydrate'), (0.1, 23, 'Protein'), (0, 23, 'Fat'),
(0, 24, 'Carbohydrate'), (0, 24, 'Protein'), (14, 24, 'Fat'),
(5, 25, 'Carbohydrate'), (0.5, 25, 'Protein'), (0.5, 25, 'Fat'),
(3, 26, 'Carbohydrate'), (1, 26, 'Protein'), (6, 26, 'Fat'),
(30, 27, 'Carbohydrate'), (3, 27, 'Protein'), (3, 27, 'Fat'),
(0, 28, 'Carbohydrate'), (22, 28, 'Protein'), (13, 28, 'Fat'),
(6, 29, 'Carbohydrate'), (1, 29, 'Protein'), (0.3, 29, 'Fat'),
(3, 30, 'Carbohydrate'), (2, 30, 'Protein'), (0, 30, 'Fat'),
(12, 31, 'Carbohydrate'), (3, 31, 'Protein'), (0.3, 31, 'Fat');

-- Insert Statements for IngredientRecipe Table
INSERT INTO IngredientRecipe VALUES 
(200, 'grams', 1, 1),
(10, 'ml', 3, 1),
(40, 'grams', 4, 1),
(38, 'grams', 5, 1),
(200, 'grams', 6, 1),
(50, 'grams', 7, 1),
(10, 'grams', 8, 1),
(300, 'grams', 9, 1),
(10, 'ml', 10, 1),
(100, 'grams', 11, 1),
(300, 'grams', 12, 1),
(200, 'ml', 13, 1),
(300, 'grams', 2, 2),
(10, 'ml', 3, 2),
(400, 'grams', 14, 2),
(200, 'ml', 15, 2),
(50, 'grams', 16, 2),
(50, 'grams', 17, 2),
(10, 'grams', 18, 2),

(150, 'grams', 19, 3),
(1, 'teaspoon', 20, 3),
(150, 'ml', 21, 3),
(100, 'grams', 22, 3),
(20, 'ml', 23, 3),
(5, 'grams', 24, 3),
(50, 'grams', 25, 3),
(20, 'grams', 26, 3),
(30, 'grams', 27, 3),

(200, 'grams', 28, 4),
(100, 'grams', 29, 4),
(10, 'ml', 30, 4),
(300, 'grams', 29, 5),
(20, 'ml', 31, 5),
(15, 'ml', 3, 6),
(100, 'grams', 5,6),
(200, 'grams', 6,6),
(50, 'grams', 29,6),
(20, 'ml', 30,6),
(200, 'ml', 31,6);

-- Insert Statements for IngredientAllergyIntolerance Table
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (1, 'Peanuts');
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (2, 'Shellfish');
INSERT INTO IngredientAllergyIntolerance (ingredient_id, allergy_intolerance) VALUES (3, 'Gluten');

-- Insert Statements for PlanRecipe Table
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Monday', 1.5, 'Lunch', 1, 1);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES ('Wednesday', 2.0, 'Dinner', 2, 2);
INSERT INTO PlanRecipe (day_week, portion, time_meal, plan_id, recipe_id) VALUES 
('Friday', 1.0, 'Breakfast', 3, 3),
('Monday', 1.0, 'Breakfast', 4, 4),
('Tuesday', 1.0, 'Breakfast', 4, 3),
('Wednesday', 1.0, 'Breakfast', 4, 4),
('Thursday', 1.0, 'Breakfast', 4, 3),
('Friday', 1.0, 'Breakfast', 4, 3),
('Saturday', 1.0, 'Breakfast', 4, 4),
('Sunday', 1.0, 'Breakfast', 4, 4),

 ('Monday', 1.0, 'Lunch', 4, 1),
 ('Tuesday', 1.0, 'Lunch', 4, 2),
('Wednesday', 1.0, 'Lunch', 4, 5),
('Thursday', 2, 'Lunch', 4, 6),
 ('Friday', 0.5, 'Lunch', 4, 2),
('Saturday', 1.0, 'Lunch', 4, 5),
('Sunday', 1.0, 'Lunch', 4, 6),


-- Insert Statement 1
('Monday', 1.0, 'Dinner', 4, 5),

-- Insert Statement 2
('Tuesday', 1.0, 'Dinner', 4, 6),

-- Insert Statement 3
('Wednesday', 1.0, 'Dinner', 4, 1),

-- Insert Statement 4
('Thursday', 2, 'Dinner', 4, 2),

-- Insert Statement 5
('Friday', 0.5, 'Dinner', 4, 5),

-- Insert Statement 6
('Saturday', 1.0, 'Dinner', 4, 6),

-- Insert Statement 7
('Sunday', 1.0, 'Dinner', 4, 1);

