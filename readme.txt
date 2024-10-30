=== Magic Login Link ===
Contributors: smtisipp
Tags: Magic Login, Passwordless Login, Login, Magic
Requires at least: 4.6
Tested up to: 4.9.4
Requires PHP: 5.6
License: GPLv2
Stable tag: 1.1.0
License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html

Enables the user to login without entering a password. Instead a mail with a login is sent.

== Description ==
With the Magic Login Link Plugin, you can login to wordpress without entering your password. This is awesome, if you have forgotten your password or your password is just hard to remember. After entering your mail adress, you will receive a link, which gives you the ability to login instantly.

== How To ==

To use the functionality, you can add the shortcode 'amc_spark_magic_login'. This will add an input form to the current site

== Changelog ==

= 1.1.0 =
    * Refactor redirect logic to redirect user to the site with the shortcode after he logged in with the link
    * Hide form, if user is logged in
    * Remove unused filters
    * Add text domain

= 1.0.0 =
    * Initial version
