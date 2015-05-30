# symfony-docker
base symfony project with docker features

# Requirements:
- *nix environnment
- docker installed
- current user in docker group
- php cli enabled
- php 5.4 minimum (for the built in server)

# How to use it
clone this project
<pre>
  git clone git@github.com:jguido/symfony-docker.git
</pre>

Install dependencies
<pre>
  composer install
</pre>

Answer composer's question for the database connection, smtp and others (you can set database information to default, you will need to return to the parameters file after)

After installation with composer finish run

<pre>
  sh run.sh dev
  or
  sh run.sh prod
</pre>

You can specify some options in the sh file

- port       : the external port use for accesing the database
- DOMAIN_NAME: the name of the project
- FILE_NAME  : the name of the folder user for the docker persistence

The script will give you information about the database connection from the docker image

And it runs and built in web server (you can specify the host and port at the end of the script)

Your application will be accessible through 127.0.0.1:8050/app_dev.php

that's all folks
