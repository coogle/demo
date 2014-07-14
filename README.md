Coogle Demo Application
=======================

Introduction
------------
This is a demo application of a simple hand-written MVC application for example purposes.

Usage / Install
---------------
The demo application relies on vagrant with virtualbox to load up a virtual machine to run locally. To check it out, you'll need the following:

 - Vagrant [http://www.vagrantup.org/]
 - VirtualBox [http://www.virtualbox.org/]

Once both packages are installed you should be able to clone this repository and then from inside of the root of the clone run to fire up a virtual machine running on 192.168.42.30:

```
$ vagrant up
````

If you'd like to change the IP you can edit the VagrantConfig.json file in the repository prior to running that command.

This application has been tested using the latest version of Chrome, I make no promises that the code has been debugged to work in Firefox and wouldn't be surprised at all if it broke in IE entirely.

The app
-------

As the app loads in vagrant it's going to take awhile, but here's what it's doing:

 - Initializing the VM
 - Installing Zend Server Community Edition (php 5.4)
 - Installing MySQL
 - Setting up the database through application migrations
