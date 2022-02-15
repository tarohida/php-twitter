<?php
declare(strict_types=1);

namespace tarospace\Domain\Twitter\TweetCount;

use TaroHida\Types\Exception\PhpTypesInvalidArgumentException;
use TaroHida\Types\PositiveInteger;
use tarospace\Domain\Twitter\TweetCount\Exception\TweetCountValidateException;

class TweetCount
{
    private PositiveInteger $count;

    public function getCount(): int
    {
        return $this->count->getValue();
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
}