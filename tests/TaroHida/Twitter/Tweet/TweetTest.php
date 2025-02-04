<?php
/** @noinspection NonAsciiCharacters */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpDocMissingThrowsInspection */
/** @noinspection PhpPrivateFieldCanBeLocalVariableInspection */
/** @noinspection PhpUnhandledExceptionInspection */
declare(strict_types=1);

namespace Tests\TaroHida\Twitter\Tweet;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use stdClass;
use TaroHida\Twitter\Tweet\FavoriteClientInterface;
use TaroHida\Twitter\Tweet\QuoteRetweetClientInterface;
use TaroHida\Twitter\Tweet\ReplyClientInterface;
use TaroHida\Twitter\Tweet\RetweetClientInterface;
use TaroHida\Twitter\Tweet\Tweet;

class TweetTest extends TestCase
{
    public function test_method_getter()
    {
        $id = 1;
        $datetime = new DateTimeImmutable('now');
        $entities = new stdClass();
        $source = 'source';
        $text = 'text';
        $user_id = 1;
        $screen_name = 'screen_name';
        $name = 'name';
        $profile_image_url = 'https://example.example/path/to/image_normal.png';
        $factory = new TweetFactory(
            $id, $datetime, $entities, $source, $text, $user_id, $screen_name, $name, $profile_image_url
        );
        $tweet = $factory->createInstance();
        self::assertSame($id, $tweet->getId());
        self::assertSame($datetime, $tweet->getDateTime());
        self::assertSame($entities, $tweet->getEntities());
        self::assertSame($source, $tweet->getSource());
        self::assertSame($text, $tweet->getText());
        self::assertSame($user_id, $tweet->getUserId());
        self::assertSame($screen_name, $tweet->getUserScreenName());
        self::assertSame($name, $tweet->getUserName());
        self::assertSame($profile_image_url, $tweet->getUserProfileImageUrl());
    }

    public function test_method_satisfy()
    {
        $this->assertSatisfy(true, 1);
        $this->assertSatisfy(false, 2);
    }

    private function assertSatisfy(bool $expected, int $id)
    {
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $specification = new SpecificationExample();
        self::assertSame($expected, $tweet->matchTo($specification));
    }

    public function test_method_retweetBy()
    {
        $id = 39;
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(RetweetClientInterface::class);
        $client->expects(self::once())
            ->method('retweet')
            ->with($id);
        $tweet->retweetBy($client);
    }

    public function test_method_favoriteBy()
    {
        $id = 39;
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(FavoriteClientInterface::class);
        $client->expects(self::once())
            ->method('favorite')
            ->with($id);
        $tweet->favoriteBy($client);
    }

    public function test_method_quoteRetweetBy()
    {
        $id = 39;
        $tweet_message = 'test message.';
        $factory = new TweetFactory();
        $factory->setId($id);
        $tweet = $factory->createInstance();
        $client = $this->createMock(QuoteRetweetClientInterface::class);
        $client->expects(self::once())
            ->method('postQuoteTweetWith')
            ->with(
                $tweet_message,
                $this->callback(function (Tweet $tweet) use ($id) {
                    return $tweet->getId() === $id;
                })
            );
        $tweet->retweetWithQuoteBy($client, $tweet_message);
    }

    public function test_reply_to_Tweet()
    {
        // setup
        $message = 'test reply message';

        // input
        $factory = new TweetFactory();
        $tweet = $factory->createInstance();

        // expected output
        $client = $this->createMock(ReplyClientInterface::class);
        $client->expects(self::once())
            ->method('replyTo')
            ->with($tweet, $message);

        // perform
        $tweet->replyWithMessageBy($client, $message);
    }

    public function test_ツイートがリプライかどうかを判別する()
    {
        $entities = new stdClass();
        $entities->user_mentions = [];
        $this->callMethodIsReplyWith(false, $entities);

        $entities = new stdClass();
        $entities->user_mentions = [
            0 => new stdClass()
        ];
        $this->callMethodIsReplyWith(true, $entities);
    }

    private function callMethodIsReplyWith(bool $expected_output, stdClass $entities)
    {
        $factory = new TweetFactory();
        $factory->setEntities($entities);
        $tweet = $factory->createInstance();
        self::assertSame($expected_output, $tweet->isReply());
    }
}
