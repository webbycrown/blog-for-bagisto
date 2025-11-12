<?php

namespace Webbycrown\BlogBagisto\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class BlogTagRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Webbycrown\BlogBagisto\Models\Tag';
    }

    /**
     * Save blog tag.
     *
     * @param  array  $data
     * @return bool|\Webbycrown\BlogBagisto\Contracts\Tag
     */
    public function save(array $data)
    {
        Event::dispatch('admin.blog.tags.create.before', $data);

        $create_data = $data;

        if ( array_key_exists('image', $create_data) ) {
            unset($create_data['image']);
        }

        $tags = $this->create($create_data);

        $this->uploadImages($data, $tags);

        Event::dispatch('admin.blog.tags.create.after', $tags);

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
        Event::dispatch('admin.blog.tags.update.before', $id);

        $update_data = $data;

        if ( array_key_exists('image', $update_data) ) {
            unset($update_data['image']);
        }

        $tag = $this->update($update_data, $id);

        $this->uploadImages($data, $tag);

        Event::dispatch('admin.blog.tags.update.after', $tag);

        return true;
    }

    /**
     * Upload tag's images.
     *
     * @param  array  $data
     * @param  \Webkul\tag\Contracts\tag  $tag
     * @param  string  $type
     * @return void
     */
    public function uploadImages($data, $tag, $type = 'image')
    {
        if (isset($data[$type])) {
            foreach ($data[$type] as $imageId => $image) {
                $file = $type . '.' . $imageId;

                $dir = 'blog-tag/' . $tag->id;

                if (request()->hasFile($file)) {
                    if ($tag->{$type}) {
                        Storage::delete($tag->{$type});
                    }

                    $manager = new ImageManager();

                    $image = $manager->make(request()->file($file))->encode('webp');

                    $tag->{$type} = 'blog-tag/' . $tag->id . '/' . Str::random(40) . '.webp';

                    Storage::put($tag->{$type}, $image);

                    $tag->save();
                }
            }
        } else {
            if ($tag->{$type}) {
                Storage::delete($tag->{$type});
            }

            $tag->{$type} = null;

            $tag->save();
        }
    }

    /**
     * Delete a blog tag item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
       $tagItem = $this->find($id);

        $tagItemImage = $tagItem->image;

        Storage::delete($tagItemImage);

        return $this->model->destroy($id);
    }

    /**
     * Get only active blog tags.
     *
     * @return array
     */
    public function getActiveBlogTags()
    {
        $currentLocale = core()->getCurrentLocale();

        return $this->whereRaw("find_in_set(?, locale)", [$currentLocale->code])
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->toArray();
    }
}