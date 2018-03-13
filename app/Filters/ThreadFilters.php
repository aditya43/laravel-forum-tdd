<?php
namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popular'];

    /**
     * Filter the query by a given username.
     *
     * @param  string $username
     * @return Builder
     */
    protected function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->query->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads based on their replies count.
     *
     * @param  string $username
     * @return Builder
     */
    protected function popular()
    {
        $this->query->getQuery()->orders = [];

        return $this->query->orderBy('replies_count', 'desc');
    }
}