=== WP-Shabbat ===
Contributors: drmosko
Tags: shabbat,jewish holiday, close site, 503,popup window,popup message
Requires at least: 3.7.0
Tested up to: 4.8.1
Stable tag: 2.3
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=53KUKZ9KN2YBN
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Close site or display popup message on Shabbat and Holidays by identifying the address of the user IP and close to 40 km



== Description ==

[WP-Shabbat](http://www.dossihost.net/%D7%AA%D7%95%D7%A1%D7%A3-%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A1-%D7%A1%D7%95%D7%92%D7%A8-%D7%90%D7%AA%D7%A8-%D7%91%D7%A9%D7%91%D7%AA%D7%95%D7%AA-%D7%95%D7%97%D7%92%D7%99%D7%9D/) is a WordPress plugin that will help you and your visitors observe the shabbat.

For more information in hebrew, check out [WP-Shabbat](http://www.dossihost.net/%D7%AA%D7%95%D7%A1%D7%A3-%D7%95%D7%95%D7%A8%D7%93%D7%A4%D7%A1-%D7%A1%D7%95%D7%92%D7%A8-%D7%90%D7%AA%D7%A8-%D7%91%D7%A9%D7%91%D7%AA%D7%95%D7%AA-%D7%95%D7%97%D7%92%D7%99%D7%9D/).

Features include:

* close the site by setting the Shabbat and holiday enter time in minutes when the minimum is 20 minutes.
* close the site by setting the Shabbat and holiday exit time in temporary minutes from 18 minutes to 72 minutes.
* Ip databse is updated automatically every week. (est. size : 17Mb)
* search engine bots get http header 503.(SEO-Friendly) :
[Answer from Google about WP-Shabbat](https://productforums.google.com/forum/#!topic/webmasters/bjpQtTwzadI/discussion)
* plugin languages : English,Hebrew,Russian.
* plugin will generate on fly page with your template for visitor to come back later.
* Display popup message when its shabbat or holiday.
* Display one hour countdown before site closes to soft the user termination.
* Add custom messages and images etc, below the plugin default message.
* select which css class/id to hide when site closed.

Notes:

* Shabbat and holiday exit time is temporary minutes that calculated from sunrise to sunset and divided into 12 hours.
* The sunrise and sunset times is calculated for each user by his location. 
* Identification place of the user is by its IP address close to 40 km.
* This script uses GeoLite Country from MaxMind (http://www.maxmind.com) which is available under terms of GPL/LGPL 
* DB file GeoLiteCity.dat downloaded every week from maxmind servers to plugin directory.




== Installation ==

= From your WordPress dashboard =
* before u install there make sure with your host that you can download 16mb file and it is not block with php.ini file
1. Visit 'Plugins > Add New'
2. Search for 'WP-Shabbat'
3. Activate WP-Shabbat from your Plugins page. 
4. Visit 'Setting > WP-Shabbat' and set the times you  want.

= From WordPress.org =

1. Download WP-Shabbat.
2. Upload the 'WP-Shabbat' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate WP-Shabbat from your Plugins page. 
4. Visit 'Setting > WP-Shabbat' and set the settings you  want.

== Screenshots ==

1. WP-Shabbat Setting Page.
2. WP-Shabbat on fly page (with Twenty Thirteen template).
3. Confirm of Http header status 503.
4. popup announcement messsage.
5. js coundown before site close to soft the user termination.

== Changelog ==

= 2.3 =
* fixed all notices
* added higher z-index to countdown pop up msg

= 2.2 =
* Added dont send email notafication option
* Changed link wp-shabbat css "hidden" to html comment 

= 2.1 =
* Mail sent twice Repair

= 2.0 =
* critical update - fixed PHP Fatal error:  Call to undefined function download_url() 

= 1.9 =
* critical update - changed how the database update 

= 1.8 =
* russian translations added.
* added richtext editor to add custom messages and images etc, below the plugin default message.
* the display of wordpress search box was shut off when site closed.
* new admin page design.
* added sending email to admin about the DB status.
* added user select which css class/id to hide when site closed.

= 1.7 =
* fix site not closed in wordpress versions 4+.

= 1.6 =
* fix countdown bug ( value was not intgr).

= 1.5 =
* fix close site bug (nextupdate value was not intgr).

= 1.4 =
* changed update mathod, check every week for new IP DB.

= 1.3 =
* added time to 503 page for google bot to come back

= 1.2 =
* fix Undefined index: WP-Shabbat bug
* fix undefined constant timestamp bug


= 1.1 =
* added popup message test page at admin page
* added closed page css to hide nav menu for few wordpress used classes
* changed few translations
* added admin message option
* fixed headers already sent


= 1.00 =
* added countdown before site closes to soft the user termination
* fixed ecndonde problem to datect jewish dates

= 0.07 =
* fixed checkbox validate problem
* added footer link option

= 0.06 =
* fixed critical update problem  
* added popup message feature

= 0.05 =
* fixed critical ip DB problem 

= 0.04 =
* fixed Collision functions

= 0.03 =
* closed page set to 503 http like google advise (http://productforums.google.com/forum/#!topic/webmasters/theUs8RCvDg/discussion
and http://www.seroundtable.com/archives/020729.html)
* remove bot cloack

= 0.02 =
* check if template base files exists