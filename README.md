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
