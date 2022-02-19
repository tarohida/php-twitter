<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface FavoriteClientInterface
{
    public function favorite(int $tweet_id): void;
}