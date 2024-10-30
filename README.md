# JOBBOARD

## What is the project

The Jobbard project is a fictional school project to link applicant with job offers.
The concept is quite simple.
If you are an applicant you can apply at many offers shown on the app.
Either way, if you are a recruiter, you can post many offers for applicants to apply.

## Here's the tech we used to build this project

- **Frontend :**
  - React
  - Axios
  - HTML/CSS

- **Backend :**
  - Symfony
  - PostgreSQL
  - LexikJWTAuthenticationBundle (handle the JWT tokens)

- **Tools :**
  - VSCode (IDE)
  - Postman (APi tester)
  - Excalidraw (draw maquette)
  - Git (Control and share code)

## Step to go as far we could go

1. **Make the Database** :
   - Create entities and controller by symfony. To store users and offers.
   - Generate token for a valid User

2. **Make the view** :
   - Create a frendly-user interface with react native.
   - Create components and displayed it in pages.

3. **Make the API** :
   - Develop an API RESTful with symfony to handle crud system for offers.

4. **Handling Authentication** :
   - Use the Bundle LexikJWT to create a unique token and allows'em to see their dashboard and apply quicker.

## How to start our project

1. **Git clone the project** :
   - *bash*
   git clone <https://github.com/EpitechMscProPromo2027/T-WEB-501-LYO_2.git>

    ***Please make sure you are on this followed path: user:~/root/Web/T-WEB-501-LYO_2***

2. **Install dependencies** :
    - Open the terminal :
    - shortcut (Ctrl + Alt + T)

***front*** :

- cd jobboard_frontend
- npm install

***back*** :

- Make sure you are in the root project otherwise :
- cd -
- cd jobboard_backend
- composer install
- npm install
3. **Create the database** :
    - ***Stay on the jobboard_backend path***
    - php bin/console doctrine:database:create
    - php bin/console make:migration
    - php bin/console doctrine:migrations:migrate
    - php bin/console doctrine:fixtures:load

4. **Start services** :
    - cd jobboard_frontend
    - npm start
***open another terminal (do not kill the npm server)***
    - cd jobboard_backend
    - symfony server:ca:install
    - symfony server:start

5. **Access the application** :
    - Open your browser and type in the URL : ***http://localhost:3000***.


## Members

- *Estelle Giroud*
- *FLavien Patriarca*
