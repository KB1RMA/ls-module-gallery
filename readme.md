# ls-module-gallery
LemonStand module that provides basic gallery functionality.

## Installation
1. Download [Gallery](https://github.com/limewheel/ls-module-gallery/zipball/master)
1. Create a folder named `gallery` in the `modules` directory.
1. Extract all files into the `modules/gallery` directory (`modules/gallery/readme.md` should exist).
1. Done!

## Usage

Create or edit a page. Choose 'gallery:sets' as your Page Action. In your code, use something like this:

```php
<? foreach($sets as $set): ?>
  <?= $set->title ?>
  <?= $set->description ?>
  <? foreach($set->images as $image): ?>
    <img src="<?= $image->getThumbnailPath(200, 'auto') ?>" />
  <? endforeach ?>
<? endforeach ?> 
```