#!/usr/local/bin/php -q
<?php
if (file_exists(dirname(__FILE__).'/../config.inc.php')) {
    include_once dirname(__FILE__).'/../config.inc.php';
} else {
    include_once dirname(__FILE__).'/../config.sample.php';
}

error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);
ini_set('memory_limit', 1024*1024*64);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

iconv_set_encoding("internal_encoding", "UTF-8");
iconv_set_encoding("output_encoding", "UTF-8");

$ports = range(13200, 13210);

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false) {
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    exit();
}

foreach ($ports as $port) {
    $result = @socket_bind($sock, 0, $port);
    if ($result === false) {
        continue;
    }
    break;
}

if ($result === false) {
    echo 'No open ports'.PHP_EOL;
    exit();
}

echo 'Listening on '.$port.PHP_EOL;

if (socket_listen($sock, 5) === false) {
    echo "socket_listen() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
    exit();
}

$outputcontroller = new Savvy();
$outputcontroller->setClassToTemplateMapper(new UNL_UndergraduateBulletin_ClassToTemplateMapper());
$outputcontroller->setEscape('htmlentities');

$search_service = new UNL_Services_CourseApproval_Search();

do {
    if (($msgsock = socket_accept($sock)) === false) {
        echo "socket_accept() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
        break;
    }

    if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
        echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
        break 2;
    }
    if (!$buf = trim($buf)) {
        continue;
    }
    if ($buf == 'quit') {
        break;
    }
    if ($buf == 'shutdown') {
        socket_close($msgsock);
        break 2;
    }

    $options = json_decode($buf, true);

    if (!is_array($options)) {
        socket_close($msgsock);
    }

    $search = new UNL_UndergraduateBulletin_CourseSearch($options);

    $search->results = $search_service->byAny($search->options['q'],
                                              $search->options['offset'],
                                              $search->options['limit']
                                      );

    $outputcontroller->setTemplatePath(dirname(dirname(__FILE__)).'/www/templates/html');
    switch($options['format']) {
        case 'xml':
            $outputcontroller->addTemplatePath(dirname(dirname(__FILE__)).'/www/templates/xml');
            break;
        case 'json':
            $outputcontroller->addTemplatePath(dirname(dirname(__FILE__)).'/www/templates/json');
            break;
    }
    $output = $outputcontroller->render($search);

    socket_write($msgsock, $output, strlen($output));
    socket_close($msgsock);
    unset($search, $output, $options);
    echo "$buf\n";
    echo memory_get_usage(true).PHP_EOL;
} while (true);

socket_close($sock);
