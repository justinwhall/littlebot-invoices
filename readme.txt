=== Plugin Name ===
Contributors: jwind
Donate link:https://littlebot.io/littlebot-invoices/
Tags: invoice, estimate, payment, ecommerce, ecommerce, bill, billings, PDF, PDF Invoices
Requires at least: 3.0.1
Tested up to: 4.8.1
Stable tag: 2.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

LittleBot Invoices makes it easy to create and send estimates and invoices for your business right from your WordPress site!

== Description ==

**Native Estimating & Invoicing**
Easily create and send estimates and invoices for your business without leaving your WordPress site. LittleBot invoices is a plug-and-play _stand alone_ application. No third party plugin or integrations are required. No need to learn a new piece of software to send estimates & invoices.

**Awesome Support & Documentation**
LittleBot values each and every user. We take pride in our code, projects and customer service. Our documentation can be found [on our website](https://littlebot.io/docs/littlebot-invoices/getting-started/). Support requests can also be submitted on our [support page](http://littlebot.io/support/).

== Installation ==

1. Upload `littlebot-invoices` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==
Check out our [docs](https://littlebot.io/docs/littlebot-invoices/getting-started/).
Or [ask us a question](https://littlebot.io/support/).

== Screenshots ==
Visit our [website](https://littlebot.io/littlebot-invoices/) for screenshots.

== Changelog ==

= 2.3.1 =
* FIX - Total output on PDF
* FIX - remove PDF button from estimate admin area

= 2.3.0 =
* NEW - Download PDF from admin edit screen & all invoices
* FIX - PDF rendering with some values

= 2.2.0 =
* NEW - Add support for download PDFs for invoices

= 2.1.4 =
FIX - Valid until date not saving correctly under certain circumstances.

= 2.1.3 =
* FIX - Changed activation template for invoice emails to use %invoice_number% rather than %estimate_number%. Current users will have to visit the options page and change the placeholder manually.
* NEW - Emails sent from admin to clients now show up in logs.
* NEW - View by _ip address_ added to log. The log omits logged in users.

= 2.0.3 =
* FIX - Invoices showing post ID instead invoice number

= 2.0.2 =
* Fix - Business information no longer resets on plugin REactivation
* Fix - php warning when saving estimate without client
* Fix - some instances where estimate approval ajax call failed and or post was not properly copied as invoice
* New - various changes to support PHP 7.1.4

= 2.0.1 =
* FIX - Minor UI changes

= 2.0.0 =
* New - logo support for estimates and invoices
* New - Paypal standard check out
* New - Estimate/Invoice title
* New - general gateway prep
* Fix - various PHP warnings
* Fix - various localization errors
* Fix - token errors in some situations on certain email notifications
* Fix - logging errors when doc status changes by a user that is not logged in

= 1.0.2 =
* Fixed bug where cents were not being saved

= 1.0.1 =
* Fixed typo in terms/notes metabox save callback

= 1.0.0 =
* Initial Release
