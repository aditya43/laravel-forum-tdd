<?php

namespace App;

trait Favouritable
{
    /**
     * Reply morphs many Favourite.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    /**
     * Favourite the current reply.
     *
     * @return Model
     */
    public function favourite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favourites()->where($attributes)->exists()) {
            return $this->favourites()->create($attributes);
        }
    }

    /**
     * Unfavourite the current reply.
     */
    public function unfavourite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favourites()->where($attributes)->get()->each->delete();
    }

    /**
     * Check if the item is favourited by the currently logged in user.
     *
     * @return boolean [description]
     */
    public function isFavourited()
    {
        return !!$this->favourites->where('user_id', auth()->id())->count();
    }

    /**
     * Get favourites count for the item.
     *
     * @return [type] [description]
     */
    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }

    /**
     * Fetch the favourited status as a property.
     *
     * @return bool
     */
    public function getIsFavouritedAttribute()
    {
        return $this->isFavourited();
    }
}
