Haile-Hotel-System
This project is a Web-Based Intelligent Hotel Management and Recipe Recommendation System for Haile Hotel. It combines advanced hotel operation tools with a payment system and personalized recipe suggestions to streamline management and enhance the guest experience.

Features
Hotel Management System
Room Reservations

Food Ordering

Billing and payment handling using Chapa Pay

Admin Panel:

Manages users, rooms, and reports

Head Chef Module:

Manages orders and menu

Waiter Module:

Takes orders, serves guests

Finance Module:

Manages transactions and financial reports

Recipe Recommendation System
Personalized recipes for guests based on:

Content-based filtering

User past data

Trending food orders

Integrated through a Flask API

Technologies Used
Frontend:

Tailwind CSS

CSS

HTML

JavaScript

Backend:

PHP

Database:

MySQL (via XAMPP)

Other Tools:

Composer

Node.js

Database Instructions
To set up the database:

Import the haile.sql file from the database folder into PhpMyAdmin.

Payment System Setup with Ngrok
To integrate the payment system using Ngrok, follow these steps:

Install Ngrok:

Download and install Ngrok from https://ngrok.com/download.

Run Ngrok:

Start Ngrok on your local server's port (e.g., port 80):

bash
ngrok http 80
Copy the generated public URL provided by Ngrok (e.g., https://<random-id>.ngrok.io).

Update URLs in PHP Files:

Open booking.php and bcallback.php, and replace the old Ngrok URL with the new one:

Test Payment Flow:

Ensure that the payment system is properly updated and working with the new URL.

Recipe Recommendation System Setup
To set up and run the Flask API for the recipe recommendation system:

Start the Flask API:

Open recipe recommendation.ipynb, and run all cells to start the Flask server.

Expose the Flask API with Ngrok:

Start Ngrok on the Flask API's port (e.g., port 5000):

bash
ngrok http 5000
Copy the generated public URL provided by Ngrok (e.g., https://<random-id>.ngrok.io).

Update URLs in recommendations.php:

Replace the old Ngrok URL with the new one in recommendations.php:

Verify that the Flask API is working correctly and providing recommendations as expected.
