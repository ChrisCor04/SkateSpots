# SkateSpots
## Overview
   SkateSpots is a web application that allows users to create accounts, log in, and share skating spots with other people. Users can add spots to the list and view spots others have uploaded. There is a search filter that allows users to look for specific spots or spots around them.

## Features
- **User Registration:** Users can create a new account using a username and password. 
- **User Auth:** Login functionality to use user-specific features.
- **Adding Skate Spots:** Users can submit skate spots by providing the name of the location, the address, and their own name (optional).
- **View Skate Spots:** The program will display a list of all skate spots submitted by other users.
- **Searching Skate Spots:** Users can search for specific keywords filtering the locations they want.
- **Reactive Design:** Interactive user-friendly interface that functions on both mobile devices and desktops.

## Technology Utilized
  - **Frontend:** HTML, CSS, JavaScript 
  - **Backend:** PHP
  - **Server:** Apache
  - **Database:** PostgreSQL

## How to Start
  ### Essentials
  - You need a web server with PHP Support (ex. WAMP, XAMPP)
  - A PostgreSQL database server installed
  - A Composer (composer.json if your using dependencies)

## Installing
  - First Clone the repository
  ```bash
     git clone https://github.com/ChrisCor04/SkateSpots.git
     cd SkateSpots
  ```
  - Set up the database - Create a PostgreSQL database and add the needed variables into the two tables:
  - Add an env.php file and update the database connection details with your PostgreSQL credentials.
  - Start your webserver and acess the app by typing http://localhost/SkateSpots

## How to Use
  - Create an Account at the sign up page (navigate there using the href link at the bottom)
  - Login using the information you just created
  - Click the button depending on whether you want to add or view a spot
  - Type in the name or location of a spot you want to search for

## Improvements
  - I will be improving upon this as time goes on but feel free to mess around with this, contributions arae welcome.

