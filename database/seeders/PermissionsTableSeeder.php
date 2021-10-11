<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'music_access',
            ],
            [
                'id'    => 18,
                'title' => 'music_item_create',
            ],
            [
                'id'    => 19,
                'title' => 'music_item_edit',
            ],
            [
                'id'    => 20,
                'title' => 'music_item_show',
            ],
            [
                'id'    => 21,
                'title' => 'music_item_delete',
            ],
            [
                'id'    => 22,
                'title' => 'music_item_access',
            ],
            [
                'id'    => 23,
                'title' => 'playlist_create',
            ],
            [
                'id'    => 24,
                'title' => 'playlist_edit',
            ],
            [
                'id'    => 25,
                'title' => 'playlist_show',
            ],
            [
                'id'    => 26,
                'title' => 'playlist_delete',
            ],
            [
                'id'    => 27,
                'title' => 'playlist_access',
            ],
            [
                'id'    => 28,
                'title' => 'music_topic_create',
            ],
            [
                'id'    => 29,
                'title' => 'music_topic_edit',
            ],
            [
                'id'    => 30,
                'title' => 'music_topic_show',
            ],
            [
                'id'    => 31,
                'title' => 'music_topic_delete',
            ],
            [
                'id'    => 32,
                'title' => 'music_topic_access',
            ],
            [
                'id'    => 33,
                'title' => 'curhat_access',
            ],
            [
                'id'    => 34,
                'title' => 'curhatan_create',
            ],
            [
                'id'    => 35,
                'title' => 'curhatan_edit',
            ],
            [
                'id'    => 36,
                'title' => 'curhatan_show',
            ],
            [
                'id'    => 37,
                'title' => 'curhatan_delete',
            ],
            [
                'id'    => 38,
                'title' => 'curhatan_access',
            ],
            [
                'id'    => 39,
                'title' => 'comment_create',
            ],
            [
                'id'    => 40,
                'title' => 'comment_edit',
            ],
            [
                'id'    => 41,
                'title' => 'comment_show',
            ],
            [
                'id'    => 42,
                'title' => 'comment_delete',
            ],
            [
                'id'    => 43,
                'title' => 'comment_access',
            ],
            [
                'id'    => 44,
                'title' => 'journey_group_access',
            ],
            [
                'id'    => 45,
                'title' => 'journal_create',
            ],
            [
                'id'    => 46,
                'title' => 'journal_edit',
            ],
            [
                'id'    => 47,
                'title' => 'journal_show',
            ],
            [
                'id'    => 48,
                'title' => 'journal_delete',
            ],
            [
                'id'    => 49,
                'title' => 'journal_access',
            ],
            [
                'id'    => 50,
                'title' => 'mood_tracker_create',
            ],
            [
                'id'    => 51,
                'title' => 'mood_tracker_edit',
            ],
            [
                'id'    => 52,
                'title' => 'mood_tracker_show',
            ],
            [
                'id'    => 53,
                'title' => 'mood_tracker_delete',
            ],
            [
                'id'    => 54,
                'title' => 'mood_tracker_access',
            ],
            [
                'id'    => 55,
                'title' => 'mood_tracker_reason_create',
            ],
            [
                'id'    => 56,
                'title' => 'mood_tracker_reason_edit',
            ],
            [
                'id'    => 57,
                'title' => 'mood_tracker_reason_show',
            ],
            [
                'id'    => 58,
                'title' => 'mood_tracker_reason_delete',
            ],
            [
                'id'    => 59,
                'title' => 'mood_tracker_reason_access',
            ],
            [
                'id'    => 60,
                'title' => 'journey_create',
            ],
            [
                'id'    => 61,
                'title' => 'journey_edit',
            ],
            [
                'id'    => 62,
                'title' => 'journey_show',
            ],
            [
                'id'    => 63,
                'title' => 'journey_delete',
            ],
            [
                'id'    => 64,
                'title' => 'journey_access',
            ],
            [
                'id'    => 65,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
