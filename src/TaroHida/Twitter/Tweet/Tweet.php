<?php
/** @noinspection NonAsciiCharacters */
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use stdClass;
use TaroHida\Twitter\Tweet\Exception\TweetValidateException;
use TaroHida\Twitter\Tweet\Exception\UserInvalidArgumentException;

class Tweet
{
    /**
     * @var DateTimeImmutable
     */
    private DateTimeImmutable $datetime;

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $text;

    /**
     * @var string
     */
    private string $source;

    private User $user;

    /**
     * @var stdClass
     */
    private stdClass $entities;

    public function __construct(
        int               $id,
        DateTimeImmutable $datetime,
        stdClass          $entities,
        string            $source,
        string            $text,
        User              $user
    )
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->entities = $entities;
        $this->source = $source;
        $this->text = $text;
        $this->user = $user;
    }

    /**
     * @throws TweetValidateException
     */
    public static function fromApiResult(stdClass $raw_tweet): self
    {
        if (!is_numeric($raw_tweet->id)) {
            throw new TweetValidateException('id が数値ではありません');
        }
        try {
            $format = 'D M j H:i:s P Y';
            $datetime = DateTimeImmutable::createFromFormat(
                $format,
                $raw_tweet->created_at,
                new DateTimeZone('UTC')
            );
        } catch (Exception $ex) {
            throw new TweetValidateException('created_at の値が不正です');
        }
        $id = (int)$raw_tweet->id;
        $text = $raw_tweet->full_text;
        $source = $raw_tweet->source;
        if (!is_numeric($raw_tweet->user->id)) {
            throw new TweetValidateException('user_id が数値でありません');
        }
        try {
            $user = new User(
                $raw_tweet->user->id,
                $raw_tweet->user->screen_name,
                $raw_tweet->user->name,
                $raw_tweet->user->profile_image_url
            );
        } catch (UserInvalidArgumentException $e) {
            throw new TweetValidateException('user の形式が不正');
        }
        $entities = $raw_tweet->entities;
        return new self($id, $datetime, $entities, $source, $text, $user);
    }

    public function equals(self $tweet): bool
    {
        return $this->id === $tweet->id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getDateTime(): DateTimeImmutable
    {
        return $this->datetime;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getEntities(): stdClass
    {
        return $this->entities;
    }

    public function matchTo(TweetSpecificationInterface $specification): bool
    {
        return $specification->isSatisfiedFrom($this);
    }
}