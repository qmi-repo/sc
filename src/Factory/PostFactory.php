<?php

namespace QMILibs\StardustConnectClient\Factory;

use QMILibs\StardustConnectClient\HttpClient\HttpClient;
use QMILibs\StardustConnectClient\Model\Common\GenericCollection;
use QMILibs\StardustConnectClient\Model\UserCellphone;
use QMILibs\StardustConnectClient\Model\Post;

/**
 * Class TokenFactory
 * @package QMILibs\StardustConnectClient\Factory
 */
class PostFactory extends AbstractFactory
{
    /**
     * MovieFactory constructor.
     *
     * @param HttpClient $httpClient
     */
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);
    }

    /**
     * @param  array $data
     *
     * @return Post
     */
    public function create(array $data = [])
    {
        if (!$data) {
            return NULL;
        }

        $favoritePost = new Post();
        /** @var Post $favoritePost */
        $favoritePost = $this->hydrate($favoritePost, $data);
        return $favoritePost;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(array $data = [])
    {
        $collection = new GenericCollection();

        if (array_key_exists('_embedded', $data) && array_key_exists('posts', $data['_embedded']) && is_array($data['_embedded']['posts'])) {
            $data = $data['_embedded']['posts'];
        }

        foreach ($data as $item) {
            $collection->add(NULL, $this->create($item));
        }

        return $collection;
    }
}
