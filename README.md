# li3_bootstrap

Lithium plugin to easily use [twitters bootstrap](https://github.com/twitter/bootstrap).

## Installation

Add submodule to your li3 libraries:

	git submodule add https://github.com/bruensicke/li3_bootstrap.git libraries/li3_bootstrap

and activate it in you app (`config/bootstrap/libraries.php`), of course:

	Libraries::add('li3_bootstrap');

*Note: `li3_bootstrap` supports usage of `.less` files, in order to do so, you need `li3_less`, see below for details*

## Requirements

- [lithium li3](https://github.com/UnionOfRAD/lithium)

*Optional*

- [li3_less](https://github.com/bruensicke/li3_less)

In order to use the .less files, instead of .css - you need the `li3_less` library and load it _before_ loading li3_bootstrap.

	Libraries::add('li3_less');
	Libraries::add('li3_bootstrap');

## Credits

* [li3](http://www.lithify.me)
* [twitter bootstrap](https://github.com/twitter/bootstrap)
* [head.js](http://headjs.com/)
* [jquery](http://jquery.com/)
* [icanhaz.js](http://icanhazjs.com/)
* [lithim kickstart](https://github.com/bruensicke/lithium_kickstart)

