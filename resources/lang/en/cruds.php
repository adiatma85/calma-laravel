<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'jenis_kelamin'            => 'Jenis Kelamin',
            'jenis_kelamin_helper'     => ' ',
        ],
    ],
    'music' => [
        'title'          => 'Music',
        'title_singular' => 'Music',
    ],
    'musicItem' => [
        'title'          => 'Music Item',
        'title_singular' => 'Music Item',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'name'                  => 'Name',
            'name_helper'           => ' ',
            'music_file'            => 'Music File',
            'music_file_helper'     => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'playlist'              => 'Playlist',
            'playlist_helper'       => ' ',
            'duration'              => "Duration",
            'duration_helper'       => ' ',
            'rounded_image'         => 'Rounded Image',
            'rounded_image_helper'  => ' ',
            'squared_image'         => 'Squared Image',
            'squared_image_helper'  => ' ',
        ],
    ],
    'playlist' => [
        'title'          => 'Playlist',
        'title_singular' => 'Playlist',
        'fields'         => [
            'id'                    => 'ID',
            'id_helper'             => ' ',
            'name'                  => 'Name',
            'name_helper'           => ' ',
            'description'           => 'Description',
            'description_helper'    => ' ',
            'image'                 => 'Image',
            'image_helper'          => ' ',
            'created_at'            => 'Created at',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Updated at',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Deleted at',
            'deleted_at_helper'     => ' ',
            'topic'                 => 'Topic',
            'topic_helper'          => ' ',
            'duration'              => "Duration",
            'duration_helper'       => ' ',
            'quantity'              => 'Banyak lagu',
            'quantity_helper'       => ' ',
            'rounded_image'         => 'Rounded Image',
            'rounded_image_helper'  => ' ',
            'squared_image'         => 'Squared Image',
            'squared_image_helper'  => ' ',
        ],
    ],
    'musicTopic' => [
        'title'          => 'Music Topic',
        'title_singular' => 'Music Topic',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'name'               => 'Name',
            'name_helper'        => ' ',
            'description'        => 'Description',
            'description_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'curhat' => [
        'title'          => 'Curhat',
        'title_singular' => 'Curhat',
    ],
    'curhatan' => [
        'title'          => 'Curhatan',
        'title_singular' => 'Curhatan',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'content'                  => 'Content',
            'content_helper'           => ' ',
            'user'                     => 'User',
            'user_helper'              => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'category'                 => 'Kategori',
            'category_helper'          => ' ',
            'is_anonymous'             => 'Status Anonymousity',
            'is_anonymous_helper'      => '',
        ],
    ],
    'comment' => [
        'title'          => 'Comment',
        'title_singular' => 'Comment',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'content'                  => 'Content',
            'content_helper'           => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'is_anonymous'             => 'Status Anonymousity',
            'is_anonymous_helper'      => '',
            'user'                     => 'User',
            'user_helper'              => ' ',
            'curhatan'                 => 'Curhatan',
            'curhatan_helper'          => ' ',
        ],
    ],
    'journeyGroup' => [
        'title'          => 'Journey Group',
        'title_singular' => 'Journey Group',
    ],
    'journal' => [
        'title'          => 'Journal',
        'title_singular' => 'Journal',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'content'           => 'Content',
            'content_helper'    => ' ',
            'category'          => 'Category',
            'category_helper'   => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'journey'           => 'Journey',
            'journey_helper'    => ' ',
            'name'              => 'Nama Journal',
            'name_helper'       => ' ',
            'cover_image'        => 'Cover Image',
            'cover_image_helper' => ' ',
        ],
    ],
    'moodTracker' => [
        'title'          => 'Mood Tracker',
        'title_singular' => 'Mood Tracker',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'mood'              => 'Mood',
            'mood_helper'       => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'moodTrackerReason' => [
        'title'          => 'Mood Tracker Reason',
        'title_singular' => 'Mood Tracker Reason',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'mood_tracker'        => 'Mood Tracker',
            'mood_tracker_helper' => ' ',
            'reason'              => 'Reason',
            'reason_helper'       => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
        ],
    ],
    'journey' => [
        'title'          => 'Journey',
        'title_singular' => 'Journey',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => ' ',
            'user'                => 'User',
            'user_helper'         => ' ',
            'mood_tracker'        => 'Mood Tracker',
            'mood_tracker_helper' => ' ',
            'playlist'            => 'Playlist',
            'playlist_helper'     => ' ',
            'created_at'          => 'Created at',
            'created_at_helper'   => ' ',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => ' ',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => ' ',
            'name'                => 'Name',
            'name_helper'         => ' ',
            'title'               => 'Title',
            'title_helper'        => ' ',
            'author'              => 'Author',
            'author_helper'       => ' ',
            'description'         => 'Description',
            'description_helper'  => ' ',
            'image'               => 'Cover Image',
            'image_helper'        => ' ',
        ],
    ],
    'quote' => [
        'title'          => 'Quote',
        'title_singular' => 'Quote',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'content'           => 'Content',
            'content_helper'    => ' ',
            'author'            => 'Author',
            'author_helper'     => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
            'journey'           => 'Journey',
            'journey_helper'    => ' ',
        ],
    ],
];
