
# This project is still under development.
    Todo: 
    - Make installation script.
    - Better UI especially for desktop experience.
# easyTemp
This is just a simple web app that you can use to record student temperature for any locations in your institute.

## Features
- #### Ability to add:
    ##### - Locations
    ##### - Students
    ##### - Users
    ##### - Entry/Exit Record  
    ##### - Records can be added by searching students data based on manual input of their identification number or by barcode on their student card.
    ##### - Users Roles and Permissions
    Moderators only have the access to add records of entry and exit.
    Admins can view the entire app including downloading the PDF version of users entry/exit report.

##	Requirements
- A web server (Apache2, Nginx etc)
- PHP 7.4.8 and above
- Self-signed certificate or CA signed certificates if you plan to host this app to be accessible elsewhere.
*getUserMedia() is a powerful feature which can only be used in secure contexts; in insecure contexts, navigator.mediaDevices is undefined, preventing access to [getuserMedia()](https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getUserMedia).*

##	Installation
- Move all the files into your `htdocs` folder or your server directory.
- Edit the `$APP_URL, $APP_URL_ALT and MySQL database` info inside the `config` file.
- Register the Admin user from  `/install` installation wizard.
- You are good to go!

## Dependencies
- [QuaggaJS](https://serratus.github.io/quaggaJS/)
- [FPDF](http://www.fpdf.org/)
- [Multicell for FPDF](https://github.com/gemul/fpdf-multicell-table)

## Licenses
This project is licensed under the MIT License. You may refer to the license file included. Other licenses for libraries that I use is also included in their respective folders.

## Notes
This is just a fun project that I've made and as a beginner project. I'm not an expert in programming as I'm trying to become one. I know that there's a lot of flaws in this system but this is only meant to be used inside a local network. I've tried my best to keep this app safe from any security flaws. And also this app is written in Malay which is the native language in my country. Feedback is also appreciated to improve my skills.
## Connect With Me
- [Website](https://hanisirfan.xyz)
- [LinkedIn](https://linkedin.com/in/hanisirfan)
- [Twitter](https://twitter.com/mhanisirfan)
