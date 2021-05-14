<?php

namespace Elsayed85\Notion\Internal;

use Elsayed85\Notion\ErrorException;
use Elsayed85\Notion\RateLimitException;
use Elsayed85\Notion\ValidationException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Notion
{
    private $token;
    private $base;
    private $notionVersion;

    public function __construct($token = null, $urlVersion = null, $notionVersion = null)
    {
        $urlVersion ??= 1;
        $this->token = $token ?? config('services.notion.token');
        $this->base = config('notion.base') . "/v{$urlVersion}/";
        $this->notionVersion = $notionVersion ?? config('notion.verision');
    }

    public function body($body)
    {
        return json_decode($body, true);
    }

    public function rateLimit(Response $response)
    {
        if ($response->status() == 429) {
            throw new RateLimitException("The rate limit for incoming requests is an average of 3 requests per second", 429);
        }
    }

    public function error(Response $response)
    {
        $body = $this->body($response->body());
        if ($body['object'] == "error") {
            if ($body['code'] == "validation_error") {
                throw new ValidationException($body['message'], $body['status']);
            }
            throw (new ErrorException($body['message'], $body['status']))->setExtraData($body);
        }
    }

    public function request($method = "get", $url = null, $data = [])
    {
        $parms = collect($data)->filter();

        $request =  Http::withToken($this->token)->withHeaders([
            'Notion-Version' => $this->notionVersion
        ])->{$method}($this->base  . $url, $parms->toArray());

        $this->rateLimit($request);
        $this->error($request);

        return $request;
    }

    public function databases(string $start_cursor = null, int $page_size  = 10)
    {
        $response = $this->request("get", "databases", ['start_cursor' => $start_cursor, 'page_size' => $page_size]);
        return $this->body($response->body());
    }

    public function database(string $id)
    {
        $response = $this->request("get", "databases/{$id}");
        return json_decode($response->body(), true);
    }

    public function queryDatabase(string $id, $filter = null, $sorts = null, string $start_cursor = null, int $page_size  = 10)
    {
        $response = $this->request("post", "databases/{$id}/query", [
            'filter' => $filter,
            'sorts' => $sorts,
            'start_cursor' => $start_cursor,
            'page_size' => $page_size
        ]);

        return $this->body($response->body());
    }

    public function createPage($parentId,  $type = "database_id", $properties, $children = [])
    {
        $type = ($type == "database_id") ? "database_id" : "page_id";
        $response = $this->request("post", "pages", ['parent' => [$type => $parentId], 'properties' => $properties, 'children' => $children]);
        return $this->body($response->body());
    }

    public function page($id)
    {
        $response = $this->request("get", "pages/{$id}");
        return $this->body($response->body());
    }

    public function updatePage($id, $properties)
    {
        $response = $this->request("get", "pages/{$id}");
        return $this->body($response->body());
    }

    public function users()
    {
        $response = $this->request("get", "users");
        return $this->body($response->body());
    }

    public function user($id)
    {
        $response = $this->request("get", "users/{$id}");
        return $this->body($response->body());
    }

    public function search($query = null, $sortBy = null, $sortDir = "ascending", string $start_cursor = null, int $page_size  = 10)
    {
        $sortDir = ($sortDir == "ascending") ? "ascending" : "descending";
        $sort = is_null($sortBy) ? null : ['direction' => $sortDir, 'timestamp' => $sortBy];
        $response = $this->request("post", "search", ['query' => $query, 'sort' => $sort, 'start_cursor' => $start_cursor, 'page_size' => $page_size]);
        return $this->body($response->body());
    }
}
