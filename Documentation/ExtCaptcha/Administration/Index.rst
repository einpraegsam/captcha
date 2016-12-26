

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


Administration
--------------

To install the extension just install it as usual using the Extension
Manager. While you are installing the extension you have some options
by which you can configure the captcha image to be generated.

Setting: Basic
^^^^^^^^^^^^^^

- **Use TTF [basic.useTTF]** When set all letters will get rendered
  using "imagettftext". 

.. warning:: The support for non-TTF rendering has been dropped. Always
  keep this checkbox active.

- **Image width [basic.imgWidth]** The width of the captcha image in pixels

- **Image height [basic.imgHeight]** The height of the captcha image in pixels

- **Captcha chars [basic.captchaChars]** The number of characters of which
  the captcha shall consist.

Setting: Characters
^^^^^^^^^^^^^^^^^^^

- **No numbers [characters.noNumbers]** Setting this option will
  remove any number character (0-9) from the list of characters
  (a-zA-z0-9) from which the captcha is generated.

- **No lowercase characters [characters.noLower]** Setting this
  option will remove any lowercase characters (a-z) from the list
  of characters (a-zA-z0-9) from which the captcha is generated.

- **No uppercase characters [characters.noUpper]** Setting this
  option will remove any uppercase characters (a-z) from the list
  of characters (a-zA-z0-9) from which the captcha is generated.

- **Exclude chars [characters.excludeChars]** The characters listed
  in this field will not get used for rendering the captcha. By default
  this field already contains a preset which consists of characters
  that can easily get taken for each other and upper/lower case characters
  which look quite the same.

Setting: Rendering
^^^^^^^^^^^^^^^^^^

- **Y Offset [rendering.ypos]** The numer of pixels which the first
  character is away from the top left corner in vertical direction.
  Incrementing this value moves the rendered captcha "down".

- **Letter spacing [rendering.letterSpacing]** This value determines
  the space in pixels between each cpatcha character.

- **Angle [rendering.angle]** The angle in degree which each letter
  is rotated maximally clock-, or counterclock-wise. The actual angle
  for each character will get determined randomly for each single
  letter.

- **X Difference [rendering.diffx]** The limit in pixels by which
  each letter is shifted to the left/right maximally. By default
  this value is "0" as those values can sum up and result in quite
  different width of the generated captcha which in turn has to
  get taken account for when setting the image width.

- **Y Difference [rendering.diffy]** The limit in pixels by which
  each letter is shifted up/down maximally. The actual amount of
  pixels will get determined randomly for each letter.

- **X Offset [rendering.xpos]** The numer of pixels which the first
  character is away from the top left corner in horizontal direction.
  Incrementing this value moves the rendered captcha "right".

Setting: Background
^^^^^^^^^^^^^^^^^^^

- **Noises [background.noises]** Determines the number of "obfuscating"
  ellipses that will get drawn on the background.

- **Background color [background.backcolor]** The background color of
  the captcha in a format like used in CSS (#12ab34, #ff0000 for red, etc.)

- **Obfuscation color [background.obfusccolor]** The color of the
  obfuscating ellipses.

Setting: Font
^^^^^^^^^^^^^

- **Text color [font.textcolor]** The color of the captcha letters.

- **Font size [font.fontSize]** The font size in pixels.

- **Font file [font.fontFile]** A path to the TTF file which shall be
  used to render the captcha characters. By default the captcha
  extension comes shipped with a "Vera.ttf" font which is an open
  source variant of "Verdana".

- **Bold text [basic.bold]** When set the text in the generated captcha
  image will be somewhat more bold and easier to read. But keep in mind,
  that the sense of a captcha is to make the text unrecognizable for
  computer spam programs.

