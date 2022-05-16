# Crankykit: A riff on Kirby Plainkit

## Overview

This is an opinionated version of [Kirby Plainkit](https://GitHub.com/getkirby/plainkit.git) meant to be used on shared hosting plans that allow the user to load files _outside_ the public web root directory. It's configured to work on [Siteground](https://siteground.com) hosting out of the box, but can be easily adapted to other hosts. There are no symlinks; the only files in the public web root directory are those that Kirby requires to be there. Everything else is safely outside the web server's grasp. 

I made this because I was a bit unclear on how to make this work and I've seen questions from newbies like me on the excellent [support forum](https://forum.getkirby.com) from time to time and I thought it'd be nice to have a nice starting point for my own new Kirby projects.

The core Kirby system files are referenced as a git submodule (which means they aren't physically included in this repo).  I started on this when Kirby was at version 3.6.5, but I didn't want to always be updating this to keep the system current. See the [`Installation`](#installation) details below. 


This was made for my personal use and there are no guarantees it will work for you. Its quirks are mine, you're welcome to your own. I'm making this freely available. I hope you find it useful. I'll answer questions that I can, but this is very definitely an "as-is" thing. 

## <a name="submodules">Installation</a>
5. The Kirby system files are referenced as a Git submodule because it lets me treat those files as a black box. There's a very practical implication to this strategy:  I'm not including Kirby files. I'm including a way for you to use the version you want to use.

    * If you just clone this repository you will __not__ automatically download Kirby (the directory will be there, but it will be empty). Navigate into the Kirby directory and issue the command

    ```git submodule init```, 

    then

    ```git submodule update```.

    Any time you need to update the system files, just run the second command (```git submodule update```) again. The Kirby documentation encourages you to delete ```/public_html/media``` any time the Kirby version changes. It will be regenerated as needed.

## Details

1. This is adapted from the [Public Folder Setup](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup) example in the Kirby Guide. 
2. The public web root directory is called `/public_html` on Siteground. You may need to change this.
3. Two configuration files are included in `/site/config'.  
    * `config.php` allows the panel to be installed on a remote server and changes the page slug for the panel from `myexample.com/panel' to `myexample.com/knockknock`. Seek professional help is that's the slug you want to use.
    * `config.crankykit.test.php` turns on debugging only on a host that answers to the name `crankykit.test`.  Make it your own by changing the name to that works on your development setup.
4. The `.htaccess` file is located in the public web root.  It's the "stock" Kirby `.htaccess` file with the  addition of the directive 

    ```Header set Cache-Control "no cache, private"``` 
    
    to minimize the impact of Siteground's dynamic caching on Kirby license validation. See [this discussion](https://forum.getkirby.com/t/kirby-3-panel-not-updating-server-caching-or-license-key-issue/21444) for the gory details about why this is here. 


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
