# Crankykit: A riff on Kirby Plainkit

## Overview

This is an opinionated version of [Kirby Plainkit](https://GitHub.com/getkirby/plainkit.git) meant to be used on shared hosting plans that allow the user to load files _outside_ the web root directory. It's configured to accommodate [Siteground](https://siteground.com) hosting out of the box, but can be easily adapted to other hosts. There are no symlinks; the only files in the web root directory are those that Kirby requires to be there. Everything else is safely outside the web server's grasp. This was made for my personal use and there are no guarantees it will work for you. Quirks are mine. You're welcome to your own.

## Details

1. This is adapted from the [Public Folder Setup](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup) example in the Kirby Guide. 
2. The public web root directory is called `/public_html` on Siteground. You may need to change this.
3. Two configuration files are included in `/site/config'.  
    * `config.php` allows the panel to be installed on a remote server and changes the page slug for the panel from `myexample.com/panel' to `myexample.com/knockknock`. Seek professional help is that's the slug you want to use.
    * `config.crankykit.test.php` turns on debugging only on a host that answers to the name `crankykit.test`.  Make it your own by changing the name to that works on your development setup.
4. The `.htaccess` file is located in the public web root.  It contains the directive 

    ```Header set Cache-Control "no cache, private"``` 
    
    to minimize the impact of Siteground's dynamic caching on Kirby license validation.
5. The Kirby system files are included as a Git submodule so updating version is more automated. If you just clone this repository you will __not__ automatically download Kirby (the directory will be there, but it will be empty). Navigate into the Kirby directory and issue the command

    ```git submodule init```, 

    then

    ```git submodule update```.

    Any time you need to update the system files, just run the second command (```git submodule update```) again. The Kirby documentation encourages you to delete ```/public_html/media``` any time the Kirby version changes. It will be regenerated as needed.

6. `index.html` is also located in `public_html` and is pictured below. Out of the box, Kirby assumes a flat directory structure.  

    <img width="688" alt="screenshot of index.php" src="https://user-images.githubusercontent.com/284185/165156578-c05be891-641d-44b5-92ba-22588e260044.png">
    
    * Line 7 takes care of determining the name of the public web root.  It doesn't need to be specified anywhere.
    
    * Line 8 is written to determine the _parent_ of the public web root directory. 
      The location of the non-public files are not required to be in the parent of the web root.
      The only thing that's required is that the directory of the non-public files are reachable via a relative path
      from the public web root.
7. The `/media' directory will be created in the public web root. It can be deleted at any time and it will be regenerated as needed.
8. A `/storage` directory has been added as a sibling to `/content` and `/ site` to contain `/accounts`, `/cache`, and `/sessions`.
   These subdirectories should be writable by the web server.
10. An `/assets` directory has been added to the public web root to hold CSS, JS, fonts, and graphics. A basic CSS scaffold is included.
