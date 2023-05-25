## FrontEnd Members
[deployment page](https://softwareengineeringubd.github.io/Team-Style-Software-Engineering)

**Eric**
**Qayyum**
**Haziq**
**Wajihah**
**Wee**

## Backend Notes __
The Gmail account associated with the GitHub repository, Firebase, and MongoDB owner is softengineerubdjan2023student@gmail.com __
Login to the Google Account in your browser and choose the "Connect with Google" option to login to these website. __
 __
Email benglei03606@gmail.com if the password is ever lost. __
 __
 __
**Dependencies Setup (Windows):** __
MAKE SURE THE VERSION ARE ALL COMPATITABLE or just follow my versions below __
 __
1. Install XAMPP PHP 8.1.** https://www.apachefriends.org/download.html __
 __
2. Install Xdebug (Use the wizard to get your ) https://xdebug.org/wizard __
    Note: the wizard will need you to type "php -i" into cmd to get your php information. __
    This will require you to set the php installation folder as a system environment variable. typically "C:\xampp\php" __
    The wizard will provide you the download link and installation instructions. __
    DO NOT CLOSE this page. It also contains important information needed for later. __
    Namely: Architecture and Thread Safe Build info. __
     __
3.  Install Composer (use installer) https://getcomposer.org/download/ __
 __
4.  Install gRPC 1.43.0 https://pecl.php.net/package/gRPC/1.43.0/windows __
    Note: ensure that the Architecture and Thread Safe Build matches the information given by the Xdebug wizard. __
    Place downloaded "php_grpc.dll" in your php's ext folder.  typically "C:\xampp\php\ext" __
    Add the line "extension=php_grpc.dll" to your php.ini file. __
     __
5. Install MongoDB 1.13.0 dll extension https://pecl.php.net/package/mongodb/1.13.0/windows __
    Note: The process is similar to installing gRPC. __
    Use this guide if you are stuck: https://www.geeksforgeeks.org/how-to-install-mongodb-driver-in-php/ __
     __
     __
**Get a Free IDE Student License for PHPStorm Here:** __
https://www.jetbrains.com/community/education/#students __
 __
**PHP IDE setup:** __
This guide uses PHPStorm IDE, feel free to use other IDEs __
1. Install PHPStorm IDE __
2. Link GitHub account with PHPStorm and clone the repository https://www.jetbrains.com/help/phpstorm/manage-projects-hosted-on-github.html#clone-from-GitHub __
4. Integrate XAMPP with PHPStorm https://www.jetbrains.com/help/phpstorm/installing-an-amp-package.html#integrating-xampp __
6. *IMPORTANT* Complete Composer setup by running 'composer install' in the IDE's terminal __
7. (Optional) Setup the IDE to automatically run tests using the test folder after commits https://www.jetbrains.com/help/phpstorm/performing-tests.html#run-tests-after-commit __
 __
For Visual Studio Users: __
    Configure Xampp and Visual Studio Code to Work Together __
    https://www.youtube.com/watch?v=QmUyB7uYL1w __
 __
**Guides and Documentations** __
 __
PHP Styleguide: __
https://codeigniter.com/userguide3/general/styleguide.html#php-style-guide __
 __
Autoloader standards: __
https://www.php-fig.org/psr/psr-4/ __
 __
Firestore Documentation: __
https://firebase.google.com/docs/firestore __
 __
**Homework for backend team:** __
 __
PHP Autoloading Using Namespaces - Easy and Simple! __
https://www.youtube.com/watch?v=f46svjvMNI4 __
 __
Firebase PHP __
https://www.youtube.com/playlist?list=PLr_acfJGVciqSYT0IwZk6Pg5rVF8Q9UPJ __
 __
Configuring Content Root of PHPStorm __
https://www.jetbrains.com/help/phpstorm/configuring-folders-within-a-content-root.html __
 __
Generating Unit Tests in PHPStorm __
https://www.jetbrains.com/help/phpstorm/using-phpunit-framework.html#generate_phpunit_test_for_a_class_in_a_separate_file __
 __
Unit Testing with PHP Unit __
https://www.youtube.com/watch?v=a5ZKCFINUkU __
 __
Lets Build an IoC Container using PHP __
https://www.youtube.com/watch?v=HOVWXa7HBZY __
 __
Rest API: __ __
https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000 __
https://www.allphptricks.com/create-and-consume-simple-rest-api-in-php/ __
https://developer.okta.com/blog/2019/03/08/simple-rest-api-php#implement-the-php-rest-api __
