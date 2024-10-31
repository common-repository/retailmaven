=== RetailMaven ===
Contributors: RetailMaven
Tags: retailmaven, affiliate, marketing, links, monetization, monetisation, javascript, make money, advertising, affiliate widget, referral, plugin, text links, revenue, deep link, localised advertising, localized
Requires at least: 4.2
Tested up to: 4.6
Stable tag: 1.2.8
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The simplest way to generate revenue from your content. We analyze and convert your text content into appropriate localized affiliate product links.

== Description ==

Welcome to RetailMaven - [Visit us at https://retailmaven.co](https://retailmaven.co)

RetailMaven automatically categorises the text on your site and matches that text, or phrase to a retailer.
For each click through and purchase, you earn a commission, effortlessly bridging e-commerce with your content.

We work with retailers like Reebok, DKNY, Oroton, Sephora, Lorna Jane, The North Face, Fanatics.com, Apple, Amazon and hundreds more.

== Installation ==

Just requires these easy steps to get RetailMaven working:

= To install the plugin: =
1. Upload the plugin files to the `/wp-content/plugins/retailmaven` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Plugin Settings->RetailMaven screen to configure the plugin

= To connect your RetailMaven account: =
1. If you don’t have an account already, [create a RetailMaven account](https://retailmaven.co/signup). Note we are currently slowly onboarding each individual account to give the best experience.
1. After signing in to the 'RetailMaven Dashboard', navigate to the Sites tab and add a new site and fill in the necessary details. A 'site code' should be generated.
1. Access the RetailMaven Settings through the “Settings” tab within your WordPress dashboard.
1. Copy the 'site code' to the RetailMaven plugin.

== Frequently Asked Questions ==

= What is RetailMaven? =

RetailMaven automatically analyzes your text content to recommend the best affiliate product links that are local to the reader. We link only appropriate text/phrases and are particularly aimed at blogs/publishers who focus on lifestyle, fashion, health & beauty, sport & fitness. We effortlessly bridge e-commerce with your content.

= What if my site is not related to lifestyle/fashion/health & beauty/sport & fitness? =

We are happy for anyone to [sign-up](https://retailmaven.co/signup). However, our top priority is the aforementioned categories. But we will be gradually adding other categories.

= What happens if the RetailMaven service is unavailable? =

The RetailMaven service is constantly monitored 24/7. If, in the unlikely event, there is a service outage, we do not change any text into affiliate links or only a very short period of time. The end reader of your site will not experience any disruption to their reading experience.

= I have Viglink/Skimlinks installed. What should I do? =

Unfortunately, to have RetailMaven work effectively for your site you will need to disable/deactivate Viglink and Skimlinks to produce the best results.

= Is there any cost in signing up? =

It's free to sign-up to RetailMaven. Once approved you will be able to start generating revenue.

= Wouldn't it be easier if I created the affiliate links myself? =

The problem with this manual approach is that you will only be able to target to one specific geo-region. Our technology is smart enough to create localized product affiliate links to the merchants that your readers are familiar with. For example, will we link to Amazon UK store if we see that the user is from the UK or to Amazon Japan if we see the user is coming from Japan. Also, with our extensive range of merchants we will find the best affiliate that offers you the highest commission (this means more revenue for you).

= I have more questions =

Please read more information at [RetailMaven Docs](https://retailmaven.co/docs).
Otherwise email support@retailmaven.co and we will be happy to answer any enquiries.

== Screenshots ==

1. RetailMaven settings page
2. RetailMaven Dashboard

== Changelog ==
= 1.2.8 =
* Remove debug mode as this is not needed anymore
* Update releavnt links to https://publishers.retailmaven.co
* Update to latest WP version 4.6

= 1.2.7 =
* Update readme to better describe RetailMaven.

= 1.2.6 =
* Do the latest WP version 4.5. Update the register button to inform the user better what it does.

= 1.2.5 =
* Do not insert Javascript unless it's a post. Ignore things like search, homepage, index-page and archives.

= 1.2.4 =
* Do not insert our javascript in preview mode. Also limit the crawling of data when article length < 100 characters.

= 1.2.3 =
* Add our own versioing mechanism in debug mode to avoid any caching done by other plugins.

= 1.2.2 =
* Add debug mode for RetailMaven Support staff to help with resolving any issues. This should only be turned on if asked by RetailMaven.

= 1.2.1 =
* DO NOT download version 1.2. Please use this version as sometimes the plugin data cannot be retrieved.

= 1.2 =
* For users using CloudFlare Rocket loader, it performs aggressive caching. We disable it because it affects any updates.
* Added notification messages to inform the user if there are any issues.
* Allow user to select multiple categories to choose which type of articles to run RetailMaven on.
* Improved documentation

= 1.1.6 =
* Change the add_filter to only accept one argument as certain scenarios would not work before.

= 1.1.5 =
* Remove usage of anonymous functions as this is only supported by PHP 5.3.1+

= 1.1.4 =
* Inform RetailMaven of the relevant categories of a post when published for better categorisation.

= 1.1.3 =
* Update documentation to show where to visit retailmaven.co
* Update system check to track which WP plugin is installed for better customer service.

= 1.1.2 =
* Change menu to say RetailMaven than rather Plugin Settings.

= 1.1.1 =
* Better identify categories and sections that a site owner only wants retailmaven to run on.

= 1.1 =
* Change to inform the user if they have entered in a valid site code or not.

= 1.0 =
* Initial release
