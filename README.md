#Excel Reader Chart Producer


## Requirements

**Triple Helix Corporation Programmer Evaluation Exercise:**

Attached you will find an excel file.  Your task is to create a simple user interface 
that allows a user to login and upload/parse this file to the system.
 
The file should take the contents of the excel file and publish a graph
of the data in a pie chart using any charting software library you feel
appropriate.  The pie chart should include the chart title, data labels, 
and %-ages listed on the chart.  The parsing function should have error 
trapping to prevent users from uploading bad data.
 
**Specific Objectives:**


* Code this task using a LAMP stack ONLY.
* Provide fully documented source code when completed.
* Provide a URL where your sample project is located for evaluation
(include username/password to access the demo on your target system)  
* User/Pass should be encrypted and authenticated against a database 
record in a user table.
* Describe the encryption scheme you used to protect the password and
why you used it.
* Provide# of hours it took to complete this task.


##Results
* **Interpretation**
	* simple login form
	* main page consists of form for uploading
	* upload form is housed in an iframe
	* process uploads file in a post back inside the frame
	* then reneders the output as json which is then
	* used to perfrom an ajax request to read and interpret the new file
	* deletes the file once collected the data
	* uses the data to present front end chart inside a div
* First create the mysql database and run the **install.sql** file to insert tables and add username
	* default credentials are:
	* Username: admin
	* Password: trippleH	
* Use of **CodeIgniter MVC framework** - choice was made for simple, quick to deploy mini application.  Framework allowed for easy to plug in database operations, file uploads, custom and third party libraries, etc...  In addition I have personal familiarity with it so it was able to use very quickly.
* **FusionCharts** incorporate for simple pie chart - I have worked with it in the past, and it plugs in real easy.
* **PHP Excel** I happened to have built a simple excel too for converting excel worksheets into yml data structures, so this was half built already :) For simplicity's sake, I stuck with the support of pre 2007 excel files (.xls).  If this were a real event, attention would have been made to support the newest excel file format (.xlsx)
* **Bootstrap** I already had a small template built using bootstrap, so I altered a few things and brought it into this app for a nice look and feel.
* **files structure** 
	* appliction - custom code for MVC framework
		*  config - configuation variables
		*  controllers - php code for handling incoming http requests
		*  helpers - collection of simple custom functions used throughtout the framework
		*  libraries - 2 custom libraries 
		*  third_party - PHP Excel is stored in here
		*  views - HTML front end files
	*  assets - location of front end files for javascript and css.  bootstrap, jquery, fusioncharts live in this folder. - Main Javascript file is in /assets/js/application.js  
	*  uploads - (folder needs chmod 777) location of xls uploads.  System will delete the file once its done interpreting the file.
	*  samples - some of the files I used to test the app with.  
*  **Password Encryption** Normally, in the past I have used a simple md5 php function to perform one way encryption, but this method has been considered more outdated and the use of the crypt function is the preferred path moving forward.  I used the blowfish pattern as it incorporated the use of an encryption key and provided a sufficent encryption method.  Other methods used int he past were the mysql password function, but this has also been considered outdated as well.

##Testing:

You can test the application at this address:
[http://s622929687.onlinehome.us/](http://s622929687.onlinehome.us/)