<?php
declare(strict_types=1);

namespace Tests\TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use stdClass;
use TaroHida\Twitter\Tweet\Exception\UserInvalidArgumentException;
use TaroHida\Twitter\Tweet\Tweet;
use TaroHida\Twitter\Tweet\User;

class TweetFactory
{
    private ?int $id;
    private DateTimeImmutable $dateTime;
    private int $user_id;
    private string $source;
    private string $text;
    private ?string $screen_name;
    private ?stdClass $entities;
    private string $user_name;
    private string $profile_image_url;

    public function __construct(
        int               $id = null,
        DateTimeImmutable $datetime = null,
        stdClass          $entities = null,
        string            $source = null,
        string            $text = null,
        int               $user_id = null,
        string            $screen_name = null,
        string            $user_name = null,
        string            $user_profile_image = null
    )
    {
        $this->id = $id ?? 1;
        $this->dateTime = $datetime ?? new DateTimeImmutable('now');
        $this->entities = $entities ?? new stdClass();
        $this->source = $source ?? 'source1';
        $this->text = $text ?? 'text1';
        $this->user_id = $user_id ?? 1;
        $this->screen_name = $screen_name ?? 'screen_name1';
        $this->user_name = $user_name ?? 'name1';
        $this->profile_image_url = $user_profile_image ?? 'https://example.example/path/to/file.png';
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function setDateTime(DateTimeImmutable $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function setUserId(int $user_id)
    {
        $this->user_id = $user_id;
    }

    public function setSource(string $source)
    {
        $this->source = $source;
    }

    public function setScreenName(?string $screen_name)
    {
        $this->screen_name = $screen_name;
    }

    /**
     * @throws UserInvalidArgumentException
     */
    public function createInstance(): Tweet
    {
        return new Tweet(
            $this->id,
            $this->dateTime,
            $this->entities,
            $this->source,
            $this->text,
            new User(
                $this->user_id,
                $this->screen_name,
                $this->user_name,
                $this->profile_image_url
            )
        );
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }
}