<?php
/**
 * Forum repository decorator, providing caching of forums.
 *
 * @version 1.0.0
 * @author MyBB Group
 * @license LGPL v3
 */

namespace MyBB\Core\Database\Repositories\Decorators\Forum;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use MyBB\Core\Database\Repositories\IForumRepository;

class CachingDecorator implements IForumRepository
{
    /** @var IForumRepository $decoratedRepository */
    private $decoratedRepository;
    /** @var CacheRepository $cache */
    private $cache;

    public function __construct(IForumRepository $decorated, CacheRepository $cache)
    {
        $this->decoratedRepository = $decorated;
        $this->cache = $cache;
    }

    /**
     * Get all forums.
     *
     * @return mixed
     */
    public function all()
    {
        if (($forums = $this->cache->get('forums.all')) == null) {
            $forums = $this->decoratedRepository->all();
            $this->cache->forever('forums.all', $forums);
        }

        return $forums;
    }

    /**
     * Get a single forum by ID.
     *
     * @param int $id The ID of the forum.
     *
     * @return mixed
     */
    public function find($id = 0)
    {
        // TODO: Implement find() method.
    }

    /**
     * Get a single forum by slug (name, sluggified, eg: 'my-first-forum').
     *
     * @param string $slug The slug for the forum.
     *
     * @return mixed
     */
    public function findBySlug($slug = '')
    {
        // TODO: Implement findBySlug() method.
    }

    /**
     * Get the forum tree for the index, consisting of root forums (categories), and one level of descendants.
     *
     * @return mixed
     */
    public function getIndexTree()
    {
        if (($forums = $this->cache->get('forums.index_tree')) == null) {
            $forums = $this->decoratedRepository->getIndexTree();
            $this->cache->forever('forums.index_tree', $forums);
        }

        return $forums;
    }
}