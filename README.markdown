# The Spectrum Members Ensemble

The Spectrum Members ensemble includes a modified workspace for Symphony 2.0.5. This ensemble adds to the Spectrum theme provided in the [official workspace repository](http://github.com/symphony/workspace). The main difference here is that there are three additional pages:

- Members
- Register
- Login

### Home

<a href="http://www.flickr.com/photos/bauhouse/3766014852/" title="spectrum-members-home by bauhouse, on Flickr"><img src="http://farm4.static.flickr.com/3531/3766014852_a593d3e243_o.png" width="749" height="905" alt="spectrum-members-home" /></a>

### Register

<a href="http://www.flickr.com/photos/bauhouse/3765221029/" title="spectrum-members-registration by bauhouse, on Flickr"><img src="http://farm4.static.flickr.com/3570/3765221029_409bf176bc_o.png" width="749" height="814" alt="spectrum-members-registration" /></a>

### Login

<a href="http://www.flickr.com/photos/bauhouse/3766014962/" title="spectrum-members-login by bauhouse, on Flickr"><img src="http://farm4.static.flickr.com/3500/3766014962_2fb173989b_o.png" width="749" height="661" alt="spectrum-members-login" /></a>

### Retrieve Password

<a href="http://www.flickr.com/photos/bauhouse/3765220793/" title="spectrum-members-retrieve-pw by bauhouse, on Flickr"><img src="http://farm3.static.flickr.com/2587/3765220793_1b695e82d7_o.png" width="749" height="661" alt="spectrum-members-retrieve-pw" /></a>

### Members

<a href="http://www.flickr.com/photos/bauhouse/3766015174/" title="spectrum-members-logged-in by bauhouse, on Flickr"><img src="http://farm3.static.flickr.com/2589/3766015174_5535a55918_o.png" width="749" height="399" alt="spectrum-members-logged-in" /></a>


## Dependencies

This ensemble requires the following extensions in order for the Members extension to manage the registration, login and access control:

- Advanced Symphony Database Connector Extension (<http://github.com/pointybeard/asdc/tree/master>)
- Members Extension (<http://github.com/bauhouse/members/tree/master>)
- Configuration Accessor Class (<http://github.com/bauhouse/library/tree/master>)
- Reflection Link Field Extension (<http://github.com/rowan-lewis/reflectionfield/tree/master>)
- Export Ensemble Extension - Modified for the Members Extension (<http://github.com/bauhouse/export_ensemble/tree/members>)

These are included in the repository as extensions.

## Known Issues

This ensemble is a work in progress. The registration and login forms are working. The retrieve password form is there, but untested at this point. If anyone wants to help out with this, please test the password retrieval form to see whether the email event is working.

## Install

The Spectrum Members Ensemble repository brings together the [Symphony 2.0.5](http://github.com/symphony/symphony-2/tree/master) core application, the required extensions and the [Spectrum Members workspace](http://github.com/bauhouse/workspace/tree/spectrum-members) to simplify the install process. This installer provides a single ZIP archive or a single Git command to provide all the files necessary for installation. Refer to the README file for the [Spectrum Members workspace](http://github.com/bauhouse/workspace/tree/spectrum-members) for install instructions using Git to bring all the different source repositories together.

### Install from Spectrum Members Ensemble ZIP Archive

Go to the [Downloads](http://github.com/bauhouse/workspace/downloads) page to download the ZIP file. This is the simplest, if you want to avoid using Git altogether.

### Install Spectrum Members Ensemble via Git

This repository has been created to make the installation as simple as possible. A single Git command will provide all that you need:

	git clone git://github.com/bauhouse/sym-spectrum-members.git

That should be all. Install Symphony as usual. (Find the instructions at the [official Symphony 2 repository](http://github.com/symphony/symphony-2).) For convenience, they have been included below:

# Symphony 2 #

- Version: 2.0.5
- Date: 27th July 2009
- Github Repository: <http://github.com/symphony/symphony-2/tree/master>


## Synopsis

Symphony is a `PHP` & `MySQL` based CMS that utilises `XML` and `XSLT` as its core 
technologies. This repository represents version 2.0.5 and is considered stable.

Visit the forum at <http://symphony-cms.com/community/>


## Updating

### Via Git

1. Use the following command to get Extensions up to date:

	git submodule init
	git submodule update

2. Follow normal updating procedure below from step 4.

### Via the old fashioned way

Follow the instructions below if you are updating from Symphony version 2.0 (non Git)

1. Backup `/symphony/.htaccess`.

2. Upload `/symphony`, `index.php` & `update.php`, replacing what is already on your server.

3. Put the backed-up `.htaccess` file into the new `/symphony` folder.

4. Go to `http://yoursite.com/update.php` to complete the update process.

5. Celebrate by shaving your friend's head for charity!


## INSTALLING

### Via Git

1. Clone the git repository to the location you desire using:

		git clone git://github.com/symphony/symphony-2.git
		
	Should you wish to make contributions back to the project, fork the master tree rather than cloning, and issue pull requests via github.

	The following repositories are included as submodules:

	- [Markdown](http://github.com/pointybeard/markdown)
	- [Maintenance Mode](http://github.com/pointybeard/maintenance_mode)
	- [Select Box Link Field](http://github.com/pointybeard/selectbox_link_field)
	- [JIT Image Manipulation](http://github.com/pointybeard/jit_image_manipulation)
	- [Export Ensemble](http://github.com/pointybeard/export_ensemble)
	- [Debug DevKit](http://github.com/symphony/debugdevkit/tree/master)
	- [Profile DevKit](http://github.com/symphony/profiledevkit/tree/master)

3. Run the following command to ensure the submodules are cloned:

		git submodule update --init

4. _(Optional)_ If you would like the [default theme](http://github.com/symphony/workspace/tree) installed as well, 
you will need to use the following command from within the Symphony 2 folder you just created:

		git clone git://github.com/symphony/workspace.git
		
5. Follow normal installation procedure below from step 2.


### Via the old fashioned way

**Note: You can leave `/workspace` out if you do not want the default theme.**

1. This step assumes you downloaded a zip archive from the [Symphony website](http://symphony-cms.com). 
Upload the following files and directories to the root directory of your website:

	- index.php
	- install.php
	- /symphony
	- /workspace
	- /extensions

2. Point your web browser at <http://yourwebsite.com/install.php> and provide
details for establishing a database connection and about your server environment.

3. Jump with both arms up like you're in a car commercial!


## SECURITY

**Secure Production Sites: Change permissions and remove installer files.**

1. For a smooth install process, change permissions for the `root`, `symphony` and `workspace` directories.

		cd /your/site/root
		chmod 777 symphony .
		chmod -R 777 workspace

2. Once successfully installed, change permissions as per your server preferences:

		chmod 755 symphony .

3. Remove installer files (unless you're fine with revealing all your trade secrets):

		rm install.php install.sql workspace/install.sql update.php

4. Dance like it's 1999!