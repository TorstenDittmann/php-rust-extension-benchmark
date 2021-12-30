<?php

class App {
    protected array $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function matches(string $url): ?string
    {
        $url = \parse_url($url, PHP_URL_PATH);
        foreach ($this->routes as $route) {
            $regex = "@" . \preg_replace("@:[^/]+@", "([^/]+)", $route) . "@";

            if (!\preg_match($regex, $url)) {
                continue;
            }

            return $route;
        }
    }
}

$routes = include("./mock.php");

$app = new App($routes);

$appRust = new AppRust($routes);
$appRust->build();

execute("native", $app);
execute("rust", $appRust);

function execute($name, $app) {
    print("-------------------------\n");
    print("starting {$name}.\n");
    print("-------------------------\n");

    $data = [
        "/v1/account" => "/v1/account",
        "/v1/health" => "/v1/health",
        "/v1/avatars/credit-cards/:code" => "/v1/avatars/credit-cards/amex",
        "/v1/account/sessions/oauth2/callback/:provider/:projectId" => "/v1/account/sessions/oauth2/callback/github/appwrite",
        "/v1/database/collections/:collectionId/documents/:documentId" => "/v1/database/collections/projects/documents/test-document"
    ];
    $times = 0.0;
    for ($i=0; $i < 10; $i++) {
        print("run {$i}\n");
        $start = microtime(true);
        for ($y=0; $y < 100_000; $y++) { 
            foreach ($data as $pattern => $url) {
                if ($app->matches($url) !== $pattern) throw new Exception();
            }
        }
        $end = microtime(true);
        $times += $end-$start;
    }
    $result = $times / 10;
    print("-------------------------\n");
    print("{$name} took {$result} seconds in average per run.\n");
    print("-------------------------\n");
}