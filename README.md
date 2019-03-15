<p align="center">
    <h1 align="center">Phone Book</h1>
    <br>
</p>

Phone book is a training project, based on Yii2 advanced template.


FUNCTIONALITY
-------------------

```
frontend (available as your-domain.com)

   sign-up, update profile info
   create and manage contacts
   upload and remove contact's photo
   create and manage groups
   perform search by name, by phone number

backend (available as your-domain.com/admin)
    

    to provide correct authorization in backend, you should execute a database
    migration using the command
    yii migrate --migrationPath=@yii/rbac/migrations

    default admin user (role == admin) is created when the migration /console/migrations/...create_rbac_data is executed
    default authentification data for admin:

    phone => 380(48)424-44-34
    password => 111111

    use it for first logging in /admin. it is strongly recommended to remove default admin user later

    there're ADMIN and MODERATOR roles for users of backend

    ADMIN has permissions to:
        create new ADMIN, MODERATOR, default users
        update user profile, change STATUS (active, non-active) and ROLE (admin, moderator, default user) for all users
        delete MODERATORS and DEFAULT USERS

        to delete ADMIN you have first to CHANGE his role to MODERATOR or DEFAULT user

    MODERATOR has permissions to 
        create, update and delete default users
        change STATUS (active, non-active) for default users

    DELETING USER you delete all his groups (/fromtend/models/Group) and contacts (/frontend/models/Abonent), using FOREIGN KEY option ON DELETE CASCADE in DATABASE
    
    TO start using admin panel just log in your-site/admin and press the "MANAGE" button on the start page