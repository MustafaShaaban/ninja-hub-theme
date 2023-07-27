NH -
===============================================

`nh` is a theme based on starter theme called 'underscores', Requires PHP version 8.1+

Theme Structure
---------------

```bash
└─── nh
    │   .eslintrc
    │   .stylelintrc.json
    │   404.php
    │   archive.php
    │   comments.php
    │   composer.json
    │   footer.php
    │   functions.php
    │   gulpfile.babel.js
    │   header.php
    │   index.php
    │   LICENSE
    │   package-lock.json
    │   package.json
    │   page.php
    │   phpcs.xml.dist
    │   README.md
    │   screenshot.png
    │   search.php
    │   sidebar.php
    │   single.php
    │   style-rtl.css
    │   style-rtl.min.css
    │   style-rtl.min.css.map
    │   style.css
    │   style.min.css
    │   style.min.css.map
    │
    ├───app
    │   ├───Classes
    │   │       class-nh_init.php
    │   │       class-nh_module.php
    │   │       class-nh_post.php
    │   │       class-nh_user.php
    │   │
    │   ├───helpers
    │   │       class-nh_ajax_response.php
    │   │       class-nh_forms.php
    │   │       class-nh_hooks.php
    │   │       class-nh_mail.php
    │   │
    │   ├───Models
    │   │   ├───admin
    │   │   │   │   class-nh_admin.php
    │   │   │   │
    │   │   │   ├───assets
    │   │   │   │   ├───images
    │   │   │   │   │       screenshot.png
    │   │   │   │   │
    │   │   │   │   ├───js
    │   │   │   │   │       main.js
    │   │   │   │   │
    │   │   │   │   └───sass
    │   │   │   │           style.scss
    │   │   │   │
    │   │   │   ├───css
    │   │   │   │       style-rtl.css
    │   │   │   │       style-rtl.min.css
    │   │   │   │       style-rtl.min.css.map
    │   │   │   │       style.css
    │   │   │   │       style.min.css
    │   │   │   │       style.min.css.map
    │   │   │   │
    │   │   │   ├───img
    │   │   │   │       screenshot.webp
    │   │   │   │
    │   │   │   ├───js
    │   │   │   │       main.js
    │   │   │   │       main.min.js
    │   │   │   │       main.min.js.map
    │   │   │   │
    │   │   │   ├───modules
    │   │   │   └───vendors
    │   │   │       ├───css
    │   │   │       └───js
    │   │   └───public
    │   │       │   class-nh_public.php
    │   │       │
    │   │       ├───assets
    │   │       │   ├───images
    │   │       │   │       screenshot.png
    │   │       │   │
    │   │       │   ├───js
    │   │       │   │   │   main.js
    │   │       │   │   │
    │   │       │   │   ├───helpers
    │   │       │   │   │       Validator.js
    │   │       │   │   │
    │   │       │   │   └───inc
    │   │       │   │           Functions.js
    │   │       │   │           UiCtrl.js
    │   │       │   │
    │   │       │   └───sass
    │   │       │       │   style.scss
    │   │       │       │
    │   │       │       ├───abstracts
    │   │       │       │   │   _abstracts.scss
    │   │       │       │   │
    │   │       │       │   ├───mixins
    │   │       │       │   │       _mixins.scss
    │   │       │       │   │
    │   │       │       │   └───variables
    │   │       │       │           _colors.scss
    │   │       │       │           _columns.scss
    │   │       │       │           _structure.scss
    │   │       │       │           _typography.scss
    │   │       │       │
    │   │       │       ├───base
    │   │       │       │   │   _base.scss
    │   │       │       │   │
    │   │       │       │   ├───elements
    │   │       │       │   │       _body.scss
    │   │       │       │   │       _buttons.scss
    │   │       │       │   │       _fields.scss
    │   │       │       │   │       _hr.scss
    │   │       │       │   │       _links.scss
    │   │       │       │   │       _lists.scss
    │   │       │       │   │       _media.scss
    │   │       │       │   │       _tables.scss
    │   │       │       │   │
    │   │       │       │   └───typography
    │   │       │       │           _copy.scss
    │   │       │       │           _headings.scss
    │   │       │       │           _typography.scss
    │   │       │       │
    │   │       │       ├───components
    │   │       │       │   │   _components.scss
    │   │       │       │   │
    │   │       │       │   ├───comments
    │   │       │       │   │       _comments.scss
    │   │       │       │   │
    │   │       │       │   ├───content
    │   │       │       │   │       _posts-and-pages.scss
    │   │       │       │   │
    │   │       │       │   ├───media
    │   │       │       │   │       _captions.scss
    │   │       │       │   │       _galleries.scss
    │   │       │       │   │       _media.scss
    │   │       │       │   │
    │   │       │       │   ├───navigation
    │   │       │       │   │       _navigation.scss
    │   │       │       │   │
    │   │       │       │   └───widgets
    │   │       │       │           _widgets.scss
    │   │       │       │
    │   │       │       ├───generic
    │   │       │       │       _box-sizing.scss
    │   │       │       │       _normalize.scss
    │   │       │       │
    │   │       │       ├───layouts
    │   │       │       │       _content-sidebar.scss
    │   │       │       │       _no-sidebar.scss
    │   │       │       │       _sidebar-content.scss
    │   │       │       │
    │   │       │       ├───plugins
    │   │       │       └───utilities
    │   │       │               _accessibility.scss
    │   │       │               _alignments.scss
    │   │       │
    │   │       ├───img
    │   │       │       screenshot.webp
    │   │       │
    │   │       ├───js
    │   │       │       main.js
    │   │       │       main.min.js
    │   │       │       main.min.js.map
    │   │       │
    │   │       ├───modules
    │   │       └───vendors
    │   │           ├───css
    │   │           └───js
    │   └───Views
    │       │   archive.php
    │       │   blogs.php
    │       │   none-search.php
    │       │   none.php
    │       │   page.php
    │       │   search.php
    │       │   single.php
    │       │
    │       ├───email-template
    │       │   └───default
    │       │           body.php
    │       │           footer.php
    │       │           header.php
    │       │
    │       ├───template-parts
    │       │   └───c1
    │       │           c1.php
    │       │
    │       └───templates
    │               template-page-home.php
    │
    ├───inc
    │       custom-functions.php
    │       template-tags.php
    │
    └───languages
            nh.pot
```

### Requirements

`nh` requires the following dependencies:

- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

### Quick Start

### Setup

To start using all the tools that come with `nh`  you need to install the necessary Node.js and Composer dependencies :

```sh
$ composer install
$ npm install
```

### Available CLI commands

`nh` comes packed with CLI commands tailored for WordPress theme development :

- `npm run start` : Start watching all files [SASS, JS, PHP] and compile them all.
- `npm run publicStyles` : Compile the sass files included in the public path.
- `npm run publicStylesRtl` : Convert the css files to rtl version.
- `npm run publicScripts` : Compile all scripts included in the public path.
- `npm run publicImages` : Minify all images included in the public path and convert them to webp extension.
- `npm run adminStyles` : Compile the sass files included in the admin path.
- `npm run adminStylesRtl` : Convert the css files to rtl version.
- `npm run adminScripts` : Compile all scripts included in the admin path.
- `npm run adminImages` : Minify all images included in the admin path and convert them to webp extension.
- `npm run translate` : Crawl the php files searching for strings added to _() function to be added to the .pot file to
  make it ready to be translated.
- `npm run all` : Compile all files [SASS, JS, PHP] for just one time - Production purpose.
- `npm run bundle` : generates a .zip archive for distribution, excluding development and system files.

Now you're ready.

Good luck!
