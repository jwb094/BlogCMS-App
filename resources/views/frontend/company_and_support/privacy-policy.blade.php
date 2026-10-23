@extends('layouts.frontend-default-layout')
@section('title', 'Privacy Notice')

@section('content')
    <div class="container py-5">
        <header class="mb-5">
            <p class="text-primary fw-semibold text-uppercase small mb-2">Your information</p>
            <h1 class="display-5 fw-bold">Privacy Notice</h1>
            <p class="text-body-secondary">Last updated: 23 October 2026</p>
            <p class="lead text-body-secondary col-lg-9">
                This notice explains how {{ config('app.name') }} handles information when you browse the site,
                create an account, publish content, or contact the team.
            </p>
        </header>

        <article class="bg-white rounded-3 shadow-sm p-4 p-lg-5">
            <section class="mb-4">
                <h2 class="h4 fw-bold">Who operates this site?</h2>
                <p>{{ config('app.name') }} is operated by the site team. For privacy questions or requests, contact the team at <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Information we handle</h2>
                <ul>
                    <li>Account details such as your name, email address, and sign-in credentials.</li>
                    <li>Content you submit, including posts, comments, and uploaded images.</li>
                    <li>Messages and details you provide when contacting the site team.</li>
                    <li>Technical and security information generated when the site is used, such as session and request data.</li>
                </ul>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Why we use it</h2>
                <p>Information is used to create and manage accounts, publish and display content, moderate comments, respond to requests, maintain site security, and operate the service. The site does not use account details to send marketing unless a separate feature and appropriate choice are provided.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Legal grounds</h2>
                <p>Where UK data protection law applies, account information is used to provide the account and publishing features you request. Information may also be used where needed to meet legal obligations or for the site’s legitimate interests in keeping the service secure, preventing misuse, and moderating public content. If a feature relies on consent, you can withdraw that consent.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">How information is handled and shared</h2>
                <p>Information may be processed by providers that support the site’s hosting, storage, database, and email services. These providers receive information needed to perform those services. Information may also be disclosed where required by law or to protect the site and its users.</p>
                <p>We do not sell personal information. Public posts and comments may be visible to anyone who visits the site.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Retention and security</h2>
                <p>Account information is kept while an account is active. Posts, comments, and media are kept while needed to provide the publishing service or until they are removed, subject to any legal requirements. Technical records are kept for the period needed to operate the site, protect it, and investigate faults, then removed or anonymised.</p>
                <p>Reasonable technical and organisational measures are used to protect information. No online service can guarantee absolute security.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Cookies</h2>
                <p>The site may use essential session cookies to support sign-in and protect requests. Your browser can control or block cookies, though some account features may then stop working.</p>
            </section>
            <section class="mb-4">
                <h2 class="h4 fw-bold">Your choices and rights</h2>
                <p>You can update some account information through your profile. Depending on the laws that apply and the legal ground for a particular use, you may be able to request access to, correction of, or deletion of your personal information, restrict or object to some uses, or receive a copy of information you provided. You can withdraw consent where a use relies on consent. Contact the site team to make a request.</p>
                <p>If you are in the UK and are concerned about how your information is handled, you can complain to the <a href="https://ico.org.uk/make-a-complaint/data-protection-complaints/" target="_blank" rel="noopener noreferrer">Information Commissioner’s Office</a>.</p>
            </section>
            <section>
                <h2 class="h4 fw-bold">Updates to this notice</h2>
                <p class="mb-0">We may update this notice as the service or its data practices change. The date at the top of this page shows when it was last revised. We will explain significant changes on the site where appropriate.</p>
            </section>
        </article>
    </div>
@endsection
