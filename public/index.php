<?php
// If the profiler is enabled, set it up now:
$vufindProfiler = getenv('VUFIND_PROFILER_XHPROF');
if (!empty($vufindProfiler)) {
    if (extension_loaded('tideways_xhprof')) {
        tideways_xhprof_enable();

        // Handle final profiling details, if necessary:
        register_shutdown_function(function () use ($vufindProfiler) {
            $xhprofData = tideways_xhprof_disable();
            $xhprofRunId = uniqid();
            $suffix = 'vufind';
            $dir = ini_get('xhprof.output_dir');
            if (empty($dir)) {
                $dir = sys_get_temp_dir();
            }
            file_put_contents(
                "$dir/$xhprofRunId.$suffix.xhprof", serialize($xhprofData)
            );
            $url = "$vufindProfiler?run=$xhprofRunId&source=$suffix";
            echo "<a href='$url'>Profiler output</a>";
        });
    }
}

// Define path to application directory
defined('APPLICATION_PATH')
    || define(
        'APPLICATION_PATH',
        (getenv('VUFIND_APPLICATION_PATH') ? getenv('VUFIND_APPLICATION_PATH')
            : dirname(__DIR__))
    );

// Define application environment
defined('APPLICATION_ENV')
    || define(
        'APPLICATION_ENV',
        (getenv('VUFIND_ENV') ? getenv('VUFIND_ENV') : 'production')
    );

// Define default search backend identifier
defined('DEFAULT_SEARCH_BACKEND') || define('DEFAULT_SEARCH_BACKEND', 'Solr');

// Define path to local override directory
defined('LOCAL_OVERRIDE_DIR')
    || define(
        'LOCAL_OVERRIDE_DIR',
        (getenv('VUFIND_LOCAL_DIR') ? getenv('VUFIND_LOCAL_DIR') : '')
    );

// Define path to cache directory
defined('LOCAL_CACHE_DIR')
    || define(
        'LOCAL_CACHE_DIR',
        (getenv('VUFIND_CACHE_DIR')
            ? getenv('VUFIND_CACHE_DIR')
            : (strlen(LOCAL_OVERRIDE_DIR) > 0 ? LOCAL_OVERRIDE_DIR . '/cache' : ''))
    );

// Save original working directory in case we need to remember our context, then
// switch to the application directory for convenience:
define('ORIGINAL_WORKING_DIRECTORY', getcwd());
chdir(APPLICATION_PATH);

// Ensure vendor/ is on include_path; some PEAR components may not load correctly
// otherwise (i.e. File_MARC may cause a "Cannot redeclare class" error by pulling
// from the shared PEAR directory instead of the local copy):
$pathParts = [];
$pathParts[] = APPLICATION_PATH . '/vendor';
$pathParts[] = get_include_path();
set_include_path(implode(PATH_SEPARATOR, $pathParts));

// Composer autoloading
if (file_exists('vendor/autoload.php')) {
    $loader = include 'vendor/autoload.php';
}

if (!class_exists('Laminas\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load Laminas autoloader.');
}

// Run the application!
$app = Laminas\Mvc\Application::init(require 'config/application.config.php');
if (PHP_SAPI === 'cli') {
    return $app->getServiceManager()
        ->get(\VuFindConsole\ConsoleRunner::class)->run();
} else {
    $app->run();
}
