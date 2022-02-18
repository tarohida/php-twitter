<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface RetweetClientInterface
{
    public function retweet(int $tweet_id): void;
}