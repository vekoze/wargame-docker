<?php

// Inefficient way to sanitize a comment.
// bypass: <scr<script>ipt>alealertrt("coucou");</scr</script>ipt>
function sanitize_review_comment($comment)
{
    $blacklist = [
        "<script>", "</script>",
        "alert", "onload", "onerror", "onmouseover",
        "src", "href", "img", "svg", "iframe",
        "javascript:"
    ];

    foreach ($blacklist as $word)
    {
        $comment = str_replace($word, "", $comment);
    }

    return $comment;
}

function encode_user_id($user_id)
{
    return base64_encode("flag{b4se64_is_a_s3cure_enc0ding__r1ght?}" . $user_id);
}

function decode_user_id($encoded_user_id)
{
    $decoded = base64_decode($encoded_user_id);
    return str_replace("flag{b4se64_is_a_s3cure_enc0ding__r1ght?}", "", $decoded);
}

?>