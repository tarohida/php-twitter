<?php
declare(strict_types=1);

namespace TaroHida\Twitter\Tweet;

interface ReplyClientInterface
{
    public function replyTo(Tweet $tweet, string $with_message): void;
}