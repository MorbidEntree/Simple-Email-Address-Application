# Simple Email Address Application
This is a simple contact form to use to take applications for email address creations.
# How To Use
1. Download the .zip of this repository and unzip it on your computer
2. Upload the contents to your web server
3. Edit the `send.php` file to add your reCAPTCHA private key on line 4 (get it from https://www.google.com/recaptcha/intro/index.html)
4. Edit the `apply.php` file to add your reCAPTCHA public key on line 52 (get it from https://www.google.com/recaptcha/intro/index.html)
5. Edit the `tracker.php` file to add your Google Analytics property ID __OR__ remove `<?php include_once("tracking.php") ?>` from `apply.php`
6. Have users go to http://yoursite.com/apply.php
