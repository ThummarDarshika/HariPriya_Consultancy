<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PrivacyPolicyController extends Controller
{
    private const ALLOWED_TAGS = ['p', 'div', 'h2', 'h3', 'blockquote', 'ul', 'ol', 'li', 'strong', 'em', 'u', 'br', 'span', 'a', 'b', 'i', 'font'];

    public function edit(Request $request): View
    {
        $savedBody = SiteContent::query()
            ->where('page', 'privacy-policy')
            ->where('key', 'privacy-policy/body')
            ->value('value');

        $bodyHtml = $request->old('body_html', $savedBody ?? view('pages.partials.privacy-policy-default')->render());

        return view('admin.privacy-policy.edit', [
            'bodyHtml' => $this->sanitizeHtml($bodyHtml),
            'hasSavedBody' => $savedBody !== null,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body_html' => ['required', 'string', 'max:100000'],
        ]);

        $bodyHtml = $this->sanitizeHtml($validated['body_html']);
        if (trim(html_entity_decode(strip_tags($bodyHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8')) === '') {
            throw ValidationException::withMessages(['body_html' => 'Add some Privacy Policy content before saving.']);
        }

        SiteContent::query()->updateOrCreate(
            ['page' => 'privacy-policy', 'key' => 'privacy-policy/body'],
            ['type' => 'html', 'value' => $bodyHtml],
        );

        return redirect()->route('admin.privacy-policy.edit')->with('status', 'Privacy Policy content saved and published.');
    }

    private function sanitizeHtml(string $html): string
    {
        $source = new DOMDocument('1.0', 'UTF-8');
        $previousErrorSetting = libxml_use_internal_errors(true);

        try {
            $loaded = $source->loadHTML('<?xml encoding="UTF-8"?><div id="privacy-policy-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previousErrorSetting);
        }

        if (! $loaded) {
            return '';
        }

        $sourceRoot = $source->getElementsByTagName('div')->item(0);
        if (! $sourceRoot) {
            return '';
        }

        $clean = new DOMDocument('1.0', 'UTF-8');
        $cleanRoot = $clean->createElement('div');
        $clean->appendChild($cleanRoot);

        foreach ($sourceRoot->childNodes as $node) {
            $this->appendSafeNode($node, $cleanRoot, $clean);
        }

        $result = '';
        foreach ($cleanRoot->childNodes as $node) {
            $result .= $clean->saveHTML($node);
        }

        return $result;
    }

    private function appendSafeNode(DOMNode $node, DOMNode $parent, DOMDocument $document): void
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $parent->appendChild($document->createTextNode($node->nodeValue ?? ''));

            return;
        }

        if (! $node instanceof DOMElement) {
            return;
        }

        $tag = strtolower($node->tagName);
        if (in_array($tag, ['script', 'style', 'iframe', 'object', 'svg', 'math', 'form', 'input', 'img', 'video'], true)) {
            return;
        }

        if (! in_array($tag, self::ALLOWED_TAGS, true)) {
            foreach ($node->childNodes as $child) {
                $this->appendSafeNode($child, $parent, $document);
            }

            return;
        }

        $safeTag = match ($tag) {
            'b' => 'strong',
            'i' => 'em',
            'font' => 'span',
            default => $tag,
        };
        $safeElement = $document->createElement($safeTag);

        if ($tag === 'font') {
            $fontSizes = [1 => 12, 2 => 14, 3 => 16, 4 => 18, 5 => 24, 6 => 30, 7 => 36];
            $fontSize = $fontSizes[(int) $node->getAttribute('size')] ?? null;
            if ($fontSize !== null) {
                $safeElement->setAttribute('style', 'font-size: '.$fontSize.'px');
            }
        } elseif ($tag === 'span' && preg_match('/(?:^|;)\s*font-size\s*:\s*(\d{1,2})px\s*(?:;|$)/i', $node->getAttribute('style'), $matches)) {
            $fontSize = (int) $matches[1];
            if ($fontSize >= 12 && $fontSize <= 36) {
                $safeElement->setAttribute('style', 'font-size: '.$fontSize.'px');
            }
        } elseif ($tag === 'a') {
            $href = trim($node->getAttribute('href'));
            if (preg_match('~^(?:https?://[^\s]+|mailto:[^\s]+|tel:[+0-9() .-]+|/(?!/)[^\s]*|\#[^\s]*)$~i', $href)) {
                $safeElement->setAttribute('href', $href);
            }
        }

        foreach ($node->childNodes as $child) {
            $this->appendSafeNode($child, $safeElement, $document);
        }

        $parent->appendChild($safeElement);
    }
}
