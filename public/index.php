<?php
require __DIR__ . '/../vendor/autoload.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use \LINE\LINEBot\SignatureValidator as SignatureValidator;

$pass_signature = false;

// set LINE channel_access_token and channel_secret
$channel_access_token = "1bFxcTOps4p3/DGT1acGIfZ9aXvcurQwnOE4g3U/BkkgwuJoGMnlzOPeuAc3lt75ugMup6wae6eX3J05xtGTru4gBl2fNPGMyJiblsoavgbN2z0RmD9JVvme5qYZbT0NYRSlFFjqMdy7iUbsO4FHiAdB04t89/1O/w1cDnyilFU=";
$channel_secret = "a4558c25c1af29bef2decd7183d08032";

// inisiasi objek bot
$httpClient = new CurlHTTPClient($channel_access_token);
$bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);

$app = AppFactory::create();
$app->setBasePath("/public");

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Welcome, Deflix!");
    return $response;
});

// buat route untuk webhook
$app->post('/webhook', function (Request $request, Response $response) use ($channel_secret, $bot, $httpClient, $pass_signature) {
    // get request body and line signature header
    $body = $request->getBody();
    $signature = $request->getHeaderLine('HTTP_X_LINE_SIGNATURE');

    // log body and signature
    file_put_contents('php://stderr', 'Body: ' . $body);

    if ($pass_signature === false) {
        // is LINE_SIGNATURE exists in request header?
        if (empty($signature)) {
            return $response->withStatus(400, 'Signature not set');
        }

        // is this request comes from LINE?
        if (!SignatureValidator::validateSignature($body, $channel_secret, $signature)) {
            return $response->withStatus(400, 'Invalid signature');
        }
    }

    $data = json_decode($body, true);
    if(is_array($data['events'])) 
	{
        foreach($data['events'] as $event) 
		{
            if($event['type'] == 'message') 
			{
                //reply message
                if($event['message']['type'] == 'text') 
				{
                    if(strtolower($event['message']['text']) == '/help') 
					{
                        $flexTemplate = file_get_contents("../help_deflix.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Help Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					elseif(strtolower($event['message']['text']) == '/list film') 
					{
                        $flexTemplate = file_get_contents("../list_film.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'List Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    } 
					elseif(strtolower($event['message']['text']) == '/pesan-film-1') 
					{
                        $flexTemplate = file_get_contents("../nota_film_1.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Pesan Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    } 
					elseif(strtolower($event['message']['text']) == '/pesan-film-2') 
					{
                        $flexTemplate = file_get_contents("../nota_film_2.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Pesan Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					elseif(strtolower($event['message']['text']) == '/pesan-film-3') 
					{
                        $flexTemplate = file_get_contents("../nota_film_3.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Pesan Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					elseif(strtolower($event['message']['text']) == '/tiket-film-1') 
					{
                        $flexTemplate = file_get_contents("../tiket_film_1.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Tiket Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					elseif(strtolower($event['message']['text']) == '/tiket-film-2') 
					{
                        $flexTemplate = file_get_contents("../tiket_film_2.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Tiket Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					elseif(strtolower($event['message']['text']) == '/tiket-film-3') 
					{
                        $flexTemplate = file_get_contents("../tiket_film_3.json");
                        $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                            'replyToken' => $event['replyToken'],
                            'messages'   => [
                                [
                                    'type'     => 'flex',
                                    'altText'  => 'Tiket Film Deflix',
                                    'contents' => json_decode($flexTemplate)
                                ]
                            ],
                        ]);
                    }
					else 
					{
						$textMessageBuilder = new TextMessageBuilder('Maaf, perintah tidak dikenal. Silahkan gunakan perintah `/help` untuk mengetahui perintah yang dapat digunakan.');
						$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);
                    }

                    $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->getHTTPStatus());
                }
                elseif (
                    $event['message']['type'] == 'image' or
                    $event['message']['type'] == 'video' or
                    $event['message']['type'] == 'audio' or
                    $event['message']['type'] == 'file'
                ) {
					$textMessageBuilder = new TextMessageBuilder('Maaf, perintah tidak dikenal. Silahkan gunakan perintah `/help` untuk mengetahui perintah yang dapat digunakan.');
					$result = $bot->replyMessage($event['replyToken'], $textMessageBuilder);

                    $response->getBody()->write(json_encode($result->getJSONDecodedBody()));
                    return $response
                        ->withHeader('Content-Type', 'application/json')
                        ->withStatus($result->getHTTPStatus());
                }
            }
        }
    }
    return $response->withStatus(400, 'No event sent!');
});

$app->run();




