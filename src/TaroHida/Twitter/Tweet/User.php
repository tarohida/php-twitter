<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;


use TaroHida\Twitter\Tweet\Exception\UserIdValidateException;
use TaroHida\Twitter\Tweet\Exception\UserInvalidArgumentException;

class User
{
    private UserId $id;
    private string $screen_name;
    private string $name;
    private string $profile_image_url_origin;

    /**
     * @throws \TaroHida\Twitter\Tweet\Exception\UserInvalidArgumentException
     */
    public function __construct(int $user_id, string $screen_name, string $name, string $profile_image_url)
    {
        try {
            $this->id = new UserId($user_id);
            $this->screen_name = $screen_name;
            $this->name = $name;
            $this->profile_image_url_origin = $profile_image_url;
        } catch (UserIdValidateException $e) {
            throw new UserInvalidArgumentException('', 0, $e);
        }
    }

    public function id(): int
    {
        return $this->id->getId();
    }

    public function screenName(): string
    {
        return $this->screen_name;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function profileImageUrl(): string
    {
        return $this->profile_image_url_origin;
    }
}