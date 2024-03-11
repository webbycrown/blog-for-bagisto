# WebbyCrown Blog Extension for Bagisto

## 1. Introduction:

"Blog for Bagisto" extension offers free, advanced-level features allowing seamless integration of blogs into Bagisto stores. It includes SEO-friendly URLs, categorized blogs, responsive images, comment widgets, and customizable widgets.

* SEO-friendly URL by navigating blog pages by page number and organizing posts by primary category and unique slug.
* Blogs organized by category, tag, and author, enhancing user navigation and enabling focused browsing within specific content categories.
* Responsive images across various devices and screen sizes for optimal user experience.
* Show categories and tags with the number of posts associated.
* Allows choice to enable/disable comment widget independently for each post, providing control over user interaction on specific blog entries.
* Various widgets available: recent posts on homepage, related posts on detail page, and recent posts with nested replies support.
* Enables posts and comments to support nested replies, facilitating organized discussions with threaded responses for enhanced engagement and interaction.
* Allows users to designate a specific date for publishing individual blog posts within the Bagisto extension.


## 2. Requirements:

* **PHP**: 8.0 or higher.
* **Bagisto**: v2.0.*
* **Composer**: 1.6.5 or higher.

## 3. Installation:

- Run the following command
```
composer require webbycrown/blog-for-bagisto:dev-main
```

- Run these commands below to complete the setup
```
composer dump-autoload
```

- Run these commands below to complete the setup
```
php artisan migrate
```
```
php artisan storage:link
```
```
php artisan optimize:clear
```
```
php artisan vendor:publish --all
```

- Now to use the admin side:
```
https://example.com/admin/blog
```

- Now to use the eCommerce side:
```
https://example.com/blog
```