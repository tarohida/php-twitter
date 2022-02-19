<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface QuoteRetweetClientInterface
{
    public function postQuoteTweetWith(Tweet $tweet, string $message): void;
}