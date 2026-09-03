<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $static = [
            '/',
            '/about-us',
            '/pricing',
            '/workshops',
            '/faqs',
            '/blog',
            '/contact-us',
            '/impressum',
            '/datenschutz',
            '/agb',
            '/legal-disclaimer',
        ];

        $blogs = Blog::published()->latest('updated_at')->get(['slug', 'updated_at']);

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($static as $path) {
            $xml .= $this->urlTag(url($path), now(), $path === '/' ? '1.00' : '0.80');
        }

        foreach ($blogs as $blog) {
            $xml .= $this->urlTag(url('/blog/' . $blog->slug), $blog->updated_at, '0.64');
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    private function urlTag(string $loc, $lastmod, string $priority): string
    {
        $date = $lastmod instanceof \DateTimeInterface
            ? $lastmod->format('Y-m-d')
            : now()->format('Y-m-d');

        return "  <url>\n"
            . "    <loc>{$loc}</loc>\n"
            . "    <lastmod>{$date}</lastmod>\n"
            . "    <priority>{$priority}</priority>\n"
            . "  </url>\n";
    }
}
