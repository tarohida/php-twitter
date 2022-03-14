<?php
/** @noinspection NonAsciiCharacters */
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use stdClass;
use TaroHida\Twitter\Tweet\Exception\TweetValidateException;

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

    /**
     * @throws TweetValidateException
     */
    public function __construct(
        int               $id,
        DateTimeImmutable $datetime,
        stdClass          $entities,
        string            $source,
        string            $text,
        int               $user_id,
        string            $screen_name,
        string            $user_name,
        string            $user_profile_image_url
    )
    {
        $this->id = $id;
        $this->datetime = $datetime;
        $this->entities = $entities;
        $this->source = $source;
        $this->text = $text;
        try {
            $this->user = new User(
                $user_id,
                $screen_name,
                $user_name,
                $user_profile_image_url
            );
        } catch (Exception\UserInvalidArgumentException $e) {
            throw new TweetValidateException('コンストラクタ引数が不正です。', 0, $e);
        }
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

    public function getUserId(): int
    {
        return $this->user->id();
    }

    public function getUserScreenName(): string
    {
        return $this->user->screenName();
    }

    public function getUserName(): string
    {
        return $this->user->name();
    }

    public function getUserProfileImageUrl(): string
    {
        return $this->user->profileImageUrl();
    }

    public function getEntities(): stdClass
    {
        return $this->entities;
    }

    public function matchTo(TweetSpecificationInterface $specification): bool
    {
        return $specification->isSatisfiedFrom($this);
    }

    public function retweetBy(RetweetClientInterface $client)
    {
        $client->retweet($this->id);
    }

    public function favoriteBy(FavoriteClientInterface $client)
    {
        $client->favorite($this->id);
    }

    public function retweetWithQuoteBy(QuoteRetweetClientInterface $client, string $tweet_message)
    {
        $client->postQuoteTweetWith($tweet_message, $this);
    }

    public function replyWithMessageBy(ReplyClientInterface $client, string $reply_message)
    {
        $client->replyTo($this, $reply_message);
    }

    public function isReply(): bool
    {
        if (!isset($this->entities->user_mentions) || empty($this->entities->user_mentions)) {
            return false;
        }
        return true;
    }
}