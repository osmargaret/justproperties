<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_subscriptions', function (Blueprint $table) {
            if(!Schema::hasColumn('blog_subscriptions', 'email')) {
                $table->string('email')->nullable()->after('id');
            }
        });

        DB::table('blog_subscriptions')
            ->select(['id', 'user_id'])
            ->orderBy('id')
            ->chunkById(500, function ($subscriptions): void {
                $emails = DB::table('users')
                    ->whereIn('id', $subscriptions->pluck('user_id')->unique())
                    ->pluck('email', 'id');

                foreach ($subscriptions as $subscription) {
                    $email = $emails->get($subscription->user_id);

                    if (! $email) {
                        throw new RuntimeException(
                            "Cannot migrate blog subscription {$subscription->id}: its user email is missing."
                        );
                    }

                    DB::table('blog_subscriptions')
                        ->where('id', $subscription->id)
                        ->update(['email' => mb_strtolower(trim($email))]);
                }
            });

        $subscriptions = DB::table('blog_subscriptions')
            ->select(['id', 'email', 'category_id', 'post_id', 'property_id', 'get_new_posts', 'get_comments', 'deleted_at'])
            ->orderBy('id')
            ->get()
            ->all();

        $parents = array_keys($subscriptions);
        $find = function (int $index) use (&$parents, &$find): int {
            if ($parents[$index] !== $index) {
                $parents[$index] = $find($parents[$index]);
            }

            return $parents[$index];
        };
        $union = function (int $left, int $right) use (&$parents, &$find): void {
            $leftRoot = $find($left);
            $rightRoot = $find($right);

            if ($leftRoot !== $rightRoot) {
                $parents[$rightRoot] = $leftRoot;
            }
        };
        $seen = [];

        foreach ($subscriptions as $index => $subscription) {
            $email = mb_strtolower(trim($subscription->email));
            $keys = [
                "category:{$email}:{$subscription->category_id}",
            ];

            if ($subscription->post_id !== null) {
                $keys[] = "post:{$email}:{$subscription->post_id}";
            }

            if ($subscription->property_id !== null) {
                $keys[] = "property:{$email}:{$subscription->property_id}";
            }

            foreach ($keys as $key) {
                if (isset($seen[$key])) {
                    $union($index, $seen[$key]);
                } else {
                    $seen[$key] = $index;
                }
            }
        }

        $groups = [];

        foreach ($subscriptions as $index => $subscription) {
            $groups[$find($index)][] = $subscription;
        }

        foreach ($groups as $group) {
            if (count($group) === 1) {
                continue;
            }

            usort($group, function ($left, $right): int {
                $leftActive = $left->deleted_at === null;
                $rightActive = $right->deleted_at === null;
                $leftSpecificity = (int) ($left->post_id !== null) + (int) ($left->property_id !== null);
                $rightSpecificity = (int) ($right->post_id !== null) + (int) ($right->property_id !== null);

                return ($rightActive <=> $leftActive)
                    ?: ($rightSpecificity <=> $leftSpecificity)
                    ?: ($left->id <=> $right->id);
            });

            $keeper = array_shift($group);
            $getNewPosts = (bool) $keeper->get_new_posts;
            $getComments = (bool) $keeper->get_comments;

            foreach ($group as $duplicate) {
                $getNewPosts = $getNewPosts || (bool) $duplicate->get_new_posts;
                $getComments = $getComments || (bool) $duplicate->get_comments;
            }

            DB::table('blog_subscriptions')
                ->where('id', $keeper->id)
                ->update([
                    'email' => mb_strtolower(trim($keeper->email)),
                    'get_new_posts' => $getNewPosts,
                    'get_comments' => $getComments,
                ]);

            DB::table('blog_subscriptions')
                ->whereIn('id', array_map(fn ($duplicate) => $duplicate->id, $group))
                ->delete();
        }

        Schema::table('blog_subscriptions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email')->nullable(false)->change();
            $table->unique(['email', 'post_id'], 'blog_subscriptions_email_post_unique');
            $table->unique(['email', 'property_id'], 'blog_subscriptions_email_property_unique');
            $table->unique(['email', 'category_id'], 'blog_subscriptions_email_category_unique');
        });
    }

    public function down(): void
    {
        Schema::table('blog_subscriptions', function (Blueprint $table) {
            $table->dropUnique('blog_subscriptions_email_post_unique');
            $table->dropUnique('blog_subscriptions_email_property_unique');
            $table->dropUnique('blog_subscriptions_email_category_unique');
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users');
        });

        DB::table('blog_subscriptions')
            ->select(['id', 'email'])
            ->orderBy('id')
            ->chunkById(500, function ($subscriptions): void {
                $userIds = DB::table('users')
                    ->whereIn(
                        DB::raw('LOWER(email)'),
                        $subscriptions->pluck('email')->map(fn ($email) => mb_strtolower($email))->unique()
                    )
                    ->get(['id', 'email'])
                    ->mapWithKeys(fn ($user) => [mb_strtolower($user->email) => $user->id]);

                foreach ($subscriptions as $subscription) {
                    $userId = $userIds->get(mb_strtolower($subscription->email));

                    if ($userId !== null) {
                        DB::table('blog_subscriptions')
                            ->where('id', $subscription->id)
                            ->update(['user_id' => $userId]);
                    }
                }
            });

        Schema::table('blog_subscriptions', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->index('user_id');
        });
    }
};
