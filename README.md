## FrontEnd Members
[deployment page](https://softwareengineeringubd.github.io/Team-Style-Software-Engineering)

**Eric**
**Qayyum**
**Haziq**
**Wajihah**
**Wee**

## Backend Notes  
The Gmail account associated with the GitHub repository, Firebase, and MongoDB owner is softengineerubdjan2023student@gmail.com  
Login to the Google Account in your browser and choose the "Connect with Google" option to login to these website.  
  
Email benglei03606@gmail.com if the password is ever lost.  
  
  
**Dependencies Setup (Windows):**  
MAKE SURE THE VERSION ARE ALL COMPATITABLE or just follow my versions below  
  
1. Install XAMPP PHP 8.1.** https://www.apachefriends.org/download.html  
  
2. Install Xdebug (Use the wizard to get your ) https://xdebug.org/wizard  
    Note: the wizard will need you to type "php -i" into cmd to get your php information.  
    This will require you to set the php installation folder as a system environment variable. typically "C:\xampp\php"  
    The wizard will provide you the download link and installation instructions.  
    DO NOT CLOSE this page. It also contains important information needed for later.  
    Namely: Architecture and Thread Safe Build info.  
      
3.  Install Composer (use installer) https://getcomposer.org/download/  
  
4.  Install gRPC 1.43.0 https://pecl.php.net/package/gRPC/1.43.0/windows  
    Note: ensure that the Architecture and Thread Safe Build matches the information given by the Xdebug wizard.  
    Place downloaded "php_grpc.dll" in your php's ext folder.  typically "C:\xampp\php\ext"  
    Add the line "extension=php_grpc.dll" to your php.ini file.  
      
5. Install MongoDB 1.13.0 dll extension https://pecl.php.net/package/mongodb/1.13.0/windows  
    Note: The process is similar to installing gRPC.  
    Use this guide if you are stuck: https://www.geeksforgeeks.org/how-to-install-mongodb-driver-in-php/  
      
      
**Get a Free IDE Student License for PHPStorm Here:**  
https://www.jetbrains.com/community/education/#students  
  
**PHP IDE setup:**  
This guide uses PHPStorm IDE, feel free to use other IDEs  
1. Install PHPStorm IDE  
2. Link GitHub account with PHPStorm and clone the repository https://www.jetbrains.com/help/phpstorm/manage-projects-hosted-on-github.html#clone-from-GitHub  
4. Integrate XAMPP with PHPStorm https://www.jetbrains.com/help/phpstorm/installing-an-amp-package.html#integrating-xampp  
6. *IMPORTANT* Complete Composer setup by running 'composer install' in the IDE's terminal  
7. (Optional) Setup the IDE to automatically run tests using the test folder after commits https://www.jetbrains.com/help/phpstorm/performing-tests.html#run-tests-after-commit  
  
For Visual Studio 2022 Users:  
    - We didn't figure how to run PHP codes on VS, Please complete this section if you are a VS user.  
    - Configure Xampp and Visual Studio Code to Work Together https://www.youtube.com/watch?v=QmUyB7uYL1w  
  
**Guides and Documentations**  
  
PHP Styleguide:  
https://codeigniter.com/userguide3/general/styleguide.html#php-style-guide  
  
Autoloader standards:  
https://www.php-fig.org/psr/psr-4/  
  
Firestore Documentation:  
https://firebase.google.com/docs/firestore  
  
**Homework for backend team:**  
  
PHP Autoloading Using Namespaces - Easy and Simple!  
https://www.youtube.com/watch?v=f46svjvMNI4  
  
Firebase PHP  
https://www.youtube.com/playlist?list=PLr_acfJGVciqSYT0IwZk6Pg5rVF8Q9UPJ  
  
Configuring Content Root of PHPStorm  
https://www.jetbrains.com/help/phpstorm/configuring-folders-within-a-content-root.html  
  
Generating Unit Tests in PHPStorm  
https://www.jetbrains.com/help/phpstorm/using-phpunit-framework.html#generate_phpunit_test_for_a_class_in_a_separate_file  
  
Unit Testing with PHP Unit  
https://www.youtube.com/watch?v=a5ZKCFINUkU  
  
Lets Build an IoC Container using PHP  
https://www.youtube.com/watch?v=HOVWXa7HBZY  
  
Rest API:  
https://code.tutsplus.com/tutorials/how-to-build-a-simple-rest-api-in-php--cms-37000  
https://www.allphptricks.com/create-and-consume-simple-rest-api-in-php/  
https://developer.okta.com/blog/2019/03/08/simple-rest-api-php#implement-the-php-rest-api  
