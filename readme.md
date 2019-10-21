# Cutcloud

Cutcloud was originally created as a Final year project for my Foundation Degree, as a mean to improve my skills in web programming and system design, and it has revealed to be a useful tool for the business currently using it. 
It consist of 4 main parts: 
<ul>
    <li>the home page, where the admin can update all the users through posts</li>
    <li>the rota, that can be written as a draft, visible only to the admins, or public, for all users</li>
    <li>the SOPs and menu descriptions, where files containing those info are uploaded</li>
    <li>and a user administration page, where user can change email or password, and admin can also edit, add or destroy users</li>
</ul>

## Info

This web application was created using Laravel as back end php framework and bootstrap as styling tool.

## How to make it suit your needs

* In order to add Admin user, this will need to be registered from cmd, as there is no view available to do so to avoid damage coming from inattentive users. the fields to complete are specified in Controllers/Admin/RegisterController.php
* If the positions used in your workplace are named differently than in the app, you can modify them. To do so, they need to change in several places
  * In the views at:
    * admin/manageAccounts/editUser.blade.php - here you will find a list with all the positions that needs to be changed when editing a user
    * auth/register.blade.php - here you will find a list with all the positions that needs to be changed when registering a user
  * In the controllers at:
    * RotaController.php - in the show(), update() and pdf() functions, in the orderByRaw SQL query
    * DraftController.php -  - in the show() function, in the orderByRaw SQL query
* if you whish the rota to start from monday rather than on sunday, you can easily do so bu changing the $start variable in RotaController.php and DraftController.php passed as argument for the function week_dates()

## How to use it

* First, in order to use it, you need to set the .env file in the main folder with your server data, the title of the application, email     server and so on
* An administrator can enrol users from the 'Register New User' page, with name, surname, position, email and password. The password is set by default to London123
