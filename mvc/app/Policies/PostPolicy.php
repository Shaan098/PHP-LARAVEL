<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can create posts
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can like the post.
     */
    public function likePost(User $user, Post $post): bool
    {
        return true; // Any authenticated user can like posts
    }

    /**
     * Determine whether the user can bookmark the post.
     */
    public function bookmarkPost(User $user, Post $post): bool
    {
        return true; // Any authenticated user can bookmark posts
    }
}
