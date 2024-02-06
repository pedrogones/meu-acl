<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //,
        Post::class=>PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

        if(Schema::hasTable('permissions')){
            $permissions=Permission::all();
            $permissions->each(function($permission){
                Gate::define($permission->name, function($user) use($permission){
                    return $user->hasPermission($permission->name);
                });
            });
        }
        //Super admin

        Gate::before(function($user){
            if($user->hasRole('Super Admin')){
                return true;
            }
        });
    }
}
