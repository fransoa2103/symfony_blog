<?php

/**
 * test for examinated content of comment
 */

namespace App\Tests;
use App\Entity\Comment;
use App\Service\VerifComment;
use PHPUnit\Framework\TestCase;

class VerifCommentPhpTest extends TestCase
{
    protected $comment;
    protected function setUp(): void
    {
        $this->comment = new Comment(); // Only one comment is instancied for all the tests below
    }

    public function testContentBadWord()
    {
        $service = new VerifComment();
        $this->comment->setContenu("ceci est un commentaire nul");
        $result = $service->authorizedComment($this->comment);
        $this->assertTrue($result);
    }

    public function testWithoutBadWord()
    {
        $service = new VerifComment();
        $this->comment->setContenu("ceci est un commentaire génial");
        $result = $service->authorizedComment($this->comment);
        $this->assertFalse($result);
    }
}
