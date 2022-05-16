# Crankykit: A riff on Kirby Plainkit

## Overview

This is an opinionated version of [Kirby Plainkit](https://GitHub.com/getkirby/plainkit.git) meant to be used on shared hosting plans that allow the user to load files _outside_ the public web root directory. It's configured to work on [Siteground](https://siteground.com) hosting out of the box, but can be easily adapted to other hosts. There are no symlinks; the only files in the public web root directory are those that absolutely have to be there. Everything else is safely outside the web server's gaze.

*_Note_*: The Kirby documentation refers to what I call the _public web root directory_ simply as the _document root_. I use the longer phrase to emphasize a distinction between the directory you land in when you log in to whatever hosting service you use (e.g., your account's home directory) and the directory that contains the actual bits that are sent out by the web server (the _public web root directory_, or _document root_). If there _is_ no difference between your account's home directory and the document root, use [the standard installation instructions](https://getkirby.com/docs/guide/quickstart#download-and-installation) because none of what's here will help you.

If the previous paragraph makes no sense, do yourself a favor and just install Kirby as it says in [the standard installation instructions](https://getkirby.com/docs/guide/quickstart#download-and-installation).

I made this because I was a bit unclear on how to make this work and I've seen questions from newbies (like me) on the excellent [support forum](https://forum.getkirby.com) from time to time. I thought it'd be nice to have a nice starting point for my own new Kirby projects and maybe save someone else some work.

The core Kirby system files are referenced as a git submodule (which means the files aren't physically included in this repository, only a pointer to where you can find them). The real point of this repository is to document where all the bits that _aren't_ core Kirby files need to go. See the [`Installation`](#installation) instructions below to learn how to get the required Kirby files.

This was made for my personal use and there are no guarantees it will work for you. Its <a name="quirks">quirks</a> are mine; you're welcome to your own. I'm making this freely available. I hope you find it useful. I'll answer questions that I can, but this is very definitely an "as-is" thing. I haven't used every hosting service under the sun and I don't plan to take it up as a hobby. I'm the *worst* possible source of information about your hosting account.  Your hosting provider is the best source of information.

## <a name="submodules">Installation</a>

Kirby files are referenced as a Git submodule because it lets me treat those files as a black box (as one does if one wishes to be happy). There's a very practical implication to this strategy: The actual files that live inside the `/kirby` directory aren't included in this repository except as a pointer. This is how you can get them:

1. You can download this repository as a `.zip` file, unzip it, and place _the contents_ of the unzipped directory where you want it to go. You'll see a `/kirby` directory, but it'll be empty. 

    You can then download the [necessary Kirby files as a `.zip`](https://github.com/getkirby/kirby/archive/refs/heads/main.zip) and copy the _contents_ of the unzipped directory inside the empty `/kirby` directory.
1. You can clone the repository *and* download the Kirby files all at once by navigating to the directory where you want to install this repository and using the command 
    
    ```git clone https://github.com/tomstreeter/crankykit.git --recurse-submodules```.
1. If you (for whatever reason) clone this repository using *only* the basic `git clone` command (without ```--recurse-submodules```) you will *not* automatically download the Kirby files (the directory will be there, but it will be empty). Navigate into the Kirby directory and issue the command

    ```git submodule init```, 

    then

    ```git submodule update```.


    Any time you need to update the Kirby files in the latter two scenarios, just run the command ```git submodule update``` again. The Kirby documentation encourages you to delete ```/public_html/media``` any time the Kirby version changes. The directory will be regenerated as needed.

## Details

1. This is adapted from the [Public Folder Setup](https://getkirby.com/docs/guide/configuration#custom-folder-setup__public-folder-setup) example in the [Kirby Guide](https://getkirby.com/docs/guide). 
2. The public web root directory is called `/public_html` on Siteground. You may need to change this.
3. Two configuration files are included in `/site/config`.  
    * `config.php` allows the panel to be installed on a remote server and changes the page slug for the panel from `myexample.com/panel` to `myexample.com/knockknock`. Seek professional help is that's the slug you want to use.
    * `config.crankykit.test.php` turns on debugging only on a host that answers to the name `crankykit.test`.  Make it your own by changing the name to that works on your development setup.
4. The `.htaccess` file is located in the public web root directory.  It's the "stock" Kirby `.htaccess` file with the addition of the directive 

    ```Header set Cache-Control "no cache, private"``` 
    
    to minimize the impact of Siteground's dynamic caching on Kirby license validation. See [this discussion](https://forum.getkirby.com/t/kirby-3-panel-not-updating-server-caching-or-license-key-issue/21444) for the gory details about why this is here. 
5. `index.php` is located in `public_html` and is shown  below.

    It's useful to remember that, out-of-the-box, Kirby assumes all files and subdirectories are going into the public web root directory. This `index.php` file tells Kirby where to find things when they're not all in one directory. 

    <img width="688" alt="screenshot of index.php" src="https://user-images.githubusercontent.com/284185/165156578-c05be891-641d-44b5-92ba-22588e260044.png">

    * Line 3  assumes that the `/kirby` directory is a _sibling_ of the public web root directory. You may need to adjust this if your hosting setup is different.
    * Line 7 takes care of determining the path of the public web root directory.  It doesn't need to be specified anywhere else.
    * Line 8, much like Line 3, is written to determine the _parent_ of the public web root directory because on Siteground it's possible to install files in directories that are its siblings. This may not be the case on your hosting provider. The only thing that's required is that the directory of the non-public files are reachable via a relative path from the public web root.

6. The `/media' directory will be created in the public web root. It can be deleted at any time and it will be regenerated as needed.
7. A `/storage` directory has been added as a sibling to `/content` and `/ site` to contain `/accounts`, `/cache`, and `/sessions`.
   These subdirectories should be writable by the web server.
8. An `/assets` directory has been added to the public web root to hold CSS, JS, fonts, and graphics. A basic CSS scaffold is included. I'm a fan of Andy Bell's [CUBE CSS](https://cube.fyi/) methodology and my scaffold is more or less based on that. Once upon a time I used a lot of SASS, but I've sort of moved away from it as CSS has matured and we have cascade layers now.  This is one of those [quirks](#quirks) I mentioned earlier.
9. This is the overall directory structure

        /some-directory

            /content

                /error

                /home

                - site.txt

            /kirby

                - bootstrap.php

                [...]

            /public_html

                - .htaccess

                - index.php

                /assets

                    /css

                        /partials

                            - _composition.css

                            - _utility.css

                            - _block.css

                            - _exception.css

                            - _tokens.css

                        - main.css

                        - main.css.map

            /site

                /blueprints

                /config

                    - config.crankykit.test.php

                    - config.php

                /snippets

                /templates

            /storage

                /accounts

                /cache

                /sessions


