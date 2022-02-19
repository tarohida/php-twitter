<?php
declare(strict_types=1);

namespace Tests\TaroHida\Twitter\Tweet;

use TaroHida\Twitter\Tweet\Tweet;
use TaroHida\Twitter\Tweet\TweetSpecificationInterface;

class SpecificationExample implements TweetSpecificationInterface
{
    public function isSatisfiedFrom(Tweet $tweet): bool
    {
        return $tweet->getId() === 1;
    }
}