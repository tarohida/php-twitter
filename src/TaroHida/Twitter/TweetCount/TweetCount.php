<?php
declare(strict_types=1);

namespace TaroHida\Twitter\TweetCount;

use TaroHida\Twitter\TweetCount\Exception\TweetCountValidateException;
use TaroHida\Types\Exception\PhpTypesInvalidArgumentException;
use TaroHida\Types\PositiveInteger;

class TweetCount
{
    private PositiveInteger $count;

    /**
     * @throws TweetCountValidateException
     */
    public function __construct(int $count)
    {
        try {
            $this->count = new PositiveInteger($count);
        } catch (PhpTypesInvalidArgumentException $e) {
            throw new TweetCountValidateException();
        }
    }

    /**
     * @throws TweetCountValidateException
     */
    public static function createFromRawParam($count): TweetCount
    {
        if (!is_numeric($count)) {
            throw new TweetCountValidateException();
        }
        return new TweetCount((int)$count);
    }

    public function getCount(): int
    {
        return $this->count->getValue();
    }
}