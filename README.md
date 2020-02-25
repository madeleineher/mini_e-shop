# Mini E-Shop 
A rush project that consists of an e-shop made in two days in a team of two for a 42 PHP bootcamp.

# Installation
 - Download bitnami: 
    - MacOS : https://bitnami.com/stack/mamp/installer
    - In setup de-selct every component except for phpmyadmin
    - Configure apache2 document
    - Delete the `htdocs` folder in the `apps/phpadmin` directory and clone this repository in this directory under the folder name `httpsdocs` 
 - Modify line 8 in install.php file with the your root folder
 ```
    $ $str = "localhost,root,mamproot,database";
 ```
  - Launch with index.php
