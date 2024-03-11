<p align="center">
  <a href="https://diegopenavicente.com" target="_blank">
    <img src="https://github.com/DiegoPevi05/diegopenavicente-server/blob/main/public/logos/dp.svg" width="200">
  </a>
</p>

# Diego Pena Vicente Backend

Go to the [diegopenavicente](https://www.diegopenavicente.com/server/) to check the panel.

Welcome to the Dashboard Web Management project! This dashboard is designed to serve as a web application for effectively managing the web content for the web DiegoPenaVicente and Clients can manage their web content here in a personalzie way. Here are the key features and details of this application:

- This Backend application is developed to serve as a webpanel to manage Front-End Webs like  [diegopenavicente](https://www.diegopenavicente.com).
- This Dashboard is developed so every client can access to the panel and edit the content on their website. 
- This Dashboard generates the endpoints based on the Authenticated user that logs-in with their credentials.
- Users can review the calendar to check if their payment date is closer, the admin user can review all users that should pay that month, and get all notifications in the home panel of every action made by each user.
- The Admin user can access to end points to manage the front-end page [diegopenavicente](https://www.diegopenavicente.com).
- There is schedule task that execute and review the billing date and if it is a current date send the email to the persons involve.


## Features

- **User-Friendly Interface:** The dashboard boasts a user-friendly interface built with [boostrap](https://getbootstrap.com/), incorporating pre-made components for quick and easy navigation.

- **Insightful Home Panel:** Users can access a comprehensive home panel offering diverse statistical insights into their business operations.

- **Insightful Users Panel:** Admin can control the access of every client to the home panel.

## Dependencies and Libraries

This project relies on the following key dependencies and libraries:

- [guzzlehttp/guzzle](https://packagist.org/packages/guzzlehttp/guzzle)
- [boostrap](https://getbootstrap.com/)

## Installation and Setup Locally/Server

To install the project on your local machine, you can follow these steps:

1. Clone this repository to your local directory.
2. Install project dependencies using the following command:
```
composer install
```
3. If you have limited server resources, consider installing dependencies locally and exporting the vendor folder using the following command:
```
composer dump-autoload
```

4. Create a .env file, take as example the .env.example file, set the credentials of the connection with the database, and the required environment variables described bellow.

5. On this step you should run the migrations in order to have the tables to start the server with the following command:
```
php artisan migrate
```
6. After running migrations you should run the seeds in order to have the admin credetials already set.
```
php artisan db:seed
```
7. Now you should run the following command to start the server.
```
php artisan serve
```
8. The application will start on port 8080

### Envrionment variables
You have to  set the variables in a .env file in the root directory if you plan to build the app for production:
        1.  FRONTEND_URL= Landing page link
        2.  BACKEND_URL_IMAGE= /server/public by default if your server is running 
        3.  ADMIN_USERNAME= admin username credential
        4.  ADMIN_MAIL= admin email credential
        5.  ADMIN_PASSWORD= admin password credential
        6.  API_KEY= You need to set a code that for every API request made you will need to send in the header as X-API-KEY, you can generate the code running the generateApiKey.php file that is in the root of the application.
        7.  MAIL_USERNAME_DP= Default Email of the application
        8.  MAIL_PASSWORD_DP= Default Email password of the application
        9.  MAIL_USERNAME_OTHERS= If you add users you will need to add their email smtp credentials and configure in config/mail.php
        10. MAIL_PASSWORD_OTHERS= If you add users you will need to add their email smtp credentials and configure in config/mail.php
        11. MAIL_HOST= Mail hosting
        12. MAIL_PORT= Mail Service Port
        13. MAIL_FROM_ADDRESS= From address for the default email
        14. DB_HOST= Database host
        15. DB_PORT= Databse port
        16. DB_DATABASE= Databse name
        17. DB_USERNAME= Database username
        18. DB_PASSWORD= Database password

## Screenshots

Here are some screenshots showcasing the dashboard in action:

![Image1](https://github.com/DiegoPevi05/diegopenavicente-server/blob/main/public/dashboard.png?raw=true)

Thank you for exploring the content of this README.md file. If you have any questions or suggestions, please feel free to reach out!
