<?php

$routes = [
    "/v1/mock/tests/foo",
    "/v1/mock/tests/bar",
    "/v1/mock/tests/lorem",
    "/v1/mock/tests/ipsum",
    "/v1/database/collections/:collectionId/documents/:documentId",
    "/v1/database/collections/:collectionId/documents",
    "/v1/database/collections/:collectionId",
    "/v1/database/collections",
    "/v1/avatars/credit-cards/:code",
    "/v1/avatars/browsers/:code",
    "/v1/mock/tests/general/download",
    "/v1/account/sessions/oauth2/callback/:provider/:projectId",
    "/v1/account/sessions/oauth2/:provider/redirect",
    "/v1/account/sessions/oauth2/:provider",
    "/v1/account/sessions/:sessionId",
    "/v1/account/sessions/anonymous",
    "/v1/account/sessions/magic-url",
    "/v1/account/sessions",
    "/v1/account/email",
    "/v1/account/jwt",
    "/v1/account/prefs",
    "/v1/account",
    "/v1/mock/tests/general/upload",
    "/v1/mock/tests/general/redirect",
    "/v1/mock/tests/general/redirect/done",
    "/v1/mock/tests/general/set-cookie",
    "/v1/mock/tests/general/get-cookie",
    "/v1/mock/tests/general/empty",
    "/v1/mock/tests/general/400-error",
    "/v1/mock/tests/general/500-error",
    "/v1/mock/tests/general/502-error",
    "/v1/mock/tests/general/oauth2",
    "/v1/mock/tests/general/oauth2/token",
    "/v1/mock/tests/general/oauth2/user",
    "/v1/mock/tests/general/oauth2/success",
    "/v1/mock/tests/general/oauth2/failure",
    "/v1/health",
    "/v1/health/version",
    "/v1/health/db",
    "/v1/health/cache",
    "/v1/health/time",
    "/v1/health/queue/webhooks",
    "/v1/health/queue/tasks",
    "/v1/health/queue/logs",
    "/v1/health/queue/usage",
    "/v1/health/queue/certificates"
];

\uksort($routes, fn ($a, $b) => \strlen($b) - \strlen($a));

\uksort($routes, function (string $a, string $b) {
    $result = \count(\explode('/', $b)) - \count(\explode('/', $a));

    if ($result === 0) {
        return \substr_count($a, ':') - \substr_count($b, ':');
    }

    return $result;
});

return $routes;
