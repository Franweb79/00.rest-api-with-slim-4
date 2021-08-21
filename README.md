<h2> <b>THIS IS A SIMPLE REST API BUILT WITH SLIM 4 FRAMEWORK</b> </h2>

<p>This API is intended to be used with learning purposes, and maybe as general backend for future projects</p>
<p><b>You can check it on production here: <a href="https://rest-api-with-slim-4.avanzartewebs.com/" target="_blank">http://rest-api-with-slim-4.avanzartewebs.com/</a></b></p>

<ol>


<li>on .gitignore we will ignore the following folders
<ul>
<li>docs -  because are guides or notes only interesting for a personal use </li>
<li>vendor - because it would make sync much bigger. All those files can be downloaded and installed again through the command <i>"composer install"</i>,  once composer is installed on your equip. for more info please check <a href="https://getcomposer.org/"><b>https://getcomposer.org/</b></a></li>
<li>As we have obfuscated some of the .js files, the non obfuscated files folder will also be added here</li>
<li>The .sql files are of course development versions with fake data connection, the class to connect to database here is of course also a development version. Production version file will be added to .gitignore as well. Latest .swl file is the one with events to add scheduled tasks</li>
</ul>
</li> 
<li>Scheduled tasks are made to reset database once per day, so you can play with it with no problem :) . As they don´t work on my shared server because it would lead to security problems, I did it with CRON jobs. </li>
<li>
    <b>To be improved on next versions:</b>
    <ul>
        <li>config/Item-model.php: for now will only be used a method to insert new items, and will be called on the post-new-item-control.php but maybe in the future we could create methods to getItem (get one item) and getItems (get all items), now that code is done on each route designed for each of those tasks. Maybe that way will be more clean code.</li>
        <li>Also regarding the routes to get all items and one item, now they are opened on a new tab which only shows JSON formatted data. In the future, maybe open them on same tab,with styles and a back button to make navigation more comfortable, like we do now to post a new item. </li>
        <li> Add  possibility of making a request through software like <a href="https://www.postman.com/">postman.</a></li>
    </ul>
</li>

 
</ol>
   
# all rights reserved