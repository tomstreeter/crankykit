# Crankykit: A riff on Kirby Plainkit

## Overview

This is an opinionated version of [Kirby Plainkit](https://GitHub.com/getkirby/plainkit.git) meant to be used on shared hosting plans that allow the user to load files _outside_ the public web root directory. It's configured to work on [Siteground](https://siteground.com) hosting out of the box, but can be easily adapted to other hosts. There are no symlinks; the only files in the public web root directory are those that absolutely have to be there. Everything else is safely outside the web server's gaze.

*_Note_*: The Kirby documentation refers to what I call the _public web root directory_ simply as the _document root_. I use the longer phrase to emphasize a distinction between the directory you land in when you log in to whatever hosting service you use (e.g., your account's home directory) and the directory that contains the actual bits that are sent out by the web server (the _public web root directory_, or _document root_). If, when you log in to your hosting account, you can only see the contents of the public web root directory, use [the standard installation instructions](https://getkirby.com/docs/guide/quickstart#download-and-installation) because that's how Kirby will work best for you. 

If the previous paragraph makes no sense, do yourself a favor and just install Kirby as it says in [the standard installation instructions](https://getkirby.com/docs/guide/quickstart#download-and-installation).

I made this because I thought it'd be nice to have a nice starting point for my own new Kirby projects and then I said "I wonder if ...?" a lot. I've seen questions from newbies (like me) on the excellent [support forum](https://forum.getkirby.com) from time to time about about how to set up a Kirby installation with the fewest possible files present in the public web root. Doing this allowed me to avoid doing other things I wasn't in the mood to do.

This might be enough to scare you off: The core Kirby system files are referenced as a git submodule (which means the files aren't physically included in this repository, only a pointer to where you can download them). The real point of this repository is to document where all the bits that _aren't_ core Kirby files need to go. See the [`Installation`](#installation) instructions below to learn how to get the required Kirby files.

This was made for my personal use and there are no guarantees it will work for you. Its <a name="quirks">quirks</a> are mine; you're welcome to your own. I'm making this freely available. I hope you find it useful. I'll answer questions that I can, but this is very definitely an "as-is" thing. I haven't used every hosting service under the sun and I don't plan to take it up as a hobby. I'm the *worst* possible source of information about your hosting account.  Your hosting provider is the best source of information.

## About Kirby CMS

I'm a big fan of [Kirby CMS](https://getkirby.com). It's a great piece of software backed by a great little company and a community of loyal users. I have no connection with them except as a happily *paying* customer.  *Kirby is not free software*.  If you're going to use it in a public environment, you need to buy a license either directly from them or through a Kirby plugin author's website (same price, just helps support the Kirby ecoystem). You can find [everything you'd ever want to know](https://getkirby.com/license/2022-03-15) about licensing Kirby on their website.  

## <a name="submodules">Installation</a>

Kirby files are referenced as a Git submodule because it lets me treat those files as a black box (as one does if one wishes to be happy). There's a very practical implication to this strategy: The actual files that live inside the `/kirby` directory aren't included in this repository except as a pointer. This is how you can get them:

1. You can download this repository as a `.zip` file, unzip it, and place _the contents_ of the unzipped directory where you want it to go. You'll see a `/kirby` directory, but it'll be empty. 

	You can then download the [necessary Kirby files as a `.zip`](https://github.com/getkirby/kirby/archive/refs/heads/main.zip) and copy the _contents_ of the unzipped directory inside the empty `/kirby` directory.
1. You can clone the repository *and* download the Kirby files all at once by navigating to the directory where you want to install this repository and using the command 
		```
		git clone https://github.com/tomstreeter/crankykit.git --recurse-submodules
		```
1. If you (for whatever reason) clone this repository using *only* the basic `git clone` command (without ```--recurse-submodules```) you will *not* automatically download the Kirby files (the directory will be there, but it will be empty). Navigate into the Kirby directory and issue the command
		```
	git submodule init
		```
	then
		```
	git submodule update
		```
	Regardless of how you downloaded and installed the submodule, you can always run the
		```
	git submodule update
		```
	command again as Kirby updates come along. *Don't forget to commit your project after updating the submodule!* 

	The Kirby documentation encourages you to delete ```/public_html/media``` any time the Kirby version changes. The directory will be regenerated as needed.

## Details
 
1. The public web root directory is called `/public_html` on Siteground hosting. You may need to adjust this to match whatever convention your hossting provider uses.

1. Two configuration files are included in `/site/config`.  
	* `config.php` allows the panel to be installed on a remote server and changes the page slug for the panel from `myexample.com/panel` to `myexample.com/knockknock`. Seek professional help is that's the slug you want to use.
	* `config.crankykit.test.php` turns on debugging, but only for hosts that answers to the name `crankykit.test`. Make it your own by changing the name to something that works on your development setup.
1. The `.htaccess` file is located in the public web root directory.  It's the "stock" Kirby `.htaccess` file with the addition of the directive 
		```
	Header set Cache-Control "no cache, private"
		``` 
	to minimize the impact of Siteground's dynamic caching on Kirby license validation. See [this discussion](https://forum.getkirby.com/t/kirby-3-panel-not-updating-server-caching-or-license-key-issue/21444) for the gory details about why this is here. 
1. `index.php` is located in `public_html` and is shown  below.

	It's useful to remember that, out-of-the-box, Kirby assumes all files and subdirectories are going into the public web root directory. This `index.php` file tells Kirby where to find things when they're not all in one directory. 

	<img width="688" alt="screenshot of index.php" src="https://user-images.githubusercontent.com/284185/165156578-c05be891-641d-44b5-92ba-22588e260044.png">

	* Line 3  assumes that the `/kirby` directory is a _sibling_ of the public web root directory. You may need to adjust this if your hosting setup is different.

	* Line 7 takes care of determining the path of the public web root directory.  It doesn't need to be specified anywhere else.

	* Line 8, much like Line 3, is written to determine the _parent_ of the public web root directory because on Siteground it's possible to install files in directories that are its siblings. This may not be the case on your hosting provider. The only thing that's required is that the directory of the non-public files are reachable via a relative path from the public web root.

1. The `/media` directory will be created in the public web root once the site is active. It can be deleted at any time and it will be regenerated as needed.

1. A `/storage` directory has been added as a sibling to `/content` and `/site` It contain the directories that the web server must have write permissions for: `/accounts`, `/cache`, and `/sessions`.
   
1. An `/assets` directory has been added to the public web root to hold CSS, JS, fonts, and graphics. A basic CSS scaffold is included. I'm a fan of Andy Bell's [CUBE CSS](https://cube.fyi/) methodology and my scaffold is more or less based on that. Once upon a time I used a lot of SASS, but I've sort of moved away from it as CSS has matured and we have cascade layers now.  This is one of those [quirks](#quirks) I mentioned earlier. You can remove this without affecting anything else.

### Directory Structure as Installed
<pre>
[YOUR INSTALLATION DIRECTORY]
├── composer.json
├── config.codekit3
├── kirby/
│ ├── [...]
├── content/
│ ├── error/
│ │ └── error.txt
│ ├── home/
│ │ └── home.txt
│ └── site.txt
├── public_html/
│ ├── assets/
│ │ └── css/
│ │     ├── main.css
│ │     ├── main.css.map
│ │     └── partials/
│ │         ├── _block.css
│ │         ├── _composition.css
│ │         ├── _exception.css
│ │         ├── _tokens.css
│ │         └── _utility.css
│ ├── index.php
├── site/
│ ├── blueprints/
│ │ ├── pages/
│ │ │ └── default.yml
│ │ └── site.yml
│ ├── config/
│ │ ├── config.crankykit.test.php
│ │ └── config.php
│ ├── snippets/
│ │ ├── foot.php
│ │ ├── head.php
│ │ ├── header.php
│ │ └── index.html
│ └── templates/
│     └── default.php
└─ storage/
  ├── accounts/
  │ └── index.html
  ├── cache/
  │ └── index.html
  └── sessions/
	  └── index.html
</pre>


