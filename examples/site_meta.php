<?php
/**
 * Site Metadata Provider
 * 
 * Provides metadata configuration and a utility method to generate
 * a short, human-readable description of the site.
 */

class SiteMetaProvider
{
    /**
     * @var array<string, mixed>
     */
    private array $metadata;

    /**
     * @param array<string, mixed> $customMeta Optional custom metadata to merge.
     */
    public function __construct(array $customMeta = [])
    {
        $this->metadata = array_merge($this->getDefaultMeta(), $customMeta);
    }

    /**
     * Returns the default metadata for the site.
     *
     * @return array<string, mixed>
     */
    private function getDefaultMeta(): array
    {
        return [
            'site_name'        => '爱游戏',
            'site_url'         => 'https://m-app-aiyouxi.com.cn',
            'description'      => '爱游戏官方平台，提供丰富游戏资讯与互动服务。',
            'keywords'         => ['爱游戏', '游戏推荐', '手游', '休闲益智', '社交游戏'],
            'language'         => 'zh-CN',
            'charset'          => 'UTF-8',
            'author'           => '爱游戏团队',
            'revision'         => '1.0.0',
            'generator'        => 'SiteMetaProvider',
            'last_updated'     => '2024-08-15',
            'enable_rss'       => true,
            'enable_sitemap'   => true,
        ];
    }

    /**
     * Retrieves the full metadata array.
     *
     * @return array<string, mixed>
     */
    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /**
     * Returns a single metadata value by key.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key): mixed
    {
        return $this->metadata[$key] ?? null;
    }

    /**
     * Generates a short description text from the metadata.
     *
     * @param int $maxLength Maximum length of the description.
     * @return string
     */
    public function generateDescription(int $maxLength = 120): string
    {
        $siteName    = $this->metadata['site_name'] ?? 'Site';
        $description = $this->metadata['description'] ?? '';
        $keywords    = $this->metadata['keywords'] ?? [];

        // Build a concise tagline
        $tagline = sprintf('%s - %s', $siteName, $description);

        // Append up to 3 keywords if they fit
        if (!empty($keywords)) {
            $keywordPart = implode(', ', array_slice($keywords, 0, 3));
            if (mb_strlen($tagline . ' | ' . $keywordPart) <= $maxLength) {
                $tagline .= ' | ' . $keywordPart;
            }
        }

        // Truncate to maxLength, preserving whole words
        if (mb_strlen($tagline) > $maxLength) {
            $tagline = mb_strimwidth($tagline, 0, $maxLength - 3, '...');
        }

        return htmlspecialchars($tagline, ENT_QUOTES | ENT_HTML5, $this->metadata['charset'] ?? 'UTF-8');
    }

    /**
     * Returns an HTML meta tag string for the site description.
     *
     * @return string
     */
    public function toMetaTag(): string
    {
        $description = $this->generateDescription(160);
        return sprintf(
            '<meta name="description" content="%s" />',
            $description
        );
    }

    /**
     * Returns the site's base URL.
     *
     * @return string
     */
    public function getSiteUrl(): string
    {
        return $this->metadata['site_url'] ?? '';
    }

    /**
     * Returns the site name.
     *
     * @return string
     */
    public function getSiteName(): string
    {
        return $this->metadata['site_name'] ?? '';
    }
}

// ---------------------------------------------------------------------------
// Example usage (uncomment to test)
// ---------------------------------------------------------------------------

/*
$provider = new SiteMetaProvider();

// Retrieve full metadata array
print_r($provider->getMetadata());

// Generate a short description
echo $provider->generateDescription(100) . "\n";

// Output as HTML meta tag
echo $provider->toMetaTag() . "\n";

// Access specific values
echo $provider->getSiteUrl() . "\n";
echo $provider->getSiteName() . "\n";
*/

// Enable default execution
$provider = new SiteMetaProvider();
echo $provider->generateDescription(120) . "\n";
echo $provider->toMetaTag() . "\n";