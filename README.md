<h1 align="center">
  <br>
  <a href="https://github.com/Youssef-kobi/Camagru"><img src="https://user-images.githubusercontent.com/52678976/231607667-65362830-e712-47ea-ba20-ac3c3237705a.png" alt="Camagru" width="200"></a>

  <br>
  Image Editing and Sharing Web App
  <br>
</h1>

<h4 align="center">A web application for capturing, editing, and sharing images with basic filters and stickers.</h4>



<p align="center">
  <a href="#introduction">Introduction</a> •
  <a href="#key-features">Key Features</a> •
  <a href="#installation">Installation</a> •
  <a href="#usage">Usage</a> •
  <a href="#screenshots">Screenshots</a> •
  <a href="#credits">Credits</a> •
  <a href="#license">License</a>
</p>

<!-- ![screenshot](https://raw.githubusercontent.com/amitmerchant1990/electron-markdownify/master/app/img/markdownify.gif) -->

## Introduction

Camagru is a web application that allows users to take pictures using their webcam or upload an image, apply basic filters (such as grayscale, sepia, and invert), add stickers to the image, and share the result on a public gallery. The application also allows users to create and edit their profiles, comment on and like other users' images, and receive email notifications for comments and likes.

The backend of the application is built using PHP, a server-side scripting language, and MySQL, a popular database management system. The front-end of the application is built using HTML, CSS, and JavaScript. The application follows the Model-View-Controller (MVC) architecture, which separates the application logic into three interconnected components: the model, the view, and the controller.

The MVC architecture allows for better separation of concerns, making it easier to maintain and modify the application. In addition, the use of PHP and MySQL allows for easy integration with other web technologies and the ability to scale the application to handle larger amounts of data.

Overall, Camagru is a simple yet powerful web application that showcases the capabilities of modern web technologies and provides a fun and engaging experience for users.

## Key Features

- User authentication (signup, login, logout, forgotten password)
- Image capture using webcam or upload
- Applying basic filters (grayscale, sepia, invert)
- Adding stickers to the image
- Creating and editing a user profile
- Commenting and liking images
- Email notifications for comments and likes
- Pagination for the image gallery

## Installation

To install and run this application, you'll need to have **PHP**, **MySQL** and **Apache** web server installed on your computer. Follow these steps:

1. Clone this repository to your local machine using `git clone https://github.com/Youssef-kobi/camagru.git`
2. Move the repository to the web server directory (e.g. `htdocs` for XAMPP, `www` for WAMP)
3. Start your Apache and MySQL services
4. Create a database called `camagru` using phpMyAdmin or any other database management tool of your choice
5. Import the `camagru.sql` file located in the root directory of the project into the `camagru` database
6. Configure the database connection in the `config/database.php` file
7. Run `php -S localhost:8080 -t .` command in the root directory of the project to start the built-in PHP web server
8. Open your web browser and go to `http://localhost:8080` to access the application

## Usage

To use this application, you need to create an account first. Then you can take a picture using your webcam or upload an image from your computer, apply filters, add stickers, and save or share the result. You can also view and comment on other users' images, as well as like and dislike them. You will receive an email notification for each comment and like you receive.

## Screenshots

![Homepage](screenshots/homepage.png)
![Profile Page](screenshots/profile.png)
![Image Editor](screenshots/editor.png)
![Image Gallery](screenshots/gallery.png)

## Credits
This project was developed by Youssef Kobi as part of the 42 School program.

The following libraries were used in this project:

FontAwesome
jQuery
Bootstrap
PHPMailer

## License
This project is licensed under the MIT License - see the LICENSE file for details.
