<?php
/** @noinspection NonAsciiCharacters */
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use stdClass;

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

    /** @noinspection PhpUnused */
    public function getUser(): User
    {
        trigger_error('Method ' . __METHOD__ . ' is deprecated, and will be removed v3.0', E_USER_DEPRECATED);
        return $this->user;
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

    public function quoteBy(QuoteRetweetClientInterface $client, string $tweet_message)
    {
        $client->postQuoteTweetWith($this, $tweet_message);
    }
}