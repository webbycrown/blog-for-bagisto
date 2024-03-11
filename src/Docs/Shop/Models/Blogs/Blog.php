<?php

namespace Webbycrown\BlogBagisto\Docs\Shop\Models\Blogs;

/**
 * @OA\Schema(
 *     title="Blog",
 *     description="Blog model",
 * )
 */
class Blog
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @OA\Property(
     *     title="Name",
     *     description="Blog's name",
     *     example="Women Apparel"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Slug",
     *     description="Blog's slug",
     *     example="women-apparel"
     * )
     *
     * @var string
     */
    public $slug;

    /**
     * @OA\Property(
     *     title="Short Description",
     *     description="Blog's short description",
     *     example="Lorem Ipsum is simply dummy text of the printing and typesetting industry."
     * )
     *
     * @var string
     */
    public $short_description;

    /**
     * @OA\Property(
     *     title="Description",
     *     description="Blog's description",
     *     example="Lorem Ipsum is simply dummy text of the printing and typesetting industry."
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Meta Title",
     *     description="Blog's meta title",
     *     example="Women Apparel"
     * )
     *
     * @var string
     */
    public $meta_title;

    /**
     * @OA\Property(
     *     title="Meta Description",
     *     description="Blog's meta description",
     *     example="Women Apparel"
     * )
     *
     * @var string
     */
    public $meta_description;

    /**
     * @OA\Property(
     *     title="Meta Keywords",
     *     description="Blog's meta keywords",
     *     example="Women Apparel"
     * )
     *
     * @var string
     */
    public $meta_keywords;

    /**
     * @OA\Property(
     *     title="Status",
     *     description="Blog's status",
     *     example=1,
     *     enum={"0", "1"}
     * )
     *
     * @var integer
     */
    public $status;
    
    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $updated_at;
}