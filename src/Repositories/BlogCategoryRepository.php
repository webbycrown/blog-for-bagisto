<?php

namespace Webbycrown\BlogBagisto\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class BlogCategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webbycrown\BlogBagisto\Models\Category';
    }

    /**
     * Save blog category.
     *
     * @param  array  $data
     * @return bool|\Webbycrown\BlogBagisto\Contracts\Category
     */
    public function save(array $data)
    {
        Event::dispatch('admin.blog.categories.create.before', $data);

        $create_data = $data;

        if ( array_key_exists('image', $create_data) ) {
            unset($create_data['image']);
        }

        $categories = $this->create($create_data);

        $this->uploadImages($data, $categories);

        Event::dispatch('admin.blog.categories.create.after', $categories);

        return true;
    }

    /**
     * Update item.
     *
     * @param  array  $data
     * @param  int  $id
     * @return bool
     */
    public function updateItem(array $data, $id)
    {
        Event::dispatch('admin.blog.categories.update.before', $id);

        $update_data = $data;

        if ( array_key_exists('image', $update_data) ) {
            unset($update_data['image']);
        }

        $categories = $this->update($update_data, $id);

        $this->uploadImages($data, $categories);

        Event::dispatch('admin.blog.categories.update.after', $categories);

        return true;
    }

    /**
     * Upload category's images.
     *
     * @param  array  $data
     * @param  \Webkul\Category\Contracts\Category  $category
     * @param  string  $type
     * @return void
     */
    public function uploadImages($data, $category, $type = 'image')
    {
        if (isset($data[$type])) {
            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;

                $dir = 'blog-category/' . $category->id;

                if (request()->hasFile($file)) {
                    if ($category->{$type}) {
                        Storage::delete($category->{$type});
                    }

                    $manager = new ImageManager();

                    $image = $manager->make(request()->file($file))->encode('webp');

                    $category->{$type} = 'blog-category/' . $category->id . '/' . Str::random(40) . '.webp';

                    Storage::put($category->{$type}, $image);

                    $category->save();
                }
            }
        } else {
            if ($category->{$type}) {
                Storage::delete($category->{$type});
            }

            $category->{$type} = null;

            $category->save();
        }
    }

    /**
     * Delete a blog category item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        $categoryItem = $this->find($id);

        $categoryItemImage = $categoryItem->image;

        Storage::delete($categoryItemImage);

        return $this->model->destroy($id);
    }

    /**
     * Get only active blog categories.
     *
     * @return array
     */
    public function getActiveBlogCategories()
    {
        $currentLocale = core()->getCurrentLocale();

        return $this->whereRaw("find_in_set(?, locale)", [$currentLocale->code])
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->toArray();
    }
}