<?php

function setActive($url)
{
    return Request::url() == $url ? 'active' : '';
}
