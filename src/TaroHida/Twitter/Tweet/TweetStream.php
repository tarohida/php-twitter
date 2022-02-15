<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

use Iterator;
use TypeError;

class TweetStream implements Iterator
{
    private array $tweets;
    private int $position;

    public function __construct(array $tweets)
    {
        foreach ($tweets as $tweet) {
            if (!($tweet instanceof Tweet)) {
                throw new TypeError('引数は、 Tweet のインスタンスである必要があります');
            }
        }
        $this->tweets = $tweets;
        $this->position = 0;
    }

    public function current(): Tweet
    {
        return $this->tweets[$this->position];
    }

    public function next()
    {
        ++$this->position;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->tweets[$this->position]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function getLatestTweetTime()
    {
        return $this->tweets[0]->getDateTime();
    }

    public function filterWith(TweetSpecificationInterface $specification): TweetStream
    {
        $ret = [];
        foreach ($this->tweets as $tweet) {
            if ($tweet->matchTo($specification)) {
                $ret[] = $tweet;
            }
        }
        return new self($ret);
    }

    public function merge(self $stream): TweetStream
    {
        $ret = $this->tweets;
        foreach ($stream as $other_tweet) {
            foreach ($this->tweets as $tweet) {
                if ($other_tweet->equals($tweet)) {
                    continue 2;
                }
            }
            $ret[] = $other_tweet;
        }
        return new TweetStream($ret);
    }

    public function sortWithIdDesc(): self
    {
        $ret = $this->tweets;
        usort($ret, function ($one_tweet, $next_tweet) {
            return $one_tweet->getId() < $next_tweet->getId();
        });
        return new TweetStream($ret);
    }
}