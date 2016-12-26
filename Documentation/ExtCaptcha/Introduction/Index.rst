

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Introduction
------------

The captcha extension can get used for showing a distorted rendered text in an
image for providing spam protection. The text in the image has to get filled
into a form field and gets validated upon submission to the server.

What does it do?
^^^^^^^^^^^^^^^^

This extension generates an image which contains an obfuscated text string that
a user has to repeat in a form field in order to gain access to a website service.
The technique assumes that humans can read an repeat the string while a spam-bot
cannot, thus preventing guestbooks, tip-a-friend forms etc. from being spammed by
non-human clients.

The techniques are discussed here: http://en.wikipedia.org/wiki/Captcha

This captcha is meant as a resource other TYPO3 plugins can use. In doing so the
overall site security level is improved when this captcha is improved in security.
People interested in captcha security are more than welcome to continue development
on this implementation!

Screenshots
^^^^^^^^^^^

.. figure:: ../../Images/captcha-example-1.png
   :alt: Example for a captcha.

.. figure:: ../../Images/captcha-example-2.png
   :alt: Another example. Many aspects like amount of characters can get configured.

