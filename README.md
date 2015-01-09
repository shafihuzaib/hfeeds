hFeeds
======

hFeeds is a simple & easy to use RSS feed generator for web-pages.
As a user, you'll have to remember only two variables {h} & {i}, where

{h} => have it (use the content specified by this variable)
{i} => ignore it

USAGE
==============================
1. Enter url of the web-page you need to generate feed for & optionally an encoding type.
2. After reviewing the source code on the next page, specify global & repeatable patterns.
3. Enter feed file details & use the {hN} variables in the Feed Item section, such as {h1} {h2} etc.
4. Hit the button & your feed is ready.

Global Pattern
===============
Global Pattern refers to a unique section in a web-page, which contains the repeatable pattern.
Only one {h} variable is allowed for each Global Pattern.
If unsure, simply enter {h} to select the whole page.

Repeatable Pattern
===================
Repeatable Pattern refers to each item that is to be in the feed. An item is defined by a TITLE, DESCRIPTION, LINK & (optionally) publishing DATE.
And same can be extracted from a web-page using a repeatable pattern. The pattern may contain any no. of {h} & {i} variables.

{hN} variables
==============
For each {h} used in repeatable pattern, you can use {hN} (where N is 1,2,3...) for substitution in Feed Item Configuration.

Author
============
Huzaib Shafi
 http://www.shafihuzaib.com

Features
========
1. Create RSS Feeds for any web-page.
2. Easy to use.
3. Select upto 4 sections from a web-page to choose items for, even if the items have different pattern with respect to sections.