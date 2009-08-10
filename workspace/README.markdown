# Spectrum Members Workspace

The Spectrum workspace is a modified workspace for Symphony 2.0.6. This ensemble adds to the Spectrum theme provided in the [official workspace repository](http://github.com/symphony/workspace). The main difference here is that there are three additional pages:

- Members
- Register
- Login

## Dependencies

This ensemble requires the following extensions in order for the Members extension to manage the registration, login and access control:

- Advanced Symphony Database Connector Extension (<git://github.com/pointybeard/asdc/tree/master>)
- Members Extension (<git://github.com/bauhouse/members/tree/master>)
- Configuration Accessor Class (<git://github.com/bauhouse/library/tree/master>)
- Reflection Link Field Extension (<http://github.com/rowan-lewis/reflectionfield/tree/master>)
- Export Ensemble Extension - Modified for the Members Extension (<http://github.com/bauhouse/export_ensemble/tree/members>)

These are included as submodules in the Spectrum Members Core repository.

## Known Issues

This ensemble is a work in progress. The registration and login forms are working. The retrieve password form is there, but untested at this point. If anyone wants to help out with this, please test the password retrieval form to see whether the email event is working.

## Install from Spectrum Members Ensemble ZIP Archive

There are a few ways to install this workspace. Depending on what you prefer, you might like to simply download a complete ZIP file. Go to the downloads area to download the ZIP file, which contains the Symphony 2.0.6 core application, all required extensions, and the Spectrum workspace. This is the simplest, if you want to avoid using Git altogether.

## Install Spectrum Members Ensemble via Git

Refer to the [bauhouse/sym-spectrum-members](http://github.com/bauhouse/sym-spectrum-members) or the [official Symphony 2 repository](http://github.com/symphony/symphony-2) for the complete install instructions for Symphony 2. This install may be slightly different than the official symphony-2 repository, as I have updated extensions to the latest releases as of 25 July 2009.

	git clone git://github.com/bauhouse/sym-spectrum-members.git

That should be all. Install Symphony as usual. (Find the instructions at the [official Symphony 2 repository](http://github.com/symphony/symphony-2).)

## Install Symphony and Spectrum Workspace via Git

The Spectrum Members Ensemble repository brings together the Symphony 2.0.6 core application, the required extensions and the Spectrum workspace to simplify the install process. If you'd rather put everything together yourself, the process looks something like this:

	git clone git://github.com/symphony/symphony-2.git

Initialize the submodules

	git submodule init

Update the submodules

	git submodule update
	
At this point, all the files required for a clean install are ready. The second branch that has been included as a submodule is the workspace, which is referring to a specific commit of the spectrum-members branch of my fork of the Symphony workspace repository. To clone this fork separately, use the following commands:

	git clone git://github.com/bauhouse/workspace.git
	cd workspace
	git checkout -b spectrum-members
	git pull origin spectrum-members

