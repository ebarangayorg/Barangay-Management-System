# Barangay Management System
A digital system designed to streamline barangay operations, ensuring efficient management of records, services, and community transactions

<p align="center">
  <img width="200" alt="Image" src="https://github.com/user-attachments/assets/a0f0dc0e-e18c-4cd7-9e53-37967fa08570" />
</p>

## Project Overview  
The **Barangay Management System (BMS)** is a software project developed to provide a centralized platform for managing barangay records, transactions, and services. It focuses on improving efficiency, transparency, and accessibility of barangay operations through digital solutions.


### Features  
- **Resident Information Management** – organize and store resident profiles securely.
- **Service Assurance** – ensure reliable delivery of barangay services with reduced delays.
- **Announcements & Calendar** – publish community updates and events.
- **User Role & Security** – implement role-based access control for officials, staff, and residents.


### Snippet System Screenshot
![Home](https://github.com/user-attachments/assets/9b585468-8f13-4319-87e9-0404716700df)

## Visit the Website
[Click Here to Explore](https://barangay-management-system-deployment-production.up.railway.app/)

> **Note:**  
> - Due to system being under development, the features might get an update in the future.
> - Some features may not function as intended, and the site might experience occasional crashes.
> - The system may not be fully responsive across all devices, as it is under development.
>
>  **Account:** Use the default account for admin:
>   
>  | Role     | Email               | Password  |
>  |----------|---------------------|-----------|
>  | Admin    | admin@gmail.com     | admin123  |
>  | Resident | user@gmail.com      | sun123    | 


## Guide To Run
To run the system locally, do the following.
> - **Clone this repository** or download it as a **ZIP file.**
> - When cloning the repository, follow these steps.

### Install Required Software
1. **MongoDB Community Server**
      - Database used by the system
      - You can get it from here. [MongoDB](https://www.mongodb.com/try/download/community)
2. **Composer (PHP Dependency Manager)**
      - You can get it from here. [Composer](https://getcomposer.org/download/)
      - Make sure composer works
         ```bash
          composer --version
         ```
3. **XAMPP (Apache + PHP)**
      - You can get it from here. [Xampp](https://www.apachefriends.org/)
      - Start `Apache`
      - *(MySQL is not required because you're using MongoDB)*
4. **MongoDB PHP Extension (PECL)** 
      - Used so PHP can communicate with MongoDB.
      - You can get it from here. [PECL Package](https://pecl.php.net/package/mongodb)
      - The `php_mongodb.dll` must be placed inside this file location:
         ```bash
          xampp/php/ext/
         ```
      - Then add this line to `php.ini` 
         ```bash
          extension=mongodb
         ``` 
  
5. Delete the `vendor/` folder and `composer.lock` file in the project and replace it using this command in terminal
     ```bash
      composer install
     ```
6. Create database `bms_db` on MongoDB Compass, add a collection `users`
     - **Database Name:** *bms_db*
     - **Collection:** *users* 
     - Open **Mongo Shell** on MongoDB Compass and *do this command*
         ```bash
          use bms_db
         
          db.users.insertOne({
            email: "admin@gmail.com",
            password: "admin123",
            role: "Barangay Staff",
            created_at: new Date()
          })
         ```
    - Paste the *password* on the `hash_password.php` file in the project, and run this on terminal
         ```bash
          cd backend
          php hash_password.php
         ```
    - Copy the **New Hash Password** and replace the password `admin123` on the MongoDB collection
        >  **Note:** This will set a default account for admin:
        >   
        >  | Role  | Email             | Password  |
        >  |-------|-------------------|-----------|
        >  | Admin | admin@gmail.com   | admin123  |
  

## Collaborators Of Project
<br>
<p align="center">
  <a href="https://github.com/Gabecx">
    <img src="https://github.com/Gabecx.png" width="100"">
  </a>
  <a href="https://github.com/ZarateHarry">
    <img src="https://github.com/ZarateHarry.png" width="100">
  </a>
  <a href="https://github.com/f8-luv">
    <img src="https://github.com/f8-luv.png" width="100">
  </a>
  <a href="https://github.com/fluxxxe">
    <img src="https://github.com/fluxxxe.png" width="100">
  </a>
  <a href="https://github.com/lurxdel">
    <img src="https://github.com/lurxdel.png" width="100">
  </a>
</p>
<br>

### Acknowledgment  
We are grateful to our instructors for their guidance and support throughout the development of this project. This work reflects our learning journey and the collaborative efforts of the team.  


## Support Me
If you like my work or find it helpful, you can support me by:

![Give Star](https://img.shields.io/badge/Give%20⭐️-F7DF1E?style=for-the-badge&logo=github&logoColor=black)
![Follow](https://img.shields.io/badge/Follow-1DA1F2?style=for-the-badge&logo=twitter&logoColor=white)
![Collaborate](https://img.shields.io/badge/Collaborate-6CC24A?style=for-the-badge&logo=githubactions&logoColor=white)


## Disclaimer 
<div align="center"> 
  We do not own the images, names, information or references included in this project they are used purely as placeholders. <br> 
  All trademarks, service marks, trade names, and other intellectual property rights belong to their respective owners.  <br><br>

  Made with 💗 by <a href="https://github.com/lurxdel"><strong>Lurxdel</strong></a>
</div>
