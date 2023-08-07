// Do not load on IE. It reports Google Tag Manager errors.
if (!(/MSIE|Trident/.test(window.navigator.userAgent))) {
	Sentry.init({
		dsn: 'https://3489e43dd9a94631b39862d271996a66@o210094.ingest.sentry.io/1505679',

		// To set your release version
		release: 'smartteh@v1', //+ process.env.npm_package_version,
		// integrations: [new Integrations.BrowserTracing()],

		// Set tracesSampleRate to 1.0 to capture 100%
		// of transactions for performance monitoring.
		// We recommend adjusting this value in production
		tracesSampleRate: 1.0,

	});
}