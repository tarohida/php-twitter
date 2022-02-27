<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface QuoteRetweetClientInterface
{
    public function postQuoteTweetWith(string $message, Tweet $quoted_tweet): void;
}