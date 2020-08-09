<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    IUser,
    IReaction,
    IChat,
    IInvitation,
    IMessage
};
use App\Repositories\Eloquent\{
    UserRepository,
    ReactionRepository,
    ChatRepository,
    InvitationRespotiroy,
    MessageRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(IUser::class, UserRepository::class);
        $this->app->bind(IReaction::class, ReactionRepository::class);
        $this->app->bind(IChat::class, ChatRepository::class);
        $this->app->bind(IInvitation::class, InvitationRepository);
        $this->app->bind(IMessage::class, MessageRepository::class);
    }
}
