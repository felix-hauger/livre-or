# Content

Guestbook built with the pages :

-index.php (home page)
-incription.php (to register user)
-connexion.php (for a registered user to log in)
-profil.php (to change registered user infos)
-livre-or.php (the guestbook page - list users comments)
-commentaire.php (for registered users to add comments)

All request are made with PDO (PHP Data Object)


## index.php

The Home Page. 

If logged, display a welcoming message with the user login from the database, using the user id.


## inscription.php

To register users.

On form submit, executes multiples control structures to display various errors for the user :

-if all inputs aren't filled
-if user login is already in the database
-if the password & the password confirmation are different


HTML chars, & spaces before & after the sent string are removed.

If all conditions are true, the user is registered and his infos are sent the database.


## connexion.php

For registered users to log in.

On form submit, executes multiples control structures to display various errors for the user :

-if all inputs aren't filled
-if user login is not in the database OR if the password is incorrect

HTML chars, & spaces before & after the sent string are removed.

If all conditions are true, $_SESSION variables is_logged & logged_user are set, and the logged user is redirected to index.php


# TODO

Add some try catch for queries that modifies the database