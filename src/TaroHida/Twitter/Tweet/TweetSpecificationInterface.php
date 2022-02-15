<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface TweetSpecificationInterface
{
    public function isSatisfiedFrom(Tweet $tweet): bool;
}