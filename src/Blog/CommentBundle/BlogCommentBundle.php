<?php

namespace Blog\CommentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlogCommentBundle extends Bundle
{
    public function getParent() {
        return 'FOSCommentBundle';
    }
}
