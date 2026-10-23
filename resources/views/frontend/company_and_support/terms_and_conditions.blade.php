@extends('layouts.frontend-default-layout')
@section('title', 'Terms and Conditions')

@section('content')
    <div class="container py-5">
        <header class="mb-5">
            <p class="text-primary fw-semibold text-uppercase small mb-2">Site information</p>
            <h1 class="display-5 fw-bold">Terms and Conditions</h1>
            <p class="text-body-secondary">Last updated: 23 October 2026</p>
            <p class="lead text-body-secondary col-lg-9">
                These terms explain the basic rules for using {{ config('app.name') }}. By accessing the site,
                you agree to follow them. If you do not agree, please stop using the site.
            </p>
        </header>

        <article class="bg-white rounded-3 shadow-sm p-4 p-lg-5">
            <section class="mb-4">
                <h2 class="h4 fw-bold">Using the site</h2>
                <p>You may browse and use the site for lawful purposes. Do not attempt to disrupt the service, access accounts or data that are not yours, upload harmful code, or use the site in a way that violates another person’s rights.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Accounts</h2>
                <p>Keep your sign-in details private and provide accurate account information. You are responsible for activity carried out through your account. Contact the site team if you believe someone else has accessed it.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Articles and other contributions</h2>
                <p>You remain responsible for content you submit, including articles, comments, and images. Only submit material you have the right to use. Do not submit unlawful, misleading, abusive, or privacy-invasive material.</p>
                <p>When you submit content, you allow {{ config('app.name') }} to store, display, and distribute it as needed to operate the publishing service. You should not submit confidential information in a public post or comment.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Moderation and availability</h2>
                <p>The site team may review, restrict, or remove content or accounts that appear to break these terms or harm the community. We may update, suspend, or discontinue parts of the service as the site changes.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Third-party links</h2>
                <p>Articles or pages may link to third-party websites. Those sites are operated independently, and their content and privacy practices are their own responsibility.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Changes to these terms</h2>
                <p>We may revise these terms when the service changes. The updated date above indicates when this page was last revised. Continued use of the site after a revision means you accept the updated terms.</p>
            </section>
            <section>
                <h2 class="h4 fw-bold">Contact</h2>
                <p class="mb-0">Questions about these terms? <a href="{{ route('pages.contact') }}">Contact the site team</a>.</p>
            </section>
        </article>
    </div>
@endsection
