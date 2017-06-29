<?php require 'templates/header.php' ?>

<h1>Baltazar</h1>
<h2>Welcome to a tiny PHP framework</h2>

<h3>Routes</h3>
<p>
    Go to <i>public/index.php</i> to set up your routes.
    A route takes two arguments - the path and an action.
    The path is the desired uri and the action is basically what should happen when someone visits that path.
    An action can be either a callback or a string containing a controller and a method like so: 'Controller@method'.
</p>
<p>
    You can set up a path with dynamic arguments, e.g you need a route to show a specific user so you create the path 'user/:num'.
    :num will be replaced with a regular expression for a number.
    The action will now recieve any number as an argument, you can now use this number to search the database.
</p>

<h3>Controllers</h3>
<p>
    The controllers live inside <i>app/controllers</i>.
    A controller will gather and prepare all the required data before it is presented to the client or written to the database.
    All controllers should extend the base class 'Controller', the base class has two key methods - render and render_json.
    Controller:render will render a view file (to be found in <i>src/views</i>) with the same name as the calling controller.
    Controller::render_json will output any given data in (you guessed it) json format - good fit for an api!
</p>

<h3>Models</h3>
<p>
    The models (found in <i>src/models</i>) will handle all interaction with your database. Any model should benefit from extending the base class Model.
    Besides the actual connection it also has the most essential queries such as get all records and get record by id.
</p>

<h3>Views</h3>
<p>
    The views are what's being output to the client.
    These files shouldn't be cluttered with logic and calculations, a view should contain mainly plain markup.
    To output dynamic data use the foreach-loop.
    You can also use conditionals but always prefer to keep the views very clean.
    Any calculation that can be done in advance should be so.
</p>

<?php require 'templates/footer.php' ?>