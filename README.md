# taste-buds
Web and DataBase Project for Recipe and Nutrition System

## Steps to Run
Make sure your directory is based on the taste-buds folder.

Assuming you have Docker installed, make sure your Docker daemon is currently running:
In Mac and Windows:
- If you have Docker Desktop, initialize it. This will run Docker Daemon
In Linux, it should start automatically, but if you want to start manually, run:
```bash
sudo systemctl start docker
```

When docker is set up, build the container with the following commands:
```bash
cd src
docker compose build 
```
After running this command, if no changes were made on the docker file, you can cimply run the next commands in the following times, assuming you are on the src directory.

To run, simply perform the following:

```bash
docker compose up
```
## Database issues

If you are facing any problems accesing the items in the database please follow these steps:
```
1 - Make sure you have Sqlite installed and available in the command line (see https://gflcampos.github.io/ESIN/_howto/sqlite/ )
2 - Change your directory to the taste-buds/src/sql folder
3 - Run your sqlite3 program in this directory using the commands:
(Windows) sqlite3.exe database.db
(Mac and Linux) sqlite3 database.db

4 - run the following command on the sqlite3 terminal
.read database.sql
```

## Relevant credentials for testing
Log in as the following users to test the different roles

### Common User
```bash
username: emily_wilson
pasword: 12345678
```
### Chef
```bash
username: john_doe
pasword: 12345678
```

### Nutritionist
```bash
username: sara_miller
pasword: 12345678
```

## Permissions of pages

| Page                     | Permission                                                    | Done |
| ------------------------ | ------------------------------------------------------------- | ---- |
| 404                      | Everyone                                                      | &check; |
| Profile                  | Session User                                                  |  &check; |
| User Profile             | Logged In User                                                |  &check;    |
| Chef Profile             | Logged In User                                                |   &check;   |
| Nutritionist Profile     | Logged In User                                                |   &check;   |
| Recipe Index             | Everyone                                                      | &check;  |
| Recipe Description       | Everyone                                                      | &check; |
| Add Plan                 | Nutritionist                                                  | &check;  |
| Add Plan Recipe          | Nutritionist                                                  | &check; |
| Add Recipe               | Chef                                                          | &check;  |
| All Recipe Ratings       | Everyone                                                      | &check;  |
| Change Password          | Own User                                                      |  &check; |
| Change Profile           | Own User                                                      | &check; |
| Register Common User     | Not logged in user that selected Common User on Registration   | &check;  |
| Formation                | Not logged in user that selected Chef or Nutritionist on Registration | &check;  |
| Login                    | Not logged in user                                            | &check;  |
| Messages                 | Session User                                                  |  &check; |
| People Index             | Logged in user                                                | &check;  |
| Plan                     | Nutritionist that made the plan or Common User who's assigned to the plan | &check;  |
| Registration             | Not logged in user                                            | &check;  |

## Main Features and Roles:

### Any Logged In User

- View and update own profile information.
- Browse the Recipe Index to discover recipes.
- Read detailed descriptions of recipes on Recipe Description pages.
- Change own password.
- Access the Messages page and Message any user.

### Common User
- All features available to regular users.
- View al the plans created for them
- Acess the recipes in a plan

### Nutritionist

- All features available to regular users.
- Create new nutrition plans using Add Plan.
- Add recipes to nutritional plans, calculating the nutritional information automatically.

### Chef

- All features available to regular users.
- Contribute new recipes using Add Recipe.

### Outside User (Not Logged In)

- View recipes in the Recipe Index.
- Read detailed descriptions of recipes on Recipe Description pages.
- Register for a new account as a Common User, Chef or Nutritionist.
- Browse user profiles.
- Access the Login page.

