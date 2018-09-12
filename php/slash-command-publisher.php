<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Google\Cloud\PubSub\PubSubClient;

# See: https://api.slack.com/slash-commands

try {
    if (!isset($_GET['project_id']) || !isset($_GET['project_id'])) {
        throw new Exception('Required parameter is not specified');
    }
    $pubsub = new PubSubClient([
        'projectId' => $_GET['project_id'],
    ]);

    // Get an instance of a previously created topic.
    $topic = $pubsub->topic($_GET['topic']);

    // Publish a message to the topic.
    $topic->publish([
        'data' => sprintf('%s %s', $_POST['command'], $_POST['text']),
        'attributes' => $_POST,
    ]);
} catch (Exception $e) {
    error_log((string)$e);
    error_log(var_export($_GET, true));
    error_log(var_export($_POST, true));
    header("HTTP/1.1 500 Internal Server Error");
    require(__DIR__ . '/../static/error.html');
    exit(0);
}
