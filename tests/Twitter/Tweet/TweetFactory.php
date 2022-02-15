<?php
declare(strict_types=1);

namespace Tests\Twitter\Tweet;

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

    public function __construct()
    {
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
            $this->id ?? 1,
            $this->dateTime ?? new DateTimeImmutable('now'),
            new stdClass(),
            $this->source ?? 'source1',
            $this->text ?? 'text1',
            new User(
                $this->user_id ?? 1,
                $this->screen_name ?? 'screen_name1',
                'name1',
                'https://example.example/path/to/file.png'
            )
        );
    }

    public function setText(string $text)
    {
        $this->text = $text;
    }
}