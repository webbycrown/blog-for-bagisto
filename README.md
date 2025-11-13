# WebbyCrown Blog Extension for Bagisto

## 1. Introduction:

"Blog for Bagisto" extension offers free, advanced-level features allowing seamless integration of blogs into Bagisto stores. It includes SEO-friendly URLs, categorized blogs, responsive images, comment widgets, customizable widgets, and blogs import/export.

* SEO-friendly URL by navigating blog pages by page number and organizing posts by primary category and unique slug.
* Blogs organized by category, tag, and author, enhancing user navigation and enabling focused browsing within specific content categories.
* Responsive images across various devices and screen sizes for optimal user experience.
* Show categories and tags with the number of posts associated.
* Allows choice to enable/disable comment widget independently for each post, providing control over user interaction on specific blog entries.
* Various widgets available: recent posts on homepage, related posts on detail page, and recent posts with nested replies support.
* Enables posts and comments to support nested replies, facilitating organized discussions with threaded responses for enhanced engagement and interaction.
* Allows users to designate a specific date for publishing individual blog posts within the Bagisto extension.
* import/export features for easy content management: upload CSV files to add or update posts and export data for backup or transfer, streamlining blog organization and upkeep.



## 2. Requirements:

* **PHP**: 8.0 or higher.
* **Bagisto**: v2.0.*
* **Composer**: 1.6.5 or higher.

## 3. Installation:

- Run the following command
```
composer require webbycrown/blog-for-bagisto
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
## 📊 Changelog

### v1.0.1

- 🖼️ **Tag Image Support** - Added image upload functionality for blog tags
- 📸 Image upload capability in admin tag creation and edit forms with preview
- 🎨 Automatic image conversion to **WebP format** for optimized performance
- 📁 Organized image storage in structured directories (`blog-tag/{tag_id}/`)
- ✅ Image validation supporting multiple formats (bmp, jpeg, jpg, png, webp)
- 🔄 Enhanced **BlogTagRepository** with comprehensive image management
- 🎯 Updated Tag model with `image_url` accessor for storage URL generation
- 💎 Improved admin UI layout with better styling for tag management
- 🛍️ Shop frontend now displays custom tag images instead of placeholder banners
- 🧹 Automatic cleanup of old images when updating or deleting tags
- 🐛 Code quality improvements based on Bagisto community feedback
- 🔧 Fixed missing accessor method in Tag model to prevent display errors

---

### v1.0.0

- ✨ Initial release of **Blog for Bagisto** extension
- 🔍 SEO-friendly URL structure with page navigation and category organization
- 📂 Blog organization by category, tag, and author for enhanced navigation
- 📱 Responsive image support across all devices and screen sizes
- 🏷️ Category and tag display with associated post counts
- 💬 Configurable comment widget for individual posts with nested reply support
- 🎛️ Multiple widgets: recent posts, related posts, and nested replies
- 📅 Scheduled publishing for individual blog posts
- 📤 Import/Export functionality via CSV for easy content management
- 🌍 Multi-language support (English, Portuguese BR, Turkish)
- 🎨 Admin panel for complete blog management
- 🛒 Shop frontend with default and Velocity theme support
- 🔎 SEO meta tags support for all blog content
- 🗑️ Soft delete functionality for blogs, categories, tags, and comments
- 🚀 Published to Composer: [webbycrown/blog-for-bagisto](https://packagist.org/packages/webbycrown/blog-for-bagisto)

---

<div align="center">
  <strong>Made with ❤️ by <a href="https://webbycrown.com">WebbyCrown</a></strong>
</div>
