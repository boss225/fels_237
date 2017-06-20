<?php

function setActive($url)
{
    return Request::url() == $url ? 'active' : '';
}

function setAnswer($answer, $check)
{
    return $answer == $check ? 'class=answer' : '';
}

function setChecked($answer, $check)
{
    return $answer == $check ? 'checked=checked' : '';
}
