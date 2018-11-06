<?php

declare(strict_types=1);

namespace App\Model;

use App\Helper\ArrayHelper;
use App\Helper\IpHelper;

/**
 * Class UserModel
 *
 * @package App\Model
 */
class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $timestamps = true;

    // 被禁用的用户也是真实用户，不作为软删除字段处理

    protected $columns = [
        'user_id',
        'username',
        'email',
        'avatar',
        'cover',
        'password',
        'create_ip',
        'last_login_time',
        'last_login_ip',
        'follower_count',
        'following_article_count',
        'following_question_count',
        'following_topic_count',
        'following_user_count',
        'article_count',
        'question_count',
        'answer_count',
        'notification_unread',
        'inbox_unread',
        'headline',
        'bio',
        'blog',
        'company',
        'location',
        'create_time',
        'update_time',
        'disable_time',
    ];

    /**
     * 密码加密方式
     *
     * @param  string      $password
     * @return bool|string
     */
    private function passwordHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    protected function beforeInsert(array $data): array
    {
        $data = ArrayHelper::fill($data, [
            'avatar' => '',
            'cover' => '',
            'create_ip' => IpHelper::get(),
            'last_login_time' => $this->request->getServerParams()['REQUEST_TIME'],
            'last_login_ip' => IpHelper::get(),
            'follower_count' => 0,
            'following_article_count' => 0,
            'following_question_count' => 0,
            'following_topic_count' => 0,
            'following_user_count' => 0,
            'article_count' => 0,
            'question_count' => 0,
            'answer_count' => 0,
            'notification_unread' => 0,
            'inbox_unread' => 0,
            'headline' => '',
            'bio' => '',
            'blog' => '',
            'company' => '',
            'location' => '',
            'disable_time' => 0,
        ]);

        $data['password'] = $this->passwordHash($data['password']);

        return $data;
    }

    protected function beforeUpdate(array $data): array
    {
        if (isset($data['password'])) {
            $data['password'] = $this->passwordHash($data['password']);
        }

        return $data;
    }
}
