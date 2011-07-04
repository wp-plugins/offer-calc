=== Offer Calc ===
Contributors: mpeshev
Tags: offers, calculator
Requires at least: 3.0
Tested up to: 3.1.4
License: GPLv2 or later

Offer Calc is a simple plugin letting your site visitors to calculate your services at final cost. 

== Description ==

Offer Calc is a simple plugin letting your site visitors to calculate your services at final cost. The layout includes number of rows, each one consists of:
-service name/description
-price per unit
-input box for clients to select number of units (number of pages, number of apples etc)
-label for total cost
-at the bottom - total sum of all labels.

Features in the queue for future releases:

-select the type of the input 
-limit the input based on the service
-configure the layout of each row
-style it.
-working edit/delete of forms
-working with more than 1 widget/shortcode at a page (currently using IDs at some places)

== Installation ==

Upload the Offer Calc plugin to your blog and activate - that's all.

The widget needs the ID of the form that you create (This is the unique slug).

If you need a shortcode usage, use this snippet:

[ofc_shortcode widget_name="OfferCalc_Widget" form_id="YOUR-FORM-ID-HERE"]

Currently only 1 form is supported on the site.

== Changelog ==

v0.5a
Widget and Shortcode
Calculating their sums

v0.4a
Created the Widget

v0.3a
Adding to database form data