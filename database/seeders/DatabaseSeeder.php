<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаём 10 пользователей
        User::factory(10)->create()->each(function ($user) {
            // Каждый пишет 5 комментариев
            $comments = Comment::factory(5)->make();
            $user->comments()->saveMany($comments);
        });

        $users = User::all();
        $comments = Comment::all();

        // Каждому комментарию даём 0–10 лайков от разных пользователей
        foreach ($comments as $comment) {
            $likers = $users->random(rand(0, 10));
            foreach ($likers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                ]);
            }
        }
    }
}
