<?php

class ChainableRetriever implements JsonSchema\Uri\Retrievers\UriRetrieverInterface
{
    public function __construct($first, $second)
    {
        $this->first  = $first;
        $this->second = $second;
    }

    /**
     * Retrieve a schema from the specified URI
     * @param string $uri URI that resolves to a JSON schema
     * @throws \JsonSchema\Exception\ResourceNotFoundException
     * @return mixed string|null
     */
    public function retrieve($uri)
    {
            try {
                return $this->first->retrieve($uri);
            } catch  (JsonSchema\Exception\ResourceNotFoundException $e) {
                //
            }

            return $this->second->retrieve($uri);
    }

    /**
     * Get media content type
     * @return string
     */
    public function getContentType()
    {
        return 'application/schema+json';
    }
}
