# pat_public_bar

Textpattern plugin

Add a bar on your website to access side to side from public to admin pages.

Support for multi-sites installation (with sub domain), context & privileges sensitiv and give access to 'Section', 'Form', 'CSS' tabs (only for users with 1, 2 or 6 privs level); 'Article' (with 'edit' or 'create new' option), 'Categories', 'Images', 'Comments', 'Prefs' tabs. Access to Textpattern interface (with official logo branding), log-out link, i18n capable.

Very discreet appearance to not interfere with the design of websites, appears on mouseover (only for users connected) to the top of the page (figured with a black horizontal line) and all features into a dropdown menu on the left. Customizable colors (icons, background, hover links and characters).

![pat_public_bar sneak peek](http://s27.postimg.org/uybm43ddf/sneak_peek.png)


## Plugin help

Just add `<txp:pat_public_bar />` in your page templates where to show this bar on your website (public side) only available for login-in users.

## Attributes

> **position** *String* (optional): CSS position of the bar. Set to absolute is better for small screens support. Default: `fixed`. Note: version 0.3.4. automaticaly changes the position for you.
>
> **bgcolor** *String* (optional): change the background color of the bar. Default: `#23282d`.
>
> **color** *String* (optional): change the font color into the bar. Default: `#fff`.
> 
> **title** *String* (optional): change the color of the different parts title. Default: `#84878b`.
> 
> **hover** *String* (optional): change the color of links on hover. Default: `#62bbdc`. 
> 
> **icon** String (optinal): change the color of the SVG icons. Default: `#ccc`.

## Changelog

    15th October 2015: v 0.3.3. New UI, better support for multisite installation and 3 new attributes for customization.
    2d August 2015: v 0.3.2. Admin privs can access to "Section", "Page" and "Style" tabs.
    1st August 2015: v. 0.3.1. Add "bgcolor" and "color" attributes.
    30th July 2015: v. 0.3.0. Support for multi-site installations.
    29th April 2015: v 0.2. Add image & category page links.
    25th July 2014: first release.


