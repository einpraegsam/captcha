

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

.. _ref-usage:

Usage
-----

In your frontend plugin you simply include an image tag for the captcha image and a
form field in addition for entering the code. Then, upon reception of the data you
will find the captcha string stored in a session variable and you simply compare that
value with whatever is found in the input field. If they match, all is fine and you
can process the data.

Showing the image
^^^^^^^^^^^^^^^^^

To use the captcha extension you have to put an image tag somewhere in your form
templates or let the img tag get rendered by your frontend plugin.

.. code-block:: html
   :linenos:

    <img src="/index.php?eID=captcha" />

The "eID" script "captcha" will generate the image and output it to the browser - so in fact
the "index.php" in the above src attribute will be an PNG image.

.. notice:: In previous versions the src attribute had to contain a path to the "captcha.php"
   script which was located in "typo3conf/ext/captcha/captcha/captcha.php". This has changed
   now and the captcha image became an eID script. The old "captcha.php" is still available
   for backwards compatibility but became deprecated and will get removed in future versions.

Showing the response field
^^^^^^^^^^^^^^^^^^^^^^^^^^

Any field name that fits you, for example:

.. code-block:: html
   :linenos:

    <input type="text" size=30 name="captchaResponse" value="">

Evaluating
^^^^^^^^^^

In your frontend plugin you have to check whether the correct answer for the captcha
has been given. To accomplish this there is a Utility class shipped with the captcha
extension which allows to validate the captcha response. Use something like the following
snippet in your frontend plugin:

.. code-block:: php
   :linenos:

   $response = GeneralUtility::_GP('captchaResponse');
   if (\ThinkopenAt\Captcha\Utility::checkCaptcha($response)) {
     // Captcha valid
     ...
   } else {
     // Captcha invalid
     ...
   }

The most recent version 2.0.2 also allows the usage of multiple captchas on the same
page/form. For this purpose an additional session variable "tx_captcha_array" was
introduced which can hold multiple captcha responses. To use multiple captchas you
have to submit a "formId" along with each form associated with a captcha. For this
purpose you have to add a "formId" parameter to the "eID" script in the image tag:

.. code-block:: html
   :linenos:

    <img src="/index.php?eID=captcha&formId=form1" />

The form would have to additionally contain a hidden field with the form id:

.. code-block:: html
   :linenos:

    <input type="text" size=30 name="captchaResponse" value="">
    <input type="hidden" name="captchaFormId" value="form1">

Now you can check the validity of the captcha in your frontend plugin by
passing the "formId" as the second argument to the "checkCaptcha" method.

.. code-block:: php
   :linenos:

   $response = GeneralUtility::_GP('captchaResponse');
   $formId = GeneralUtility::_GP('captchaFormId');
   if (\ThinkopenAt\Captcha\Utility::checkCaptcha($response, $formId)) {
     // Captcha valid
     ...
   } else {
     // Captcha invalid
     ...
   }

Usage in other extensions
^^^^^^^^^^^^^^^^^^^^^^^^^

Some extensions like "tipafriend", "powermail" or "formhandler" have already
integrated code to co-operate with the captcha extension or other captcha
extensions like "sr_freecap".

To use the captcha in a "formhandler" template for example you have to put
the marker "###CAPTCHA###" in the formhandler template and a text field which
allows a visitor to type in the recognized captcha value. A snippet like
the following should usually do the job:

.. code-block:: html
   :linenos:

   <div class="row">
     <div class="col-md-12">
       ###error_captchafield###
       ###CAPTCHA###
       <input type="text" name="formhandler[captchafield]" />
     </div>
   </div>

For other extensions like "powermail" just consult the documentation shipped
along the extension.

Custom evaluating
^^^^^^^^^^^^^^^^^

Instead of using the supplied static utility method you can evaluate the validity
of the captcha response manually as shown below.

.. notice:: The session variable "tx_captcha_string" supports only one single captcha
   per form. If you have multiple captchas on a single page (supported since version
   2.0.0) you will also have to retrieve the "formId" and compare against the captcha
   values stored in the "tx_captcha_array" variable.

First, you need to retrieve the captcha string from the session variable where the
captcha class stores it:

.. code-block:: php
   :linenos:

    if (ExtensionManagementUtility::isLoaded('captcha')) {
      session_start();
      $captchaStr = $_SESSION['tx_captcha_string'];
      $_SESSION['tx_captcha_string'] = '';
    } else {
      $captchaStr = -1;
    }

The bold lines are the important ones where the session string is read and subsequently
reset so it cannot be used more than once. In this case the captchaString is set to "-1"
if the captcha extension is not enabled.

All that is left is checking the captcha string. This can be done with a conditional like this:

.. code-block:: php
   :linenos:

    if (... ($captchaStr===-1 || ($captchaStr && $captchaResponse === $captchaStr)) ...) {
      ...
    }

Assuming that the input from the form field "captchaResponse" is found in "$captchaResponse".
Then the right part of above condition will check that they match (and is not unset in
which case cookies might be disabled). The acceptance of the captchaString alternatively
being "-1" is merely a fallback support in case the “captcha” extension is not installed.
So without the captcha extension installed the input will just be accepted. If the captcha
extension is installed validation is required. Of course you can altogether require the captcha
extension for your extension as a dependency if you do not want people to "run the risk" of
not having this security level implemented.

