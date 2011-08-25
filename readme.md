# ls-module-gallery
Provides basic galleries for your store.

## Installation
1. Download [Gallery](https://github.com/limewheel/ls-module-gallery/zipball/master)
1. Create a folder named `gallery` in the `modules` directory.
1. Extract all files into the `modules/gallery` directory (`modules/gallery/readme.md` should exist).
1. Setup your galleries in the control panel.
1. Setup your code as described in the `Usage` section.
1. Done!

## Links

* [Marketplace](https://lemonstandapp.com/marketplace/module/gallery/)
* [Discussion](http://forum.lemonstandapp.com/topic/2199-module-gallery/)
* [Source](https://github.com/limewheel/ls-module-gallery)

## Usage
Create or edit a page. Choose 'gallery:sets' as your Page Action. In your code, use something like this:

```php
<? foreach($sets as $set): ?>
  <h2><?= $set->title ?></h2>
  <?= $set->description ?>
  <? foreach($set->images as $image): ?>
    <img src="<?= $image->getThumbnailPath(200, 'auto') ?>" />
  <? endforeach ?>
<? endforeach ?> 
```
