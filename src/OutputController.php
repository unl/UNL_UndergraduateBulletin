<?php

namespace UNL\UndergraduateBulletin;

class OutputController extends \Savvy
{
    protected static $cache;

    public static $defaultExpireTimestamp = null;

    protected $formats = [
        'partial',
        'collegesource',
        'html',
        'csv',
        'json',
        'print',
        'xml',
    ];

    public static function setCacheInterface(CachingService\CachingServiceInterface $cache)
    {
        static::$cache = $cache;
    }

    /**
     * get the cache interface
     * @return CachingService\CachingServiceInterface
     */
    public static function getCacheInterface()
    {
        if (!isset(static::$cache)) {
            static::setCacheInterface(new CachingService\UNLCacheLite());
        }
        return static::$cache;
    }

    public static function setDefaultExpireTimestamp($timestamp)
    {
        self::$defaultExpireTimestamp = $timestamp;
    }

    public static function getDefaultExpireTimestamp()
    {
        return static::$defaultExpireTimestamp;
    }

    public function __construct($config = null)
    {
        parent::__construct();
        $this->setClassToTemplateMapper(new ClassToTemplateMapper());
    }

    public function setupFromController(Controller $controller, $withHeaders = true)
    {
        $controller->setOutputController($this);
        $templatesPath = dirname(__DIR__) . '/www/templates/';
        $defaultFormat = 'html';
        $expire = static::getDefaultExpireTimestamp();

        $this->addGlobal('controller', $controller);

        if (isset($controller->options['redirectToSelf']) && $controller->options['redirectToSelf'] === true && !$withHeaders) {
            unset($controller->options['redirectToSelf']);
        }

        $format = $controller->options['format'];

        if (!$this->isSupportedFormat($format)) {
            $format = $defaultFormat;
            $controller->outputException(new \Exception('Invalid output format requested', 404));
        }

        $formatStack = [$format];
        $alternateTemplateStack = [];

        switch ($format) {
            case 'xml':
                if ($withHeaders) {
                    header('Content-type: text/xml');
                }
                $this->setEscape('htmlspecialchars');
                break;
            case 'json':
                if ($withHeaders) {
                    header('Content-type: application/json');
                }
                break;
            case 'collegesource':
                //CollegeSource is also csv, but they require specific data... so they have a special template.
                array_unshift($formatStack, 'csv');

                if (!isset($controller->options['delimiter'])) {
                    $controller->options['delimiter'] = "|";
                }
                // no break
            case 'csv':
                if ($withHeaders) {
                    header('Content-type: text/plain; charset=UTF-8');
                }

                if (!isset($controller->options['delimiter'])) {
                    $controller->options['delimiter'] = ",";
                }

                $delimiter = $controller->options['delimiter'];
                $this->addGlobal('delimiter', $delimiter);

                $out = fopen('php://output', 'w');
                $this->addGlobal('delimitArray', function ($array) use ($delimiter, $out) {
                    fputcsv($out, $array, $delimiter);
                });
                break;
            case 'partial':
                ClassToTemplateMapper::$output_template[Controller::class] = 'Controller-partial';
                ClassToTemplateMapper::$output_template[CatalogController::class] = 'Controller-partial';
                // no break
            default:
                if ($defaultFormat !== $format) {
                    array_unshift($formatStack, $defaultFormat);
                }
                $alternateTemplateStack[] = $controller->getEdition()->getDataDir() . '/templates/html';
                $this->setEscape('htmlentities');
                $expire = strtotime('tomorrow');
                break;
        }

        foreach ($formatStack as $format) {
            $this->addTemplatePath($templatesPath . $format);
        }

        foreach ($alternateTemplateStack as $templatePath) {
            $this->addTemplatePath($templatePath);
        }

        static::setDefaultExpireTimestamp($expire);
    }

    protected function isSupportedFormat($format)
    {
        return in_array($format, $this->formats);
    }

    protected function getCacheKey(CachingService\CacheableInterface $object)
    {
        $key = $object->getCacheKey();

        if ($key === false) {
            return false;
        }

        $key .= Controller::getEdition()->getCacheKey();

        return $key;
    }

    protected function loadCache($object)
    {
        $cacheObject = $this->getRawObject($object);

        if (!($cacheObject instanceof CachingService\CacheableInterface)) {
            return false;
        }

        $key = $this->getCacheKey($cacheObject);
        if ($key === false) {
            return false;
        }

        $data = static::getCacheInterface()->get($key);

        if ($data !== false) {
            $cacheObject->preRun(true, $this);
        } else {
            $cacheObject->preRun(false, $this);
            $cacheObject->run();
        }

        return $data;
    }

    protected function saveCache($object, $data)
    {
        $cacheObject = $this->getRawObject($object);

        if (!($cacheObject instanceof CachingService\CacheableInterface)) {
            return;
        }

        $key = $this->getCacheKey($cacheObject);
        if ($key === false) {
            return;
        }

        static::getCacheInterface()->save($data, $key);
    }

    public function renderObject($object, $template = null)
    {
        $rawObject = $this->getRawObject($object);
        $data = $this->loadCache($object);

        if ($data === false) {
            $data = parent::renderObject($object, $template);
            $this->saveCache($object, $data);
        }

        return $data;
    }

    public function renderJsonObject($object)
    {
        $rawObject = $this->getRawObject($object);

        if (!$rawObject instanceof \JsonSerializable) {
            return $this->renderObject($object);
        }

        $data = $this->loadCache($object);

        if ($data === false) {
            $data = json_encode($object);
            $this->saveCache($object, $data);
        }

        return $data;
    }

    /**
     *
     * @param timestamp $expires timestamp
     *
     * @return void
     */
    public function sendCORSHeaders($expires = null)
    {
        if (!$expires) {
            $expires = static::getDefaultExpireTimestamp();
        }

        // Specify domains from which requests are allowed
        header('Access-Control-Allow-Origin: *');

        // Specify which request methods are allowed
        header('Access-Control-Allow-Methods: GET, OPTIONS');

        // Additional headers which may be sent along with the CORS request
        // The X-Requested-With header allows jQuery requests to go through
        header('Access-Control-Allow-Headers: X-Requested-With');

        // Set the ages for the access-control header to 20 days to improve speed/caching.
        header('Access-Control-Max-Age: 1728000');

        if ($expires) {
            // Set expires header for 24 hours to improve speed caching.
            header('Expires: '.date('r', $expires));
        }
    }
}
