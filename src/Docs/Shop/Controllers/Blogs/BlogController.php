<?php

namespace Webbycrown\BlogBagisto\Docs\Shop\Controllers\Blogs;

class BlogController
{
	/**
	 * @OA\Get(
	 *      path="/api/v1/blogs",
	 *      operationId="getShopBlogs",
	 *      tags={"Blogs"},
	 *      summary="Get blog list for the shop",
     *      description="Returns blog list, if you want to retrieve all blog at once pass pagination=0 otherwise ignore this parameter",
     *      @OA\Parameter(
     *          name="id",
     *          description="Blog ID",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="sort",
     *          description="Sort column",
     *          example="id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="order",
     *          description="Sort order",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *              enum={"desc", "asc"}
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          description="Limit",
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/Blog")
     *              ),
     *          )
     *      )
	 * )
	 */
	public function list()
	{
	}

}