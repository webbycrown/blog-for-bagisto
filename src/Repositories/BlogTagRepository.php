<?php

namespace Webbycrown\BlogBagisto\Repositories;

use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Event;

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

        $tags = $this->create($data);

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

        $tag = $this->update($data, $id);

        Event::dispatch('admin.blog.tags.update.after', $tag);

        return true;
    }

    /**
     * Delete a blog tag item and delete the image from the disk or where ever it is.
     *
     * @param  int  $id
     * @return bool
     */
    public function destroy($id)
    {
        Event::dispatch('admin.blog.tags.delete.before', $id);

        parent::delete($id);

        Event::dispatch('admin.blog.tags.delete.after', $id);
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