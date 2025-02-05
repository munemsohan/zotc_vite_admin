<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use SimpleXMLElement;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        // Get the uploaded folder path from settings
        $uploadedFolder = get_zotc_setting('img_slug');
        $sitemapFolderPath = public_path('uploads/' . $uploadedFolder . '/sitemaps');

        // Define the path to the sitemap links file
        $sitemapLinksFile = $sitemapFolderPath . '/sitemap-links.txt';

        // Check if the sitemap links file exists
        if (file_exists($sitemapLinksFile)) {
            // Read the content of the sitemap links file
            $sitemapLinks = file_get_contents($sitemapLinksFile);

            // Split the contents into an array and filter out empty lines
            $sitemapLinks = explode("\n", $sitemapLinks);
            $sitemapLinks = array_filter($sitemapLinks, function ($link) {
                return !empty($link);
            });

            // Clean up the links by removing 'admin/' if present
            $sitemapLinks = array_map(function ($link) {
                return str_replace('admin/', '', $link);
            }, $sitemapLinks);
        } else {
            $sitemapLinks = [];
        }

        // Return the view with the sitemap links
        return view('backend.sitemap.index', compact('sitemapLinks'));
    }

    public function generate_sitemaps()
    {
        $this->generateStaticSitemaps();

        $productXMLs = $this->generateProductSitemap();

        $uploadedFolder = get_zotc_setting('img_slug');

        // Define the folder for the sitemap index and individual sitemaps
        $sitemapFolderPath = public_path('uploads/' . $uploadedFolder . '/sitemaps');
        $this->createFolderIfNotExists($sitemapFolderPath);

        // Define the sitemap index file path
        $sitemapIndexPath = $sitemapFolderPath . '/sitemap.xml';

        // Create the XML structure for the sitemap index
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></sitemapindex>');

        // Define the static sitemap
        $sitemaps = ['sitemap-static.xml'];

        // Push the product sitemaps to the array
        $sitemaps = array_merge($sitemaps, $productXMLs);

        // Add each sitemap to the index
        foreach ($sitemaps as $sitemap) {
            $sitemapNode = $xml->addChild('sitemap');
            $sitemapNode->addChild('loc', str_replace('admin/', '', url('sitemap/' . $sitemap)));
        }

        // Try saving the sitemap index XML to the file and add error handling
        if (!$xml->asXML($sitemapIndexPath)) {
            // If it fails, return an error message
            return response()->json(['error' => 'Failed to write sitemap index file.'], 500);
        }

        // Push the sitemap index to the first of the array
        array_unshift($sitemaps, 'sitemap.xml');

        // Save the generated sitemap links to a text file in the sitemap folder
        $sitemapLinks = array_map(function ($sitemap) use ($uploadedFolder) {
            return str_replace('admin/', '', url('sitemap/' . $sitemap));
        }, $sitemaps);

        $sitemapLinks = implode("\n", $sitemapLinks);
        file_put_contents($sitemapFolderPath . '/sitemap-links.txt', $sitemapLinks);

        // Ensure success message is displayed
        flash(translate('Sitemap Generated Successfully'))->success();

        return back();

        // return response()->json([
        //     'message' => 'Sitemap index generated successfully.',
        //     'sitemap_index_path' => $sitemapIndexPath,
        // ]);
    }


    public function generateStaticSitemaps()
    {
        $uploadedFolder = get_zotc_setting('img_slug');

        // Ensure the uploaded folder is set
        if (!$uploadedFolder) {
            return response()->json(['error' => 'Uploaded folder path is not set.'], 400);
        }

        // Define the folder path for the static sitemap
        $sitemapFolderPath = public_path('uploads/' . $uploadedFolder . '/sitemaps');
        $this->createFolderIfNotExists($sitemapFolderPath);

        // Define the path for the static sitemap
        $staticFilePath = $sitemapFolderPath . '/sitemap-static.xml';
        $baseUrl = preg_replace('/\/?admin\/?/', '', url('/'));

        // Create the XML structure for the static sitemap
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9"></urlset>');

        // Add base URL and menu/links
        $this->addUrl($xml, $baseUrl, 'always');
        $this->addMenuLinks($xml, $baseUrl);
        $this->addFooterLinks($xml, $baseUrl);
        $this->addCategories($xml, $baseUrl);

        // Save static sitemap XML
        $xml->asXML($staticFilePath);

        return response()->json([
            'message' => 'Static sitemap generated successfully.',
            'static_sitemap_path' => $staticFilePath,
        ]);
    }

    private function createFolderIfNotExists($path)
    {
        if (!is_dir($path)) {
            if (!mkdir($path, 0755, true)) {
                return response()->json(['error' => 'Failed to create the folders.'], 500);
            }
        }
    }

    private function addUrl(SimpleXMLElement $xml, $loc, $changefreq)
    {
        $url = $xml->addChild('url');
        $url->addChild('loc', $loc);
        $url->addChild('changefreq', $changefreq);
    }

    private function addMenuLinks(SimpleXMLElement $xml, $baseUrl)
    {
        $menuLinks = json_decode(get_business_setting('header_menu_links'), true);
        if ($menuLinks) {
            foreach ($menuLinks as $link) {
                $this->addUrl($xml, $baseUrl . $link, 'daily');
            }
        }
    }

    private function addFooterLinks(SimpleXMLElement $xml, $baseUrl)
    {
        $footerLinks = [
            '/login',
            '/page/terms',
            '/page/return-policy',
            '/page/about',
            '/page/contact'
        ];

        foreach ($footerLinks as $link) {
            $this->addUrl($xml, $baseUrl . $link, 'daily');
        }
    }

    private function addCategories(SimpleXMLElement $xml, $baseUrl)
    {
        $categories = Category::get();
        foreach ($categories as $category) {
            $this->addUrl($xml, $baseUrl . '/category/' . $category->slug, 'daily');
        }
    }

    public function generateProductSitemap()
    {
        $uploadedFolder = get_zotc_setting('img_slug');
        $products = Product::all(); // Fetch all products
        $chunkSize = 200;
        $chunkedProducts = array_chunk($products->toArray(), $chunkSize);
        $sitemapFolderPath = public_path('uploads/' . $uploadedFolder . '/sitemaps');
        $this->createFolderIfNotExists($sitemapFolderPath);

        $generatedSitemaps = [];

        // Iterate over product chunks to generate product sitemaps
        foreach ($chunkedProducts as $index => $productChunk) {
            $productXmlName = "products" . ($index + 1) . ".xml";
            $sitemapFilePath = $sitemapFolderPath . '/' . $productXmlName;

            // Create the XML structure for the product sitemap
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"></urlset>');

            // Add product URLs and images to the XML
            foreach ($productChunk as $product) {
                $url = $xml->addChild('url');
                $url->addChild('loc', url('product/' . $product['slug']));

                // Add image data
                $this->addProductImages($xml, $product);

                // Add product name as caption and lastmod
                $productName = htmlspecialchars($product['name'], ENT_XML1, 'UTF-8');
                $image = $xml->addChild('image:caption', '<![CDATA[' . $productName . ']]>');
                $url->addChild('changefreq', 'daily');
                $url->addChild('lastmod', Carbon::parse($product['created_at'])->format('Y-m-d\TH:i:s.u\Z'));
            }

            // Save the product sitemap XML
            $xml->asXML($sitemapFilePath);
            $generatedSitemaps[] = $productXmlName;
        }

        return $generatedSitemaps;
    }

    private function addProductImages(SimpleXMLElement $xml, $product)
    {
        if (!empty($product['photos'])) {
            $photos = explode(',', $product['photos']);
            $image = $xml->addChild('image:image');
            $imageUrl = !empty($photos[0]) ? uploaded_asset($photos[0]) : static_asset('assets/img/placeholderx200.webp');
            $image->addChild('image:loc', $imageUrl);
        }
    }
}
