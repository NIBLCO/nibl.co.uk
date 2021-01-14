<?php

use App\Action\ShowBotAction;
use App\Action\ShowBotsAction;
use App\Action\ShowFaqAction;
use App\Action\ShowIndexAction;
use App\Action\ShowInfoAction;
use App\Action\ShowSearchAction;
use Slim\App;

return static function (App $app) {
    $app->get('/', ShowIndexAction::class)->setName('index');
    $app->get('/bots', ShowBotsAction::class)->setName('bots');
    $app->get('/bots/{name}', ShowBotAction::class)->setName('bot');
    $app->get('/about', ShowInfoAction::class)->setName('about');
    $app->get('/faq', ShowFaqAction::class)->setName('faq');
    $app->get('/search', ShowSearchAction::class)->setName('search');
};
