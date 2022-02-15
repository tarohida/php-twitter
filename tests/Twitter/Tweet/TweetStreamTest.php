<?php
/** @noinspection NonAsciiCharacters */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */
declare(strict_types=1);

namespace Tests\Twitter\Tweet;

use PHPUnit\Framework\TestCase;
use TaroHida\Twitter\Tweet\Tweet;
use TaroHida\Twitter\Tweet\TweetStream;

class TweetStreamTest extends TestCase
{
    public function test_foreach()
    {
        $tweets = $this->createTweetStream();
        $index = 1;
        foreach ($tweets as $tweet) {
            self::assertSame($index, $tweet->getId());
            $index++;
        }
    }

    protected function createTweetStream(array $ids = [1, 2, 3]): TweetStream
    {
        $tweets = array_map(function ($id) {
            return $this->createTweetInstanceWithId($id);
        }, $ids);
        return new TweetStream($tweets);
    }

    protected function createTweetInstanceWithId(
        int $id = null
    ): Tweet
    {
        $factory = new TweetFactory();
        $factory->setId($id ?? 1);
        return $factory->createInstance();
    }

    public function test_method_filterWith_return_only1_example_specification_3つのTweetの内、idが1のTweet1つのみがfilteringされる()
    {
        $tweet_stream = $this->createTweetStream();
        $specification = new SpecificationExample();
        $tweet_stream = $tweet_stream->filterWith($specification);
        self::assertCount(1, $tweet_stream);
        foreach ($tweet_stream as $tweet) {
            self::assertSame(1, $tweet->getId());
        }
    }

    public function test_method_merge()
    {
        $one = [1, 2, 3];
        $other = [2, 3, 4, 5];
        $expected = [1, 2, 3, 4, 5];
        $this->testMethodMergeOneAndOtherBecomeToExpected($one, $other, $expected);
    }

    private function testMethodMergeOneAndOtherBecomeToExpected(array $one, array $other, array $expected)
    {
        $one = $this->createTweetStream($one);
        $other = $this->createTweetStream($other);
        $merged = $one->merge($other);
        $ids = [];
        foreach ($merged as $tweet) {
            $ids[] = $tweet->getId();
        }
        self::assertSame($expected, $ids);
    }

    public function test_method_sortWithIdDesc()
    {
        $before = [1, 3, 2];
        $expected = [3, 2, 1];
        $this->testMethodSortWithIdBecomeToBeExpected($before, $expected);
    }

    private function testMethodSortWithIdBecomeToBeExpected(array $before, array $expected)
    {
        $before = $this->createTweetStream($before);
        $after = $before->sortWithIdDesc();
        $ids = [];
        foreach ($after as $tweet) {
            $ids[] = $tweet->getId();
        }
        self::assertSame($ids, $expected);
    }
}
