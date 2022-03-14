<?php

namespace App\Service;
use App\Entity\Comment;

/**
 * added a service to control text content of the comment article
 * if comment get an insult or any bad words then the comment is not validated
 */

class VerifComment
{
    public function authorizedComment(Comment $comment)
    {
        $insultes = ["nul", "salaud", "fuck"];
        foreach($insultes as $insulte)
        {
           if(strpos($comment->getContenu(), $insulte))
           {
               return true;
           }
        }
        return false;
    }
}